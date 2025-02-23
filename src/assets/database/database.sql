CREATE DATABASE financial_control_system;
USE financial_control_system;

CREATE TABLE users(
	id_user INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name_user VARCHAR(45) NOT NULL,
	password_user TEXT NOT NULL,
    email_user VARCHAR(90) NOT NULL,
    isAdmin BOOLEAN NOT NULL,
    type_user ENUM("Usuário", "Funcionário") NOT NULL
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

CREATE TABLE company_balance (
    id_balance INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    total_balance DECIMAL(10,2) NOT NULL DEFAULT 0.00
);

CREATE TABLE company_transactions (
    id_transaction INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    type_transaction ENUM("Entrada", "Saída") NOT NULL,
	fk_item INT NOT NULL,
	FOREIGN KEY (fk_item) REFERENCES stock(id_item),
    amount DECIMAL(10,2) NOT NULL,
    description TEXT NOT NULL,
    date_transaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name_user, password_user, email_user, isAdmin, type_user) VALUES ("admin", "admin", "admin@admin", 1, "Funcionário");
INSERT INTO users (name_user, password_user, email_user, isAdmin, type_user) VALUES ("user", "user", "user@user", 0, "Funcionário");

INSERT INTO company_balance (total_balance) VALUES (100000.00);
INSERT INTO stock (name_item, quantity_item, code_item, price_item, sale_item, category_item) VALUES
('Mouse Gamer', 50, 'MG12345', 150, 0, 'Periféricos'),
('Teclado Mecânico', 30, 'TM67890', 300, 0, 'Periféricos'),
('Monitor Full HD', 20, 'MFHD1122', 800, 0, 'Monitores'),
('Cadeira Gamer', 15, 'CG3344', 1200, 0, 'Móveis'),
('Notebook i5', 10, 'NB5566', 3500, 0, 'Informática'),
('Placa de Vídeo RTX 3060', 8, 'PVRTX3060', 2500, 0, 'Hardware'),
('HD Externo 1TB', 25, 'HDEX1TB', 400, 0, 'Armazenamento'),
('Memória RAM 16GB', 40, 'MR16GB', 350, 0, 'Hardware'),
('Fonte 650W', 18, 'F650W', 450, 0, 'Energia'),
('Headset Gamer', 35, 'HG9988', 200, 0, 'Periféricos');

INSERT INTO requests (fk_item, fk_user, status_request) VALUES
(1, 1, 'Não visto'),
(3, 1, 'Aprovado'),
(5, 1, 'Recusado'),
(7, 1, 'Aprovado'),
(9, 1, 'Não visto');

INSERT INTO users (name_user, password_user, email_user, isAdmin, type_user) VALUES
('Carlos Silva', 'senha123', 'carlos.silva@email.com', 0, 'Funcionário'),
('Ana Souza', 'senha456', 'ana.souza@email.com', 0, 'Funcionário'),
('Roberto Lima', 'senha789', 'roberto.lima@email.com', 0, 'Funcionário'),
('Mariana Costa', 'senha101', 'mariana.costa@email.com', 0, 'Funcionário'),
('Fernanda Alves', 'senha202', 'fernanda.alves@email.com', 0, 'Funcionário'),
('João Pereira', 'senha303', 'joao.pereira@email.com', 0, 'Usuário'),
('Beatriz Mendes', 'senha404', 'beatriz.mendes@email.com', 0, 'Usuário'),
('Lucas Oliveira', 'senha505', 'lucas.oliveira@email.com', 0, 'Usuário');



