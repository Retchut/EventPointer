
DROP SCHEMA IF EXISTS lbaw2115 CASCADE;
CREATE SCHEMA lbaw2115;
SET search_path TO lbaw2115;

-----------------------------------------
-- Types
-----------------------------------------
DROP TYPE  IF EXISTS eventstate CASCADE;
CREATE TYPE eventstate AS ENUM ('Scheduled','Ongoing','Canceled','Finished');

-----------------------------------------
-- Tables
-----------------------------------------

DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE users
(
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    profilepictureurl TEXT,
    isadmin BOOLEAN NOT NULL DEFAULT FALSE,
    registrationdate DATE NOT NULL DEFAULT CURRENT_DATE
);


DROP TABLE IF EXISTS event_tag CASCADE;
CREATE TABLE event_tag
(
    id SERIAL PRIMARY KEY,
    tagname TEXT NOT NULL UNIQUE
);


DROP TABLE IF EXISTS eventg CASCADE;
CREATE TABLE eventg
(
    id SERIAL PRIMARY KEY,
    eventname TEXT NOT NULL,
    startdate DATE NOT NULL,
    enddate DATE NOT NULL,
    place TEXT NOT NULL,
    duration FLOAT NOT NULL,
    eventstate eventstate NOT NULL,
    isprivate BOOLEAN NOT NULL DEFAULT FALSE,
    tagid INTEGER NOT NULL REFERENCES event_tag(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT dates CHECK (startdate < enddate)
);


DROP TABLE IF EXISTS event_role CASCADE;
CREATE TABLE event_role
(
        id SERIAL PRIMARY KEY,
        userid INTEGER NOT NULL REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE,
        eventid INTEGER NOT NULL REFERENCES eventg(id) ON DELETE RESTRICT ON UPDATE CASCADE,
        isHost BOOLEAN NOT NULL
);

DROP TABLE IF EXISTS invite CASCADE;
CREATE TABLE invite
(
    id SERIAL PRIMARY KEY,
    participant INTEGER NOT NULL REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    host INTEGER NOT NULL REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    eventid INTEGER NOT NULL REFERENCES eventg(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CHECK (participant <> host)
);



DROP TABLE IF EXISTS ask_access CASCADE;
CREATE TABLE ask_access
(
    id SERIAL PRIMARY KEY,
    participant INTEGER NOT NULL REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    eventid INTEGER NOT NULL REFERENCES eventg(id) ON DELETE RESTRICT ON UPDATE CASCADE
);


DROP TABLE IF EXISTS event_announcement CASCADE;
CREATE TABLE event_announcement
(
    id SERIAL PRIMARY KEY,
    messagea TEXT NOT NULL,
    role_id INTEGER NOT NULL REFERENCES event_role (id) ON DELETE RESTRICT ON UPDATE CASCADE

);

DROP TABLE IF EXISTS event_comment CASCADE;
CREATE TABLE event_comment
(
    id SERIAL PRIMARY KEY,
    messagec TEXT NOT NULL,
    role_id INTEGER NOT NULL REFERENCES event_role (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

DROP TABLE IF EXISTS event_poll CASCADE;
CREATE TABLE event_poll
(
    id SERIAL PRIMARY KEY,
    messagep TEXT NOT NULL,
    role_id INTEGER NOT NULL REFERENCES event_role (id) ON DELETE RESTRICT ON UPDATE CASCADE

);


DROP TABLE IF EXISTS poll_option CASCADE;
CREATE TABLE poll_option
(
    id SERIAL PRIMARY KEY,
    messagepo TEXT NOT NULL,
    pollId INTEGER NOT NULL REFERENCES event_poll (id) ON DELETE RESTRICT ON UPDATE CASCADE

);


DROP TABLE IF EXISTS vote CASCADE;
CREATE TABLE vote
(
    id SERIAL PRIMARY KEY,
    votetype BOOLEAN NOT NULL,
    event_roleid INTEGER NOT NULL REFERENCES event_role(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    commentid INTEGER REFERENCES event_comment (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    announcementid INTEGER REFERENCES event_announcement (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CHECK ((announcementid IS NOT NULL AND commentid IS NULL) OR (announcementid IS NULL AND commentid IS NOT NULL))
);


-----------------------------------------
-- Indexes
-----------------------------------------
DROP INDEX IF EXISTS event_state CASCADE;
CREATE INDEX event_state ON eventg USING hash (eventstate);

DROP INDEX IF EXISTS end_event CASCADE;
CREATE INDEX end_event ON eventg USING btree (enddate);

DROP INDEX IF EXISTS start_event CASCADE;
CREATE INDEX start_event ON eventg USING btree (startdate);


-----------------------------------------
-- FTS Indexes
-----------------------------------------

-- Add column to event to store computed ts_vectors.
ALTER TABLE eventg
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
DROP FUNCTION IF EXISTS event_search_update() CASCADE;
CREATE FUNCTION event_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.eventname), 'A')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.name <> OLD.name) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.eventname), 'A')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on event.
DROP TRIGGER IF EXISTS event_search_update ON eventg CASCADE;
CREATE TRIGGER event_search_update
 BEFORE INSERT OR UPDATE ON eventg
 FOR EACH ROW
 EXECUTE PROCEDURE event_search_update();


-- Finally, create a GIN index for ts_vectors.
DROP INDEX IF EXISTS search_idx CASCADE;
CREATE INDEX search_idx ON eventg USING GIN (tsvectors);

-----------------------------------------
-- Triggers
-----------------------------------------

DROP FUNCTION IF EXISTS comment_in_event_poll() CASCADE;
CREATE FUNCTION comment_in_event_poll() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM eventg INNER JOIN event_role ON eventg.id = event_role.eventid INNER JOIN users ON event_role.userid = users.id WHERE NEW.eventg.id = event_role.eventid AND NEW.users.id = event_role.userid) THEN
           RAISE EXCEPTION 'A users can only comment in an event poll, if he is enrolled in that specific event.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS comment_in_event_poll ON event_comment CASCADE;
CREATE TRIGGER delete_comment_in_event_poll
        BEFORE INSERT OR UPDATE ON event_comment
        FOR EACH ROW
        EXECUTE PROCEDURE comment_in_event_poll();


DROP FUNCTION IF EXISTS delete_comment_in_event_poll() CASCADE;
CREATE FUNCTION delete_comment_in_event_poll() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM eventg INNER JOIN event_role ON eventg.id = event_role.eventid INNER JOIN users ON event_role.userid = users.id WHERE NEW.eventg.id = event_role.eventid AND NEW.users.id = event_role.userid) THEN
           RAISE EXCEPTION 'A users can only delete a comment in an event poll, if he is enrolled in that specific event and the comment belongs to him.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS delete_comment_in_event_poll ON event_comment CASCADE;
