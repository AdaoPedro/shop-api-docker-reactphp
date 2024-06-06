DROP DATABASE IF EXISTS shop;

CREATE DATABASE shop;

USE shop;

CREATE TABLE categories (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE products (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(9,2) NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT pk_category_id FOREIGN KEY (category_id) REFERENCES categories(id)
);


INSERT INTO categories(name) VALUES ("food");
INSERT INTO categories(name) VALUES ("computing");
INSERT INTO categories(name) VALUES ("school");
INSERT INTO categories(name) VALUES ("clothings");

INSERT INTO products(name, price, category_id) VALUES ("HP Laptop Core i5", 200, 2);
INSERT INTO products(name, price, category_id) VALUES ("iPhone XS", 20, 2);
INSERT INTO products(name, price, category_id) VALUES ("Bravo Blue Pen", 5, 3);