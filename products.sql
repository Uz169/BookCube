use websql;
show tables;
CREATE TABLE products (
    product_id INT NOT NULL AUTO_INCREMENT,
    product_name VARCHAR(255) NOT NULL,
    product_price INT NOT NULL,
    author VARCHAR(255),
    PRIMARY KEY (product_id)
);

INSERT INTO products (product_name, product_price, author)
VALUES ("Coraline", 50, "Neil Gaiman"),
	   ("Animal Farm", 50, "George Orwell"),
	   ("Memoirs of a Geisha", 50, "Arthur Golden"),
       ("The Husband I Bought", 50, "Ayn Rand"),
       ("To Kill A Mockingbird", 50, "Harper Lee"),
	   ("1984", 100, "George Orwell"),
       ("Murder On The Orient Express", 100, "Agatha Cristie"),
	   ("The Body Under The Piano", 25, "Marthe Jocelyn"),
	   ("Phantom Of The Opera", 150, "Gaston Leroux"),
	   ("Learn Linux Quickly", 50, "Paul H Bartley"),
	   ("Монголын нууц товчоо", 50, "blank"),
	   ("The Richest Man In Babylon", 50, "George Clason");

Select * from products;