CREATE TRIGGER delete_comment_in_event_poll
        BEFORE DELETE ON event_comment
        FOR EACH ROW
        EXECUTE PROCEDURE delete_comment_in_event_poll();


--DROP FUNCTION IF EXISTS vote_in_event_poll() CASCADE;
--CREATE FUNCTION vote_in_event_poll() RETURNS TRIGGER AS
--$BODY$
--BEGIN
--        IF EXISTS (SELECT * FROM event_poll INNER JOIN event_role ON role_id = event_role.eventid INNER JOIN users ON event_role.userid = users.id WHERE NEW.role_id = event_role.eventid AND NEW.users.id = event_role.userid) THEN
--           RAISE EXCEPTION 'A users can only vote in an event poll, if he is enrolled in that specific event.';
--        END IF;
--        RETURN NEW;
--END
--$BODY$
--LANGUAGE plpgsql;

--DROP TRIGGER IF EXISTS vote_in_event_poll ON event_poll CASCADE;
--CREATE TRIGGER vote_in_event_poll
--        BEFORE INSERT OR UPDATE ON event_poll
--        FOR EACH ROW
--        EXECUTE PROCEDURE vote_in_event_poll();


DROP FUNCTION IF EXISTS delete_vote_in_event_poll() CASCADE;
CREATE FUNCTION delete_vote_in_event_poll() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM eventg INNER JOIN event_role ON eventg.id = event_role.eventid INNER JOIN users ON event_role.userid = users.id WHERE NEW.eventg.id = event_role.eventid AND NEW.users.id = event_role.userid) THEN
           RAISE EXCEPTION 'A users can only delete a vote in an event poll, if he is enrolled in that specific event and the comment belongs to him.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS delete_vote_in_event_poll ON vote CASCADE;
