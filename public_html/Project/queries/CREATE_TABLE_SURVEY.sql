CREATE TABLE Survey
(
	SurveyID int auto_increment not null,
	question text,
	Option1 varchar(255),
	Option2 varchar(255),
	Option3 varchar(255),
	Option4 varchar(255),
	vote1 int(11),
	vote2 int(11),
	vote3 int(11),
	vote4 int(11),
	PRIMARY KEY(SurveyID)
)
