USE bookstore_db;

-- Clean and reset
DELETE FROM order_item;
DELETE FROM `order`;
DELETE FROM book;
DELETE FROM author;

ALTER TABLE book AUTO_INCREMENT = 1;
ALTER TABLE author AUTO_INCREMENT = 1;

-- Authors (30)
INSERT INTO author (author_name, nationality) VALUES
('Jane Austen','British'),
('Charles Dickens','British'),
('George Orwell','British'),
('F. Scott Fitzgerald','American'),
('Leo Tolstoy','Russian'),
('Mark Twain','American'),
('J. R. R. Tolkien','British'),
('J. K. Rowling','British'),
('C. S. Lewis','British'),
('George R. R. Martin','American'),
('Brandon Sanderson','American'),
('Ursula K. Le Guin','American'),
('Agatha Christie','British'),
('Arthur Conan Doyle','British'),
('Gillian Flynn','American'),
('Dan Brown','American'),
('Stieg Larsson','Swedish'),
('Tana French','Irish'),
('Isaac Asimov','American'),
('Arthur C. Clarke','British'),
('Frank Herbert','American'),
('Ray Bradbury','American'),
('Philip K. Dick','American'),
('Douglas Adams','British'),
('Charlotte Bronte','British'),
('Emily Bronte','British'),
('Nicholas Sparks','American'),
('John Green','American'),
('Jojo Moyes','British'),
('Khaled Hosseini','Afghan-American');

-- Books (30)
INSERT INTO book (title, price, genre, stock_count, author_id) VALUES
('Pride and Prejudice',320.00,'Classic',12,1),
('Great Expectations',310.00,'Classic',10,2),
('1984',299.00,'Dystopian',14,3),
('The Great Gatsby',280.00,'Classic',11,4),
('War and Peace',499.00,'Classic',6,5),
('The Adventures of Tom Sawyer',260.00,'Classic',13,6),
('The Hobbit',360.00,'Fantasy',12,7),
('Harry Potter and the Sorcerer''s Stone',399.00,'Fantasy',15,8),
('The Lion, the Witch and the Wardrobe',300.00,'Fantasy',10,9),
('A Game of Thrones',450.00,'Fantasy',9,10),
('Mistborn',380.00,'Fantasy',8,11),
('A Wizard of Earthsea',340.00,'Fantasy',7,12),
('Murder on the Orient Express',299.00,'Mystery',12,13),
('The Hound of the Baskervilles',279.00,'Mystery',10,14),
('Gone Girl',350.00,'Mystery',9,15),
('The Da Vinci Code',349.00,'Mystery',11,16),
('The Girl with the Dragon Tattoo',360.00,'Mystery',8,17),
('In the Woods',320.00,'Mystery',7,18),
('Foundation',330.00,'Sci-Fi',10,19),
('2001: A Space Odyssey',310.00,'Sci-Fi',9,20),
('Dune',399.00,'Sci-Fi',10,21),
('Fahrenheit 451',290.00,'Sci-Fi',12,22),
('Do Androids Dream of Electric Sheep?',320.00,'Sci-Fi',7,23),
('The Hitchhiker''s Guide to the Galaxy',299.00,'Sci-Fi',11,24),
('Jane Eyre',310.00,'Romance',10,25),
('Wuthering Heights',300.00,'Romance',9,26),
('The Notebook',280.00,'Romance',12,27),
('The Fault in Our Stars',260.00,'Romance',11,28),
('Me Before You',300.00,'Romance',10,29),
('A Thousand Splendid Suns',320.00,'Romance',8,30);
