CREATE TABLE Responses{
	id int auto_increment,
	question_id int,
	answer_id int,
	user_id int,
	PRIMARY KEY(id),
	FOREIGN KEY(question_id) REFERENCES Question_id,
	FOREIGN KEY(answer_id_id) REFERENCES Answer_id,
	FOREIGN KEY(user_id) REFERENCES User_id,
	UNIQUE(question_id,answer_id,user_id)

}
	
	