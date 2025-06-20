-- Insert sample user
INSERT INTO users (name, email) VALUES 
('John Doe', 'john.doe@example.com');

-- Insert sample categories
INSERT INTO categories (name) VALUES 
('Fiction'),
('Science Fiction'),
('Non-Fiction'),
('Biography');

-- Insert sample books
INSERT INTO books (user_id, title, author, isbn) VALUES 
(1, 'The Martian', 'Andy Weir', '978-0-8041-3902-1'),
(1, 'Becoming', 'Michelle Obama', '978-1-5247-6313-8');

-- Assign categories to books
INSERT INTO book_category (book_id, category_id) VALUES 
(1, 1),  
(1, 2),  
(2, 3),  
(2, 4);  