CREATE TRIGGER delete_vote_in_event_poll
        BEFORE DELETE ON vote
        FOR EACH ROW
        EXECUTE PROCEDURE delete_vote_in_event_poll();


DROP FUNCTION IF EXISTS search_event() CASCADE;
CREATE FUNCTION search_event() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM eventg WHERE NEW.id = id AND NEW.isprivate = TRUE) THEN
           RAISE EXCEPTION ' Private events are not shown in search results.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS search_event ON event CASCADE;
CREATE TRIGGER search_event
        BEFORE INSERT OR UPDATE ON eventg
        FOR EACH ROW
        EXECUTE PROCEDURE search_event();


DROP FUNCTION IF EXISTS private_event_invite_only() CASCADE;
CREATE FUNCTION private_event_invite_only() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM ask_access WHERE NEW.eventid = eventid) THEN
           RAISE EXCEPTION ' Private events are invite only.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS private_event_invite_only ON ask_access CASCADE;
CREATE TRIGGER private_event_invite_only
        BEFORE INSERT OR UPDATE ON ask_access
        FOR EACH ROW
        EXECUTE PROCEDURE private_event_invite_only();


DROP FUNCTION IF EXISTS event_schedule() CASCADE;
CREATE FUNCTION event_schedule() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM eventg WHERE NEW.id = id AND NEW.enddate > NEW.startdate AND NEW.startdate > CURRENT_DATE ) THEN
           RAISE EXCEPTION ' Ending event date needs to be after starting date and starting date also needs to be at least 1 day after event creation.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS event_schedule ON eventg CASCADE;
CREATE TRIGGER event_schedule
        BEFORE INSERT OR UPDATE ON eventg
        FOR EACH ROW
        EXECUTE PROCEDURE event_schedule();


DROP FUNCTION IF EXISTS edit_vote() CASCADE;
CREATE FUNCTION edit_vote() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM eventg INNER JOIN event_role ON eventg.id = event_role.eventid INNER JOIN users ON event_role.userid = users.id WHERE NEW.eventg.id = event_role.eventid AND NEW.users.id = event_role.userid) THEN
           RAISE EXCEPTION ' Only participating userss can edit and vote on their own comments on the discussion of events.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS edit_vote ON vote CASCADE;
CREATE TRIGGER edit_vote
        BEFORE UPDATE ON vote
        FOR EACH ROW
        EXECUTE PROCEDURE edit_vote();


DROP FUNCTION IF EXISTS delete_account() CASCADE;
CREATE FUNCTION delete_account() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM users WHERE NEW.id = users.id ) THEN
           RAISE EXCEPTION ' Only userss can delete their account.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS delete_acount ON users CASCADE;
CREATE TRIGGER delete_account
        BEFORE DELETE ON users
        FOR EACH ROW
        EXECUTE PROCEDURE delete_account();


DROP FUNCTION IF EXISTS delete_account_effects() CASCADE;
CREATE FUNCTION delete_account_effects() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM vote INNER JOIN event_role ON vote.event_roleid = event_role.id INNER JOIN users ON users.id = event_role.userid WHERE NEW.event_roleid = vote.event_roleid AND event_role.userid = users.id) THEN
           RAISE EXCEPTION 'Only votes from previous users will be deleted.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS delete_account_effects ON users CASCADE;
