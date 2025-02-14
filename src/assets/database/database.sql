CREATE DATABASE financial_control_system;
USE financial_control_system;

CREATE TABLE users(
	id_user INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name_user VARCHAR(45) NOT NULL,
	password_user TEXT NOT NULL,
    email_user VARCHAR(90) NOT NULL,
    isAdmin BOOLEAN NOT NULL,
    function_user VARCHAR(45) NOT NULL
);

CREATE TABLE stock(
	id_item INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name_item VARCHAR(45) NOT NULL,
    code_item VARCHAR(90) NOT NULL,
    price_item INT NOT NULL,
    sale_item BOOLEAN,
    category_item VARCHAR(45) NOT NULL
);
CREATE TABLE requests(
	id_request INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name_request VARCHAR(45) NOT NULL,
    code_request VARCHAR(90) NOT NULL,
    category_request VARCHAR(45) NOT NULL,
    approved_request ENUM ("Aprovado", "Recusado", "Não visto")
);


SELECT * FROM requests;
