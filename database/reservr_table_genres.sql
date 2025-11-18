
-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `genre_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_description`) VALUES
(9, 'Adventure'),
(10, 'Dystopian'),
(1, 'Fantasy'),
(7, 'Historical Fiction'),
(6, 'Horror'),
(4, 'Mystery'),
(8, 'Non-fiction'),
(3, 'Romance'),
(2, 'Science Fiction'),
(5, 'Thriller');
