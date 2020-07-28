CREATE TABLE IF NOT EXIST 'Responses'
(
	'id' int auto_increment not null,
	'question_id' int,
	'user_id' int,
	'answer_id' int,
	'created' timestamp default current_timestamp,
	'modified' timestamp default current_timestamp on update current_timestamp,
	PRIMARY KEY ('id'),
	FOREIGN KEY('user_id') REFERENCES Users('id'),
	FOREIGN KEY ('question_id') REFERENCES Question('id')
	FOREIGN KEY ('answer_id') REFERENCES Answers('id')
	)