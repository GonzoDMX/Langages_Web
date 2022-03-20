CREATE DATABASE file_tree_db;

USE file_tree_db;

CREATE TABLE directories
(
	id INT AUTO_INCREMENT PRIMARY KEY,
	name varchar(64),
	parent varchar(64),
	path varchar(255)
);

CREATE TABLE files
(
	id INT AUTO_INCREMENT PRIMARY KEY,
	name varchar(120),
	parent varchar(64),
	type varchar(6),
	size INT,
	path varchar(255)
);

