CREATE TABLE IF NOT EXISTS 'Queationnaires'
(
	'id' inti auto_increment not null,
	'name' varchar(120),
	'description' TEXT,
	'uesr_id' int,
	'max_attempts' int default 1,
	'created' timestamp default current_timestamp,
	'modified' timestamp default current_timestamp on update current_timestamp,
	PRIMARY KEY ('id'),
	FOREIGN KEY ('user_id') REFERENCES Users('id')
	)
	