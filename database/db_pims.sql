-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2024 at 09:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(6) UNSIGNED NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `book_author` varchar(30) DEFAULT NULL,
  `book_price` decimal(7,2) NOT NULL,
  `book_category` varchar(30) DEFAULT NULL,
  `book_cover_link` varchar(1024) NOT NULL,
  `book_pages` int(6) DEFAULT NULL,
  `book_isbn_10` varchar(20) DEFAULT NULL,
  `book_isbn_13` varchar(20) DEFAULT NULL,
  `book_publication_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_name`, `book_author`, `book_price`, `book_category`, `book_cover_link`, `book_pages`, `book_isbn_10`, `book_isbn_13`, `book_publication_date`) VALUES
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

-- --------------------------------------------------------

--
-- Table structure for table `centralstore`
--

CREATE TABLE `centralstore` (
  `book_id` int(6) UNSIGNED NOT NULL,
  `stock` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `centralstore`
--

INSERT INTO `centralstore` (`book_id`, `stock`) VALUES
(2, 50),
(3, 50),
(4, 75),
(9, 10);

-- --------------------------------------------------------

--
-- Table structure for table `headoffice`
--

CREATE TABLE `headoffice` (
  `book_id` int(6) UNSIGNED NOT NULL,
  `stock` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `headoffice`
--

INSERT INTO `headoffice` (`book_id`, `stock`) VALUES
(2, 100),
(7, 50),
(3, 80),
(8, 40);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `role_id`) VALUES
('admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', '100'),
('author', 'ff9afc6ec2604a9cd14bf322afa7e58fcd52198a5e3ec6b2ee12529ca1d0d4ed08729a9efdb1e66d45343b34ea2d448ad688fa7ea847f4fa020ea988cb6c496e', '200'),
('customer', '154e75fd96b7267f1c852159dccbf194b8c45720e3b6ef3f3d192d731cb8ff03dedc20eec18f28085ab3e3dc3e5b402bd4a67e3174b8cd85fa519c68aac2cade', '400'),
('sysadmin', 'f6235735d47e6ccc82cc743bb0f4578e2f21572003d61e62c719fd9345101031e6aeed4b2ba8b059916b3764dac90fbdb6a0a88fe5fa7d7f483013a63cc089e0', '000'),
('user', 'b14361404c078ffd549c03db443c3fede2f3e534d73f78f77301ed97d4a436a9fd9db05ee8b325c0ad36438b43fec8510c204fc1c1edb21d0941c00e9e2c1ce2', '300');

-- --------------------------------------------------------

--
-- Table structure for table `outlet`
--

CREATE TABLE `outlet` (
  `book_id` int(6) UNSIGNED NOT NULL,
  `stock` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outlet`
--

INSERT INTO `outlet` (`book_id`, `stock`) VALUES
(2, 100),
(3, 50),
(6, 15),
(8, 100),
(9, 10);

-- --------------------------------------------------------

--
-- Table structure for table `permisison`
--

CREATE TABLE `permisison` (
  `permission_id` int(6) UNSIGNED NOT NULL,
  `role_id` varchar(10) NOT NULL,
  `permission_name` varchar(30) NOT NULL,
  `permission_module` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publish`
--

CREATE TABLE `publish` (
  `id` int(11) NOT NULL,
  `book_name` varchar(256) NOT NULL,
  `book_author` varchar(64) NOT NULL,
  `book_category` varchar(32) NOT NULL,
  `book_intro` text NOT NULL,
  `book_script` text DEFAULT NULL,
  `author_comment` text DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publish`
--

INSERT INTO `publish` (`id`, `book_name`, `book_author`, `book_category`, `book_intro`, `book_script`, `author_comment`, `status`) VALUES
(1, 'Test Book', 'Author', 'Test Category', 'Test Intro', 'Test Script', 'Test Comment', 0),
(2, 'Humpty Dumpty', 'Author', 'Poem', 'A poem about a person named Humpty.', 'Humpy Dumpty sat of a wall,\r\nHumpty Dumpty had a great fall.\r\n\r\n...', 'Will send the rest via email if you want to publish.', 2),
(3, 'Test Book Name', 'Test Author', 'Test Category', 'Test Intro', 'Test Script', 'Test Comment', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` varchar(10) NOT NULL,
  `role_name` varchar(30) NOT NULL,
  `role_description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `role_description`) VALUES
('000', 'ADMINISTRATOR', 'ADMINISTRATOR'),
('100', 'ADMIN', 'ADMIN'),
('200', 'AUTHOR', 'AUTHOR'),
('300', 'USER', 'USER'),
('400', 'CUSTOMER', 'CUSTOMER');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `invoice_id` int(6) UNSIGNED NOT NULL,
  `book_id` int(6) UNSIGNED NOT NULL,
  `sales_date` date NOT NULL,
  `quantity` int(6) NOT NULL,
  `transaction_amount` decimal(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`invoice_id`, `book_id`, `sales_date`, `quantity`, `transaction_amount`) VALUES
(1, 2, '2024-01-28', 10, 2000.00),
(2, 3, '2024-01-21', 15, 7500.00),
(3, 6, '2024-01-25', 20, 9000.00),
(4, 8, '0000-00-00', 5, 1000.00);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `transfer_id` int(6) UNSIGNED NOT NULL,
  `book_id` int(6) UNSIGNED NOT NULL,
  `transfer_date` date NOT NULL,
  `quantity` int(6) NOT NULL,
  `from_stock` varchar(30) NOT NULL,
  `to_stock` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_phone` varchar(14) NOT NULL,
  `user_email` varchar(30) DEFAULT NULL,
  `user_address` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_name`, `user_phone`, `user_email`, `user_address`) VALUES
(1, 'sysadmin', 'System Administrator', '+8001234567890', 'sysadmin@admin', 'Administhan'),
(2, 'admin', 'Admin', '', 'admin@admin', 'Administhan'),
(3, 'user', 'User', '+8801000000000', 'user@email', ''),
(6, 'customer', 'Customer', '', 'customer@email', NULL),
(7, 'author', 'Author', '+8801234567890', 'author@email', 'Dhaka');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `centralstore`
--
ALTER TABLE `centralstore`
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `headoffice`
--
ALTER TABLE `headoffice`
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `check_unique_username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `outlet`
--
ALTER TABLE `outlet`
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `permisison`
--
ALTER TABLE `permisison`
  ADD PRIMARY KEY (`permission_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `publish`
--
ALTER TABLE `publish`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`transfer_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `permisison`
--
ALTER TABLE `permisison`
  MODIFY `permission_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publish`
--
ALTER TABLE `publish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `invoice_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `transfer_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `centralstore`
--
ALTER TABLE `centralstore`
  ADD CONSTRAINT `fk_centralstore_book_book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `headoffice`
--
ALTER TABLE `headoffice`
  ADD CONSTRAINT `fk_headoffice_book_book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `fk_login_role_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

--
-- Constraints for table `outlet`
--
ALTER TABLE `outlet`
  ADD CONSTRAINT `fk_outlet_book_book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permisison`
--
ALTER TABLE `permisison`
  ADD CONSTRAINT `permisison_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_login_username` FOREIGN KEY (`username`) REFERENCES `login` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
