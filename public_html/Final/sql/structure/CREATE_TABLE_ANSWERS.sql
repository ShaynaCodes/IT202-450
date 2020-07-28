CREATE TABLE IF NOT EXIST 'Answers'
(
	'id' int auto_increment not null,
	'answer' varchar(240),
	'user_id' int,
	'question_id' int,
	'created' timestamp default current_timestamp,
	'modified' timestamp default current_timestamp on update current_timestamp,
	PRIMARY KEY ('id'),
	FOREIGN KEY('user_id') REFERENCES User('id'),
	FOREIGN KEY ('question_id') REFERENCES Questions('id')
	)