CREATE TRIGGER delete_account_effects
        AFTER DELETE ON users
        FOR EACH ROW
        EXECUTE PROCEDURE delete_account_effects();


-----------------------------------------
-- Transactions
-----------------------------------------

--BEGIN TRANSACTION
    --SELECT COUNT (*) AS users_found FROM users WHERE username= $username
    --IF users_found = 0
    --BEGIN
        --RETURN ERROR_NOT_FOUND
    --END
    --DELETE FROM users WHERE username = $username
--COMMIT TRANSACTION


-----------------------------------------
-- Population
-----------------------------------------

insert into users (username, email, password, profilepictureurl,isadmin) values ('dcastillon0', 'flathwell0@forbes.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic',true);
insert into users (username, email, password, profilepictureurl,isadmin) values ('dfrowde1', 'nboulde1@netvibes.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic',true);
insert into users (username, email, password, profilepictureurl,isadmin) values ('chutson2', 'caddey2@illinois.edu', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic',true);
insert into users (username, email, password, profilepictureurl,isadmin) values ('bdarlasson3', 'mdawton3@google.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic',true);
insert into users (username, email, password, profilepictureurl,isadmin) values ('bdawson4', 'bredbourn4@baidu.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic',true);
insert into users (username, email, password, profilepictureurl) values ('bleitche5', 'hbowler5@mlb.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('lcreaser6', 'kfowells6@usnews.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('mdacres7', 'tmcgown7@miibeian.gov.cn', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('faslott8', 'lgallally8@desdev.cn', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('saery9', 'kgrovier9@printfriendly.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('kdonovina', 'wtavenera@rambler.ru', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('rsimenetb', 'jmarshamb@mashable.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('ssumnallc', 'clomasc@bbb.org', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('eboundeyd', 'kkieltyd@dell.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('rkimburyf', 'abazeleyf@posterous.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('sortigag', 'phachetteg@chicagotribune.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('hbuscombeh', 'kpatriah@answers.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('tbaishi', 'dcammackei@webs.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('rblanshardj', 'iferencj@nytimes.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('lplatfootk', 'idumberellk@mit.edu', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('sceschinil', 'lserchwelll@google.co.jp', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('mmottleym', 'pcasbournem@loc.gov', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('cknyvettn', 'ceveredn@nytimes.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('nsvaninio', 'ssmedleyo@umich.edu', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('ckaganq', 'mandreuttiq@nifty.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('rmanachr', 'bschlagtmansr@cocolog-nifty.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('pmassinghams', 'bcuvleys@miibeian.gov.cn', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('vsheart', 'jgheorghet@bbc.co.uk', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('jpolinu', 'jrollandu@irs.gov', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('sclackersrr', 'ufontenotrr@samsung.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');
insert into users (username, email, password, profilepictureurl) values ('testing', 'testing@testing.com', '$2a$06$I1SoT.xFQGG3IpSNrOWUXuTjl6Mb.1J6p4awu8b0YG8to4VL4bZEG', 'https://tinyurl.com/lbawprofilepic');


insert into event_tag (tagname) values ('Mudo');
insert into event_tag (tagname) values ('Yodoo');
insert into event_tag (tagname) values ('Dabfeed');
insert into event_tag (tagname) values ('Babbleopia');
insert into event_tag (tagname) values ('Voomm');
insert into event_tag (tagname) values ('Oyope');
insert into event_tag (tagname) values ('Aibox');
insert into event_tag (tagname) values ('Mynte');
insert into event_tag (tagname) values ('Wikido');
insert into event_tag (tagname) values ('Kazio');
insert into event_tag (tagname) values ('Fliptune');
insert into event_tag (tagname) values ('Roomm');
insert into event_tag (tagname) values ('Dynava');
insert into event_tag (tagname) values ('Quire');
insert into event_tag (tagname) values ('Gabtune');
insert into event_tag (tagname) values ('Browsezoom');
insert into event_tag (tagname) values ('Kwilith');
insert into event_tag (tagname) values ('Gigazoom');
insert into event_tag (tagname) values ('Aivee');
insert into event_tag (tagname) values ('Edgeclub');


insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Cuscuta denticulata Engelm. var. denticulata', '2021-05-31', '2021-08-24', 'Changqiao', 89.08, 'Scheduled', 1);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Quercus havardii Rydb. var. tuckeri S.L. Welsh', '2021-11-14', '2021-12-02', 'Sololá', 168.33, 'Scheduled', 2);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Brosimum Sw.','2021-02-18', '2021-10-15', 'Luyang', 75.24, 'Scheduled', 3);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Symphyotrichum pilosum (Willd.) G.L. Nesom', '2020-12-05', '2021-04-25', 'Chemnitz', 130.78, 'Scheduled', 4);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Aphanes arvensis L.', '2021-06-26', '2021-08-21', 'Mersa Matruh', 79.0, 'Scheduled', 5);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Cyanea purpurellifolia (Rock) Lammers, Givnish & Systma', '2021-06-15', '2021-07-17', 'Uherce Mineralne', 144.41, 'Scheduled', 6);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Cryptantha kelseyana Greene', '2021-11-16', '2021-12-05', 'Oral', 118.39, 'Scheduled', 7);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Gladiolus ×colvillei Sweet',  '2021-01-20', '2021-03-14', 'Jingning Chengguanzhen', 159.48, 'Scheduled', 8);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Arundina Blume', '2021-10-12', '2021-11-24', 'San Buenaventura', 24.53, 'Scheduled', 9);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Cypripedium kentuckiense C.F. Reed', '2021-04-20', '2021-12-12', 'Tanjungluar', 132.92, 'Scheduled', 10);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Livistona chinensis (Jacq.) R. Br. ex Mart.', '2021-09-03', '2021-09-24', 'Lagodekhi', 32.93, 'Scheduled', 11);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Schoenolirion Torr. ex Durand', '2021-02-05', '2021-02-18', 'Masku', 177.85, 'Scheduled', 12);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Trifolium israeliticum Zohary & Katzn.', '2021-07-26', '2021-12-06', 'Yabēlo', 167.64, 'Scheduled', 13);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Trisetum canescens Buckley',  '2021-05-19', '2021-06-07', 'Tarczyn', 58.07, 'Scheduled', 14);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Draba borealis DC.', '2021-09-17', '2021-09-20', 'Gualeguaychú', 174.62, 'Scheduled', 15);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Sparganium eurycarpum Engelm.', '2020-10-26', '2021-01-27', 'Itagüí', 34.47, 'Scheduled', 16);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Agave xylonacantha Salm-Dyck', '2021-05-11', '2021-10-30', 'Chengxiang', 146.11, 'Scheduled', 17);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Plagiomnium drummondii (Bruch & Schimp.) T. Kop.', '2021-02-28', '2021-09-29', 'Zavitinsk', 82.66, 'Scheduled', 18);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Thelypodium integrifolium (Nutt.) Endl. ex Walp. ssp. complanatum Al-Shehbaz', '2021-04-15', '2021-06-12', 'Batiovo', 91.19, 'Scheduled', 19);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Cotoneaster melanocarpus G. Lodd.', '2021-01-08', '2021-10-14', 'Looc', 86.41, 'Scheduled', 20);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Carex fracta Mack.',  '2021-03-22', '2021-10-02', 'Chak Two Hundred Forty-Nine TDA', 85.98, 'Finished', 4);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Aucuba Thunb.',  '2021-04-25', '2021-08-09', 'Sovetskaya Gavan’', 120.63, 'Finished', 1);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Alternanthera paronychioides A. St.-Hil. var. amazonica Huber','2021-01-21', '2021-01-24', 'Kembangkerang Lauk Timur', 120.17, 'Finished', 2);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Thelopsis melathelia Nyl.', '2021-01-01', '2021-01-06', 'Sankt Lorenzen im Mürztal', 147.2, 'Finished', 3);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Dubautia ciliolata (DC.) D.D. Keck ssp. glutinosa G.D. Carr', '2021-01-24', '2021-02-06', 'Nürnberg', 172.16, 'Canceled', 3);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Calycadenia villosa DC.',  '2021-01-04', '2021-06-07', 'Piedras', 90.02, 'Canceled', 4);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Arthonia pruinosella Nyl.', '2021-08-21', '2021-08-22', 'Cipari', 31.49, 'Canceled', 5);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Masonhalea Karnefelt',  '2021-01-03', '2021-05-22', 'Krosno Odrzańskie', 110.15, 'Canceled', 6);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Triphora craigheadii Luer',  '2021-01-25', '2021-03-20', 'Ampasimanolotra', 128.34, 'Canceled', 7);
insert into eventg (eventname, startdate, enddate, place, duration, eventstate, tagid) values ('Synthyris laciniata (A. Gray) Rydb.',  '2021-01-01', '2021-04-28', 'Sidi Yahia el Gharb', 103.45, 'Canceled', 8);


