CREATE TABLE Survey
(
	SurveyID int auto_increment not null,
	title varchar(30) not null unique,
	visibility int, -- DRAFT 0, Private 1, Publish 2
	question text,
	Option1 varchar(255),
	Option2 varchar(255),
	Option3 varchar(255),
	Option4 varchar(255),
	PRIMARY KEY(SurveyID)
)
