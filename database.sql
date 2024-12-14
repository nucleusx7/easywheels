-- query to create a new table inside a database

CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    fullname VARCHAR(100) NOT NULL,
    contact VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);





-- sql for bicycle table
CREATE TABLE bicycles (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    rate INT(11) NOT NULL,
    PRIMARY KEY (id)
);

-- INSERT INTO bicycles (name, description, rate)
-- VALUES ('Mountain Bike', 'A rugged mountain bike suitable for off-road trails.', 15),
--        ('Road Bike', 'A lightweight road bike perfect for speed and long-distance rides.', 12),
--        ('Hybrid Bike', 'A versatile bike designed for both city and off-road use.', 10);







