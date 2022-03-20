CREATE DATABASE my_images;

USE my_images;

CREATE TABLE images
(
	id INT NOT NULL PRIMARY KEY,
  	name varchar(120),
  	type varchar(6),
  	size INT,
  	dt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
