-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2024 at 09:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


INSERT INTO `books` (`book_id`, `book_name`, `book_author`, `book_price`, `book_genre`, `book_cover_link`, `book_pages`, `book_isbn_10`, `book_isbn_13`, `book_publication_date`) VALUES
(2, 'The Alchemist', 'Paulo Coelho', 200.00, 'Novel', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1654371463i/18144590.jpg', NULL, NULL, NULL, NULL),
(3, 'Sherlock Holmes', 'Arthur Conan Doyle', 500.00, 'Novel', 'https://pictures.abebooks.com/inventory/31095529984.jpg', NULL, NULL, NULL, NULL),
(4, 'Harry Potter', 'J. K. Rowling', 1000.00, 'Novel', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1633472105i/59223802.jpg', NULL, NULL, NULL, NULL),
(6, 'The Theory of Everything', 'Stephen Hawking', 350.00, 'Science', 'https://www.bottomscience.com/wp-content/uploads/2021/06/the-theory-of-everything.jpg', 0, '', '', '0000-00-00'),
(7, 'Atomic Habits', 'James Clear', 250.00, 'Self-Help', 'https://m.media-amazon.com/images/I/81YkqyaFVEL._SL1500_.jpg', NULL, NULL, NULL, NULL),
(8, 'The Old Man and the Sea', 'Ernest Hemingway', 200.00, 'Novel', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1682515263i/141686298.jpg', NULL, NULL, NULL, NULL),
(9, 'Web Coding & Development - Dummies', 'Paul McFedries', 300.00, 'Programming', 'https://m.media-amazon.com/images/I/81gcvKAAsjL._AC_UF1000,1000_QL80_.jpg', NULL, NULL, NULL, NULL),
(10, 'The Art of War', 'Sun Tzu', 150.00, 'Strategy', 'https://d28hgpri8am2if.cloudfront.net/book_images/onix/cvr9781626860605/the-art-of-war-9781626860605_hr.jpg', NULL, NULL, NULL, NULL),
(17, 'Digital Logic and Computer Design', 'M. Morris Mano', 180.00, 'Textbook', 'https://easyengineering.net/wp-content/uploads/2018/03/digital-logic-computer-design-original-imadbn5y4vdhbr4q.jpeg', 550, '0132145103', '9789332542525', '1979-01-01'),
(18, 'Humpty Dumpty', 'Author', 50.00, 'Poem', 'https://d10j3mvrs1suex.cloudfront.net/u/390857/8c099148f062e1c33a90b66574aa33896dc08056/original/humpty300.jpg/!!/b%3AWyJyZXNpemU6NjAweDY4NiJd.jpg', 20, '', '', '2024-02-13');