insert into event_role (userid, eventid, isHost) values (19, 1, true);
insert into event_role (userid, eventid, isHost) values (8, 4, false);
insert into event_role (userid, eventid, isHost) values (5, 18, true);
insert into event_role (userid, eventid, isHost) values (4, 17, false);
insert into event_role (userid, eventid, isHost) values (27, 25, true);
insert into event_role (userid, eventid, isHost) values (15, 17, false);
insert into event_role (userid, eventid, isHost) values (30, 10, true);
insert into event_role (userid, eventid, isHost) values (4, 21, true);
insert into event_role (userid, eventid, isHost) values (7, 11, true);
insert into event_role (userid, eventid, isHost) values (25, 29, false);
insert into event_role (userid, eventid, isHost) values (16, 7, false);
insert into event_role (userid, eventid, isHost) values (4, 12, true);
insert into event_role (userid, eventid, isHost) values (27, 23, false);
insert into event_role (userid, eventid, isHost) values (3, 26, true);
insert into event_role (userid, eventid, isHost) values (2, 6, true);
insert into event_role (userid, eventid, isHost) values (15, 12, false);
insert into event_role (userid, eventid, isHost) values (23, 30, true);
insert into event_role (userid, eventid, isHost) values (10, 28, false);
insert into event_role (userid, eventid, isHost) values (14, 14, false);
insert into event_role (userid, eventid, isHost) values (8, 2, true);
insert into event_role (userid, eventid, isHost) values (23, 22, true);
insert into event_role (userid, eventid, isHost) values (14, 1, false);
insert into event_role (userid, eventid, isHost) values (1, 27, true);
insert into event_role (userid, eventid, isHost) values (17, 5, true);
insert into event_role (userid, eventid, isHost) values (28, 27, false);
insert into event_role (userid, eventid, isHost) values (10, 22, false);
insert into event_role (userid, eventid, isHost) values (12, 11, false);
insert into event_role (userid, eventid, isHost) values (18, 13, false);
insert into event_role (userid, eventid, isHost) values (21, 23, true);
insert into event_role (userid, eventid, isHost) values (23, 9, true);
insert into event_role (userid, eventid, isHost) values (16, 20, true);
insert into event_role (userid, eventid, isHost) values (15, 21, false);
insert into event_role (userid, eventid, isHost) values (28, 21, false);
insert into event_role (userid, eventid, isHost) values (16, 9, false);
insert into event_role (userid, eventid, isHost) values (30, 19, true);
insert into event_role (userid, eventid, isHost) values (2, 24, true);
insert into event_role (userid, eventid, isHost) values (22, 17, true);
insert into event_role (userid, eventid, isHost) values (9, 7, true);
insert into event_role (userid, eventid, isHost) values (21, 15, true);
insert into event_role (userid, eventid, isHost) values (21, 8, true);
insert into event_role (userid, eventid, isHost) values (23, 1, false);
insert into event_role (userid, eventid, isHost) values (1, 16, true);
insert into event_role (userid, eventid, isHost) values (30, 7, false);
insert into event_role (userid, eventid, isHost) values (10, 15, false);
insert into event_role (userid, eventid, isHost) values (25, 14, true);
insert into event_role (userid, eventid, isHost) values (10, 13, true);
insert into event_role (userid, eventid, isHost) values (24, 28, true);
insert into event_role (userid, eventid, isHost) values (28, 3, true);
insert into event_role (userid, eventid, isHost) values (25, 4, true);
insert into event_role (userid, eventid, isHost) values (8, 29, true);


