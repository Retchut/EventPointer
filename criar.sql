--PRAGMA FOREIGN_KEYS = ON;

-----------------------------------------
-- Types
-----------------------------------------
DROP TYPE  IF EXISTS EventState;
CREATE TYPE EventState AS ENUM ('Scheduled','Ongoing','Canceled','Finished');

-----------------------------------------
-- Tables
-----------------------------------------

DROP TABLE IF EXISTS member;
CREATE TABLE member
(
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    pass TEXT NOT NULL,
    profilePictureURL TEXT,
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE
);


DROP TABLE IF EXISTS event_tag;
CREATE TABLE event_tag
(
    id SERIAL PRIMARY KEY,
    tagName TEXT NOT NULL UNIQUE
);


DROP TABLE IF EXISTS event;
CREATE TABLE event
(
    id SERIAL PRIMARY KEY,
    eventName TEXT NOT NULL,
    startDate DATE NOT NULL,
    endDate DATE NOT NULL,
    place TEXT NOT NULL,
    duration FLOAT NOT NULL,
    state EventState NOT NULL,
    isPrivate BOOLEAN NOT NULL DEFAULT FALSE,
    tagId TEXT NOT NULL REFERENCES event_tag (tagName) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT dates CHECK (startDate < endDate)
);


DROP TABLE IF EXISTS event_announcement;
CREATE TABLE event_announcement
(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL,
    eventId INTEGER NOT NULL REFERENCES event (id) ON DELETE RESTRICT ON UPDATE CASCADE
);


DROP TABLE IF EXISTS event_comment;
CREATE TABLE event_comment
(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL,
    eventId INTEGER NOT NULL REFERENCES event (id) ON DELETE RESTRICT ON UPDATE CASCADE

);

DROP TABLE IF EXISTS event_poll;
CREATE TABLE event_poll
(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL,
    eventId INTEGER NOT NULL REFERENCES event (id) ON DELETE RESTRICT ON UPDATE CASCADE

);


DROP TABLE IF EXISTS poll_option;
CREATE TABLE poll_option
(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL,
    pollId INTEGER NOT NULL REFERENCES event_poll (id) ON DELETE RESTRICT ON UPDATE CASCADE

);

DROP TABLE IF EXISTS event_role;
CREATE TABLE event_role(
        memberId INTEGER NOT NULL REFERENCES member(id) ON DELETE RESTRICT ON UPDATE CASCADE,
        eventId INTEGER NOT NULL REFERENCES event(id) ON DELETE RESTRICT ON UPDATE CASCADE,
        isHost BOOLEAN NOT NULL,
        CONSTRAINT member_event_id PRIMARY KEY(memberId, eventId)
);


DROP TABLE IF EXISTS vote;
CREATE TABLE vote
(
    id SERIAL PRIMARY KEY,
    type BOOLEAN NOT NULL,
    participantId INTEGER NOT NULL REFERENCES member(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    commentId INTEGER REFERENCES event_comment (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    announcementId INTEGER REFERENCES event_announcement (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CHECK ((announcementId IS NOT NULL AND commentId IS NULL) OR (announcementId IS NULL AND commentId IS NOT NULL)) 
);


-----------------------------------------
-- Indexes
-----------------------------------------

CREATE INDEX event_state ON event USING hash (state);
CREATE INDEX end_event ON event USING btree (enddate);
CREATE INDEX start_event ON event USING btree (startdate);