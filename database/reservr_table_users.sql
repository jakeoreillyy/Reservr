
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `title` varchar(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL COMMENT 'Stores a jumbled up password rather than what the user entered, for safety purposes',
  `created_at` varchar(50) NOT NULL DEFAULT current_timestamp() COMMENT 'Timestamp for when the user registered their account'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table to store user data';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `title`, `first_name`, `surname`, `email`, `phone`, `address`, `city`, `country`, `password_hash`, `created_at`) VALUES
(3, 'Mr.', 'Jake', 'O\'Reilly', 'oreillyjake16@gmail.com', '0831234567', 'Fake address', 'Wicklow', 'Ireland', '$2y$10$bNO9cQ95M7mDU554x2Ran.8RcXXmDkd.uxlkWiu/jXLtB8gm1wRoS', '2025-11-10 00:08:59');