insert into invite (participant, host, eventid) values (30, 19, 1);
insert into invite (participant, host, eventid) values (1, 8, 29);
insert into invite (participant, host, eventid) values (28, 11, 11);
insert into invite (participant, host, eventid) values (2, 21, 15);
insert into invite (participant, host, eventid) values (10, 30, 10);


insert into ask_access (participant, eventid) values (25, 12);
insert into ask_access (participant, eventid) values (23, 17);
insert into ask_access (participant, eventid) values (12, 5);
insert into ask_access (participant, eventid) values (19, 8);
insert into ask_access (participant, eventid) values (27, 9);


insert into event_announcement (messagea, role_id) values ('Programmable contextually-based extranet', 1);
insert into event_announcement (messagea, role_id) values ('Upgradable mobile model', 10);
insert into event_announcement (messagea, role_id) values ('Operative system-worthy hardware', 12);
insert into event_announcement (messagea, role_id) values ('Optional bifurcated frame', 6);
insert into event_announcement (messagea, role_id) values ('Reduced empowering attitude', 10);
insert into event_announcement (messagea, role_id) values ('Integrated dynamic leverage', 27);
insert into event_announcement (messagea, role_id) values ('Front-line reciprocal leverage', 19);
insert into event_announcement (messagea, role_id) values ('Re-contextualized foreground forecast', 1);
insert into event_announcement (messagea, role_id) values ('Up-sized tertiary interface', 15);
insert into event_announcement (messagea, role_id) values ('Stand-alone asymmetric firmware', 19);
insert into event_announcement (messagea, role_id) values ('Profound analyzing project', 30);
insert into event_announcement (messagea, role_id) values ('Vision-oriented fresh-thinking installation', 14);
insert into event_announcement (messagea, role_id) values ('Visionary high-level matrices', 16);
insert into event_announcement (messagea, role_id) values ('Front-line interactive challenge', 21);
insert into event_announcement (messagea, role_id) values ('Realigned analyzing contingency', 19);


