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
    quantity_item INT NOT NULL,
    code_item VARCHAR(90) NOT NULL,
    price_item INT NOT NULL,
    sale_item BOOLEAN,
    category_item VARCHAR(45) NOT NULL
);
CREATE TABLE requests(
	id_request INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    fk_item INT NOT NULL,
	FOREIGN KEY (fk_item) REFERENCES stock(id_item),
    fk_user INT NOT NULL,
    FOREIGN KEY (fk_user) REFERENCES users(id_user),
    status_request ENUM ("Aprovado", "Recusado", "Não visto")
);

