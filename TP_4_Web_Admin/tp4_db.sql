CREATE DATABASE file_tree_db;

USE file_tree_db;

CREATE TABLE directories
(
	id INT AUTO_INCREMENT PRIMARY KEY,
	name varchar(128),
	parent varchar(128),
	path varchar(255)
);

CREATE TABLE files
(
	id INT AUTO_INCREMENT PRIMARY KEY,
	name varchar(128),
	parent varchar(128),
	type varchar(12),
	size INT,
	path varchar(255)
);

CREATE TABLE root
(
	path varchar(128)
);