insert into event_comment (messagec, role_id) values ('Optimized encompassing parallelism', 7);
insert into event_comment (messagec, role_id) values ('Enterprise-wide methodical frame', 5);
insert into event_comment (messagec, role_id) values ('Fundamental 6th generation architecture', 8);
insert into event_comment (messagec, role_id) values ('Multi-channelled needs-based strategy', 2);
insert into event_comment (messagec, role_id) values ('Phased dynamic superstructure', 27);
insert into event_comment (messagec, role_id) values ('Fully-configurable 3rd generation solution', 5);
insert into event_comment (messagec, role_id) values ('Adaptive composite info-mediaries', 25);
insert into event_comment (messagec, role_id) values ('Decentralized attitude-oriented parallelism', 17);
insert into event_comment (messagec, role_id) values ('Proactive actuating support', 3);
insert into event_comment (messagec, role_id) values ('Configurable attitude-oriented process improvement', 10);
insert into event_comment (messagec, role_id) values ('Versatile composite array', 8);
insert into event_comment (messagec, role_id) values ('Virtual responsive capability', 13);
insert into event_comment (messagec, role_id) values ('Networked 6th generation project', 23);
insert into event_comment (messagec, role_id) values ('Self-enabling fault-tolerant migration', 11);
insert into event_comment (messagec, role_id) values ('Self-enabling exuding synergy', 25);


