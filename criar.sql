--PRAGMA FOREIGN_KEYS = ON;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE EventState AS ENUM {'Scheduled','Ongoing','Canceled','Finished'};
CREATE TYPE OAuthServices AS ENUM {'Steam','Origin','Battle Net','Google','None'}

-----------------------------------------
-- Tables
-----------------------------------------

DROP TABLE IF EXISTS Member;
CREATE TABLE Member
(
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    pass TEXT NOT NULL,
    profilePictureURL TEXT,
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE
);

DROP TABLE IF EXISTS Event;
CREATE TABLE Event
(
    id SERIAL PRIMARY KEY,
    eventName TEXT NOT NULL,
    startDate DATE NOT NULL,
    endDate DATE NOT NULL,
    place TEXT NOT NULL,
    duration FLOAT NOT NULL,
    TYPE EventState NOT NULL,
    isPrivate BOOLEAN NOT NULL DEFAULT FALSE,
    tag TEXT NOT NULL REFERENCES EventTag (tagName) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT dates CHECK (startDate < endDate)
    );


DROP TABLE IF EXISTS EventTag;
CREATE TABLE EventTag
(
    id SERIAL PRIMARY KEY,
    tagName TEXT NOT NULL UNIQUE,
);

DROP TABLE IF EXISTS EventAnnouncement;
CREATE TABLE EventAnnouncement
(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL UNIQUE,
    event INTEGER NOT NULL REFERENCES Event (id) ON DELETE RESTRICT ON UPDATE CASCADE
);


DROP TABLE IF EXISTS EventComment;
CREATE TABLE EventComment
(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL UNIQUE,
    event INTEGER NOT NULL REFERENCES Event (id) ON DELETE RESTRICT ON UPDATE CASCADE

);

DROP TABLE IF EXISTS EventPoll;
CREATE TABLE EventPoll
(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL UNIQUE,
    event INTEGER NOT NULL REFERENCES Event (id) ON DELETE RESTRICT ON UPDATE CASCADE

);


DROP TABLE IF EXISTS PollOption;
CREATE TABLE PollOption
(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL UNIQUE,
    poll INTEGER NOT NULL REFERENCES EventPoll (id) ON DELETE RESTRICT ON UPDATE CASCADE

);

/* //TODO
EventHost, EventParticipant, Vote Tables
Ligar participante/ host a comment e announcement (?) e fazer verificação
verificar constantes
Adicionar OAuthServices
*/
