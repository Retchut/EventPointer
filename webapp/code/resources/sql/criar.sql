


SET search_path TO lbaw2115;
-----------------------------------------
-- Types
-----------------------------------------
DROP TYPE  IF EXISTS EventState CASCADE;
CREATE TYPE EventState AS ENUM ('Scheduled','Ongoing','Canceled','Finished');

-----------------------------------------
-- Tables
-----------------------------------------

DROP TABLE IF EXISTS member CASCADE;
CREATE TABLE member
(
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    pass TEXT NOT NULL,
    profilePictureURL TEXT,
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE,
    registrationDate DATE NOT NULL DEFAULT CURRENT_DATE
);


DROP TABLE IF EXISTS event_tag CASCADE;
CREATE TABLE event_tag
(
    id SERIAL PRIMARY KEY,
    tagName TEXT NOT NULL UNIQUE
);


DROP TABLE IF EXISTS eventG CASCADE;
CREATE TABLE eventG
(
    id SERIAL PRIMARY KEY,
    eventName TEXT NOT NULL,
    startDate DATE NOT NULL,
    endDate DATE NOT NULL,
    place TEXT NOT NULL,
    duration FLOAT NOT NULL,
    eventState EventState NOT NULL,
    isPrivate BOOLEAN NOT NULL DEFAULT FALSE,
    tagID INTEGER NOT NULL REFERENCES event_tag(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT dates CHECK (startDate < endDate)
);


DROP TABLE IF EXISTS event_role CASCADE;
CREATE TABLE event_role
(
        id SERIAL PRIMARY KEY,
        memberId INTEGER NOT NULL REFERENCES member(id) ON DELETE RESTRICT ON UPDATE CASCADE,
        eventId INTEGER NOT NULL REFERENCES eventG(id) ON DELETE RESTRICT ON UPDATE CASCADE,
        isHost BOOLEAN NOT NULL
);

DROP TABLE IF EXISTS invite CASCADE;
CREATE TABLE invite
(
    id SERIAL PRIMARY KEY,
    participant INTEGER NOT NULL REFERENCES member(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    host INTEGER NOT NULL REFERENCES member(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    eventId INTEGER NOT NULL REFERENCES eventG(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CHECK (participant <> host)
);



DROP TABLE IF EXISTS ask_access CASCADE;
CREATE TABLE ask_access
(
    id SERIAL PRIMARY KEY,
    participant INTEGER NOT NULL REFERENCES member(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    eventId INTEGER NOT NULL REFERENCES eventG(id) ON DELETE RESTRICT ON UPDATE CASCADE
);


DROP TABLE IF EXISTS event_announcement CASCADE;
CREATE TABLE event_announcement
(
    id SERIAL PRIMARY KEY,
    messageA TEXT NOT NULL,
    role_id INTEGER NOT NULL REFERENCES event_role (id) ON DELETE RESTRICT ON UPDATE CASCADE

);

DROP TABLE IF EXISTS event_comment CASCADE;
CREATE TABLE event_comment
(
    id SERIAL PRIMARY KEY,
    messageC TEXT NOT NULL,
    role_id INTEGER NOT NULL REFERENCES event_role (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

DROP TABLE IF EXISTS event_poll CASCADE;
CREATE TABLE event_poll
(
    id SERIAL PRIMARY KEY,
    messageP TEXT NOT NULL,
    role_id INTEGER NOT NULL REFERENCES event_role (id) ON DELETE RESTRICT ON UPDATE CASCADE

);


DROP TABLE IF EXISTS poll_option CASCADE;
CREATE TABLE poll_option
(
    id SERIAL PRIMARY KEY,
    messagePO TEXT NOT NULL,
    pollId INTEGER NOT NULL REFERENCES event_poll (id) ON DELETE RESTRICT ON UPDATE CASCADE

);


DROP TABLE IF EXISTS vote CASCADE;
CREATE TABLE vote
(
    id SERIAL PRIMARY KEY,
    voteType BOOLEAN NOT NULL,
    event_roleId INTEGER NOT NULL REFERENCES event_role(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    commentId INTEGER REFERENCES event_comment (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    announcementId INTEGER REFERENCES event_announcement (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CHECK ((announcementId IS NOT NULL AND commentId IS NULL) OR (announcementId IS NULL AND commentId IS NOT NULL)) 
);


-----------------------------------------
-- Indexes
-----------------------------------------
DROP INDEX IF EXISTS event_state CASCADE;
CREATE INDEX event_state ON eventG USING hash (eventState);

DROP INDEX IF EXISTS end_event CASCADE;
CREATE INDEX end_event ON eventG USING btree (enddate);

DROP INDEX IF EXISTS start_event CASCADE;
CREATE INDEX start_event ON eventG USING btree (startdate);


-----------------------------------------
-- FTS Indexes
-----------------------------------------

-- Add column to event to store computed ts_vectors.
ALTER TABLE eventG
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
DROP FUNCTION IF EXISTS event_search_update() CASCADE;
CREATE FUNCTION event_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.eventName), 'A')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.name <> OLD.name) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.eventName), 'A')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on event.
DROP TRIGGER IF EXISTS event_search_update ON eventG CASCADE;
CREATE TRIGGER event_search_update
 BEFORE INSERT OR UPDATE ON eventG
 FOR EACH ROW
 EXECUTE PROCEDURE event_search_update();


-- Finally, create a GIN index for ts_vectors.
DROP INDEX IF EXISTS search_idx CASCADE;
CREATE INDEX search_idx ON eventG USING GIN (tsvectors);

-----------------------------------------
-- Triggers
-----------------------------------------

DROP FUNCTION IF EXISTS comment_in_event_poll() CASCADE;
CREATE FUNCTION comment_in_event_poll() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM eventG INNER JOIN event_role ON eventG.id = event_role.eventId INNER JOIN member ON event_role.memberId = member.id WHERE NEW.eventG.id = event_role.eventId AND NEW.member.id = event_role.memberId) THEN
           RAISE EXCEPTION 'A member can only comment in an event poll, if he is enrolled in that specific event.';
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
        IF EXISTS (SELECT * FROM eventG INNER JOIN event_role ON eventG.id = event_role.eventId INNER JOIN member ON event_role.memberId = member.id WHERE NEW.eventG.id = event_role.eventId AND NEW.member.id = event_role.memberId) THEN
           RAISE EXCEPTION 'A member can only delete a comment in an event poll, if he is enrolled in that specific event and the comment belongs to him.';
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
--        IF EXISTS (SELECT * FROM event_poll INNER JOIN event_role ON role_id = event_role.eventId INNER JOIN member ON event_role.memberId = member.id WHERE NEW.role_id = event_role.eventId AND NEW.member.id = event_role.memberId) THEN
--           RAISE EXCEPTION 'A member can only vote in an event poll, if he is enrolled in that specific event.';
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
        IF EXISTS (SELECT * FROM eventG INNER JOIN event_role ON eventG.id = event_role.eventId INNER JOIN member ON event_role.memberId = member.id WHERE NEW.eventG.id = event_role.eventId AND NEW.member.id = event_role.memberId) THEN
           RAISE EXCEPTION 'A member can only delete a vote in an event poll, if he is enrolled in that specific event and the comment belongs to him.';
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
        IF EXISTS (SELECT * FROM eventG WHERE NEW.id = id AND NEW.isPrivate = TRUE) THEN
           RAISE EXCEPTION ' Private events are not shown in search results.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS search_event ON event CASCADE;
CREATE TRIGGER search_event
        BEFORE INSERT OR UPDATE ON eventG
        FOR EACH ROW
        EXECUTE PROCEDURE search_event();


DROP FUNCTION IF EXISTS private_event_invite_only() CASCADE;
CREATE FUNCTION private_event_invite_only() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM ask_access WHERE NEW.eventId = eventId) THEN
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
        IF EXISTS (SELECT * FROM eventG WHERE NEW.id = id AND NEW.endDate > NEW.startDate AND NEW.startDate > CURRENT_DATE ) THEN
           RAISE EXCEPTION ' Ending event date needs to be after starting date and starting date also needs to be at least 1 day after event creation.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS event_schedule ON eventG CASCADE;
CREATE TRIGGER event_schedule
        BEFORE INSERT OR UPDATE ON eventG
        FOR EACH ROW
        EXECUTE PROCEDURE event_schedule();


DROP FUNCTION IF EXISTS edit_vote() CASCADE;
CREATE FUNCTION edit_vote() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM eventG INNER JOIN event_role ON eventG.id = event_role.eventId INNER JOIN member ON event_role.memberId = member.id WHERE NEW.eventG.id = event_role.eventId AND NEW.member.id = event_role.memberId) THEN
           RAISE EXCEPTION ' Only participating members can edit and vote on their own comments on the discussion of events.';
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
        IF EXISTS (SELECT * FROM member WHERE NEW.id = member.id ) THEN
           RAISE EXCEPTION ' Only members can delete their account.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS delete_acount ON member CASCADE;
CREATE TRIGGER delete_account
        BEFORE DELETE ON member
        FOR EACH ROW
        EXECUTE PROCEDURE delete_account();


DROP FUNCTION IF EXISTS delete_account_effects() CASCADE;
CREATE FUNCTION delete_account_effects() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM vote INNER JOIN event_role ON vote.event_roleId = event_role.id INNER JOIN member ON member.id = event_role.memberId WHERE NEW.event_roleId = vote.event_roleId AND event_role.memberId = member.id) THEN
           RAISE EXCEPTION 'Only votes from previous member will be deleted.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS delete_account_effects ON member CASCADE;
CREATE TRIGGER delete_account_effects
        AFTER DELETE ON member
        FOR EACH ROW
        EXECUTE PROCEDURE delete_account_effects();


-----------------------------------------
-- Transactions
-----------------------------------------

--BEGIN TRANSACTION
    --SELECT COUNT (*) AS member_found FROM member WHERE username= $username
    --IF member_found = 0
    --BEGIN
        --RETURN ERROR_NOT_FOUND
    --END                 
    --DELETE FROM member WHERE username = $username        
--COMMIT TRANSACTION