insert into event_poll (messagep, role_id) values ('Enhanced hybrid workforce', 24);
insert into event_poll (messagep, role_id) values ('Switchable needs-based superstructure', 30);
insert into event_poll (messagep, role_id) values ('Re-engineered didactic neural-net', 28);
insert into event_poll (messagep, role_id) values ('Integrated context-sensitive model', 8);
insert into event_poll (messagep, role_id) values ('Up-sized scalable policy', 22);
insert into event_poll (messagep, role_id) values ('Fully-configurable upward-trending capability', 18);
insert into event_poll (messagep, role_id) values ('Distributed demand-driven project', 29);
insert into event_poll (messagep, role_id) values ('Digitized stable hardware', 28);
insert into event_poll (messagep, role_id) values ('Synergistic solution-oriented conglomeration', 25);
insert into event_poll (messagep, role_id) values ('Stand-alone asymmetric matrix', 3);
insert into event_poll (messagep, role_id) values ('Digitized bifurcated flexibility', 16);
insert into event_poll (messagep, role_id) values ('Focused high-level customer loyalty', 19);
insert into event_poll (messagep, role_id) values ('Team-oriented web-enabled framework', 3);
insert into event_poll (messagep, role_id) values ('Ameliorated asynchronous task-force', 16);
insert into event_poll (messagep, role_id) values ('Pre-emptive modular product', 25);


insert into poll_option (messagepo, pollId) values ('Optional foreground software', 1);
insert into poll_option (messagepo, pollId) values ('Inverse cohesive array', 2);
insert into poll_option (messagepo, pollId) values ('Enhanced mission-critical open system', 3);
insert into poll_option (messagepo, pollId) values ('Assimilated global success', 4);
insert into poll_option (messagepo, pollId) values ('Reactive explicit attitude', 5);
insert into poll_option (messagepo, pollId) values ('Inverse exuding capacity', 6);
insert into poll_option (messagepo, pollId) values ('Ergonomic multimedia challenge', 7);
insert into poll_option (messagepo, pollId) values ('Realigned impactful firmware', 8);
insert into poll_option (messagepo, pollId) values ('Polarised executive open system', 9);
insert into poll_option (messagepo, pollId) values ('Integrated asynchronous attitude', 10);
insert into poll_option (messagepo, pollId) values ('Face to face intermediate framework', 11);
insert into poll_option (messagepo, pollId) values ('Automated national collaboration', 12);
insert into poll_option (messagepo, pollId) values ('Virtual secondary array', 13);
insert into poll_option (messagepo, pollId) values ('Polarised directional open system', 14);
insert into poll_option (messagepo, pollId) values ('Horizontal actuating open system', 15);


insert into vote (votetype, event_roleid, commentid, announcementid) values (true, 10, 2, NULL);
insert into vote (votetype, event_roleid, commentid, announcementid) values (false, 1, 9, NULL);
insert into vote (votetype, event_roleid, commentid, announcementid) values (true, 3, 15, NULL);
insert into vote (votetype, event_roleid, commentid, announcementid) values (false, 5, 3, NULL);
insert into vote (votetype, event_roleid, commentid, announcementid) values (true, 14, 9, NULL);
insert into vote (votetype, event_roleid, commentid, announcementid) values (false, 5, NULL, 6);
insert into vote (votetype, event_roleid, commentid, announcementid) values (false, 13, NULL, 10);
insert into vote (votetype, event_roleid, commentid, announcementid) values (true, 10, NULL, 3);
insert into vote (votetype, event_roleid, commentid, announcementid) values (false, 7, NULL, 12);
insert into vote (votetype, event_roleid, commentid, announcementid) values (false, 12, NULL, 4);
