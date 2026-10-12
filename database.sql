CREATE DATABASE IF NOT EXISTS bookstore;
USE bookstore;
CREATE TABLE users(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(80) NOT NULL,email VARCHAR(100) UNIQUE NOT NULL,password VARCHAR(255) NOT NULL,role ENUM('user','admin') DEFAULT 'user');
CREATE TABLE books(id INT AUTO_INCREMENT PRIMARY KEY,title VARCHAR(150) NOT NULL,author VARCHAR(100) NOT NULL,category VARCHAR(50),price DECIMAL(8,2) NOT NULL,stock INT DEFAULT 10,description TEXT);
CREATE TABLE orders(id INT AUTO_INCREMENT PRIMARY KEY,user_id INT NOT NULL,total DECIMAL(10,2),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(user_id) REFERENCES users(id));
CREATE TABLE order_items(id INT AUTO_INCREMENT PRIMARY KEY,order_id INT,book_id INT,qty INT,price DECIMAL(8,2),FOREIGN KEY(order_id) REFERENCES orders(id),FOREIGN KEY(book_id) REFERENCES books(id));
INSERT INTO books(title,author,category,price,stock,description) VALUES
('Wings of Fire','A.P.J. Abdul Kalam','Autobiography',250,15,'Life story of the Missile Man of India.'),
('Ponniyin Selvan','Kalki Krishnamurthy','Fiction',599,10,'Classic Tamil historical novel on the Chola dynasty.'),
('Clean Code','Robert C. Martin','Technology',799,8,'A handbook of agile software craftsmanship.'),
('Let Us C','Yashavant Kanetkar','Technology',450,20,'Popular book for learning C programming.'),
('The Alchemist','Paulo Coelho','Fiction',299,12,'A shepherd boy follows his dream.'),
('Atomic Habits','James Clear','Self-Help',399,18,'Small changes, remarkable results.');
