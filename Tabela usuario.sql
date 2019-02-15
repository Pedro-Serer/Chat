CREATE TABLE usuario( 
	ID INT NOT NULL AUTO_INCREMENT, 
	nome VarChar(60), 
	PRIMARY KEY(ID), 
	CONSTRAINT nome_unico UNIQUE KEY (nome) 
);