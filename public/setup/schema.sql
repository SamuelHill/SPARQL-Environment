-- users

CREATE TABLE user (
	username varchar(50) PRIMARY KEY,
	name varchar(50) NOT NULL,
	salt varchar(16) NOT NULL,
	password varchar(64) NOT NULL,
	email varchar(100) NOT NULL,
	bio varchar(140)
);

-- datasets

CREATE TABLE dataset (
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(50) NOT NULL,
	description varchar(140) NOT NULL,
	source varchar(100) NOT NULL,
	prefix_list text,
	variable_list text
);

-- data_permissions

CREATE TABLE datapermission (
	data_id int NOT NULL,
	user_id varchar(50) NOT NULL,
	CONSTRAINT data_perm_fk
	FOREIGN KEY (data_id) REFERENCES dataset(id)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
	CONSTRAINT user_perm_fk
	FOREIGN KEY (user_id) REFERENCES user(username)
	ON UPDATE CASCADE
	ON DELETE CASCADE,
	PRIMARY KEY (data_id, user_id)
);

-- views

CREATE TABLE view (
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(50) NOT NULL,
	description varchar(140),
	user_id varchar(50) NOT NULL,
	plugin_doc_id varchar(50),
	history_doc_id varchar(50),
	CONSTRAINT user_view_fk
	FOREIGN KEY (user_id) REFERENCES user(username)
	ON UPDATE CASCADE
	ON DELETE CASCADE
);

-- plugins

CREATE TABLE plugin (
	urn varchar(140) NOT NULL PRIMARY KEY,
	name varchar(50) NOT NULL,
	description varchar(140) NOT NULL,
	config_doc_id varchar(50),
	owner varchar(50) NOT NULL,
	CONSTRAINT user_plugin_fk
	FOREIGN KEY (owner) REFERENCES user(username)
	ON UPDATE CASCADE
	ON DELETE CASCADE
);
