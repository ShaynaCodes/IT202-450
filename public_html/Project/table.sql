CREATE TABLE Survey
(
	Username varchar(60) NOT NULL,
	Email varchar(120) NOT NULL UNIQUE,
	Password varchar(120),
	First_name varchar(50) NOT NULL,
	Last_name varchar(50) NOT NULL,
	AGE INT,
	Phone varchar(25),
	State varchar(2),
	PRIMARY KEY(Username)
);
