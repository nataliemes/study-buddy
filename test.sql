-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 21, 2024 at 06:57 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creation_date` date NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `user_id`, `name`, `description`, `creation_date`) VALUES
(1, 1, 'html', 'The standard markup language used to create and structure content on the web. HTML elements form the building blocks of web pages.', '2024-06-20'),
(2, 1, 'css', 'A stylesheet language used to describe the presentation of a document written in HTML or XML. CSS controls the layout, colors, fonts, and overall visual style of a web page.', '2024-06-20'),
(3, 1, 'javascript', 'A versatile programming language that allows you to implement complex features on web pages, such as interactive content, animations, form validations, and dynamic updates.', '2024-06-20'),
(5, 5, 'sql', 'A domain-specific language used in programming and designed for managing and manipulating relational databases. SQL is essential for backend development to handle database queries.', '2024-06-20'),
(6, 6, 'algebra', 'A branch of mathematics dealing with symbols and the rules for manipulating those symbols. It includes the study of equations, functions, and algebraic structures.', '2024-06-20'),
(9, 2, 'statistics', 'Statistics is the study of data collection, analysis, interpretation, and presentation. It helps in identifying patterns, making decisions, and predicting outcomes across various fields using tools li', '2024-06-21');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `feedback_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creation_date` date NOT NULL,
  PRIMARY KEY (`feedback_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `name`, `description`, `creation_date`) VALUES
(3, 2, 'Bug Report', 'I\'ve been experiencing a problem with logging in. Sometimes the login page doesn\'t load properly. Please look into this as it affects my ability to access the service.', '2024-06-21');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `file_path` varchar(256) NOT NULL,
  `creation_date` date NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `name`, `description`, `file_path`, `creation_date`) VALUES
(34, 2, 'Web basics: markup & style', 'Understanding the fundamentals of web development starts with mastering HTML and CSS. HTML (HyperText Markup Language) structures the content of a webpage, while CSS (Cascading Style Sheets) is used to style and layout the content, creating visually appealing and user-friendly websites. In this post, we\'ll explore the basics of HTML and CSS, demonstrating how they work together to form the foundation of web development.', 'stuff_on_html___css.pdf', '2024-06-21'),
(35, 4, 'Exploring JavaScript: Powering', 'JavaScript is a versatile programming language known for its ability to add interactivity and dynamic behavior to web pages. JavaScript, often abbreviated as JS, is a scripting language that enables developers to create interactive elements within web pages. It runs on the client side (in the user\'s browser) and is essential for building modern web applications. In this post, we\'ll delve into the fundamentals of JavaScript, exploring its key features and demonstrating how it enhances user experiences on the web.', 'things_about_js.pdf', '2024-06-21'),
(36, 5, 'The Language of Data Management', 'SQL, or Structured Query Language, is a domain-specific language used in programming and designed for managing data in relational database management systems (RDBMS). It allows users to perform tasks such as querying data, updating records, and defining database schema. In this post, we\'ll explore the basics of SQL, its key features, and how it enables efficient data management and retrieval.', 'discovering_sql.pdf', '2024-06-21'),
(37, 6, 'Bridging Algebra and Statistics', 'Algebra and statistics are foundational branches of mathematics that synergize to analyze and interpret data across various fields. In this post, we\'ll explore how algebraic principles enhance statistical analysis, providing insights into data trends, patterns, and relationships.', 'algebra_and_statistics.pdf', '2024-06-21'),
(38, 1, 'test', 'test', 'algebra_and_statistics (1).pdf', '2024-06-21');

-- --------------------------------------------------------

--
-- Table structure for table `post_category`
--

DROP TABLE IF EXISTS `post_category`;
CREATE TABLE IF NOT EXISTS `post_category` (
  `post_id` int NOT NULL,
  `category_id` int NOT NULL,
  KEY `post_id` (`post_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post_category`
--

INSERT INTO `post_category` (`post_id`, `category_id`) VALUES
(34, 1),
(34, 2),
(35, 3),
(36, 5),
(37, 6),
(37, 9);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password_hash` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `registration_date` date NOT NULL,
  `code` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password_hash`, `email`, `is_admin`, `registration_date`, `code`) VALUES
(1, 'natalie', '7b8b965ad4bca0e41ab51de7b31363a1', 'cnpnatalie@gmail.com', 1, '2024-06-12', ''),
(2, 'emma', 'e1671797c52e15f763380b45e841ec32', 'emma@gmail.com', 0, '2024-06-14', ''),
(3, 'jimmy', '363b122c528f54df4a0446b6bab05515', 'jimmy@gmail.com', 0, '2024-06-16', ''),
(4, 'anna', '0cc175b9c0f1b6a831c399e269772661', 'anna@gmail.com', 0, '2024-06-17', ''),
(5, 'marie', '6f8f57715090da2632453988d9a1501b', 'marie@gmail.com', 0, '2024-06-18', ''),
(6, 'samuel', '03c7c0ace395d80182db07ae2c30f034', 'samuel@gmail.com', 0, '2024-06-20', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_category`
--
ALTER TABLE `post_category`
  ADD CONSTRAINT `post_category_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
