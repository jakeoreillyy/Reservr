
-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `book_title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `edition` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `genre` int(11) NOT NULL,
  `reserved` enum('Y','N') NOT NULL DEFAULT 'N',
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `isbn`, `book_title`, `author`, `edition`, `year`, `genre`, `reserved`, `image_path`) VALUES
(1, '9780747532699', 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 1, '1997', 1, 'N', 'assets/books/9780747532699.webp'),
(2, '9780747538493', 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', 2, '1998', 1, 'N', 'assets/books/9780747538493.webp'),
(3, '9780747542155', 'Harry Potter and the Prisoner of Azkaban', 'J.K. Rowling', 3, '1999', 1, 'N', 'assets/books/9780747542155.webp'),
(4, '9780747546245', 'Harry Potter and the Goblet of Fire', 'J.K. Rowling', 1, '2000', 1, 'N', 'assets/books/9780747546245.webp'),
(5, '9780747551003', 'Harry Potter and the Order of the Phoenix', 'J.K. Rowling', 2, '2003', 1, 'N', 'assets/books/9780747551003.webp'),
(6, '9780747581086', 'Harry Potter and the Half-Blood Prince', 'J.K. Rowling', 1, '2005', 1, 'N', 'assets/books/9780747581086.webp'),
(7, '9780747591054', 'Harry Potter and the Deathly Hallows', 'J.K. Rowling', 2, '2007', 1, 'N', 'assets/books/9780747591054.webp'),
(8, '9780261103344', 'The Hobbit', 'J.R.R. Tolkien', 3, '1937', 9, 'N', 'assets/books/9780261103344.webp'),
(9, '9780261102385', 'The Lord of the Rings', 'J.R.R. Tolkien', 2, '1954', 9, 'N', 'assets/books/9780261102385.webp'),
(10, '9780571334650', 'Normal People', 'Sally Rooney', 1, '2018', 3, 'N', 'assets/books/9780571334650.webp'),
(11, '9780441013593', 'Dune', 'Frank Herbert', 1, '1965', 2, 'N', 'assets/books/9780441013593.webp'),
(12, '9781451673319', 'Fahrenheit 451', 'Ray Bradbury', 2, '1953', 10, 'N', 'assets/books/9781451673319.webp'),
(13, '9780141199078', 'Pride and Prejudice', 'Jane Austen', 3, '0000', 3, 'N', 'assets/books/9780141199078.webp'),
(14, '9780553418026', 'The Martian', 'Andy Weir', 1, '2014', 2, 'N', 'assets/books/9780553418026.webp'),
(15, '9780385504201', 'The Da Vinci Code', 'Dan Brown', 2, '2003', 4, 'N', 'assets/books/9780385504201.webp'),
(16, '9781501142970', 'IT', 'Stephen King', 3, '1986', 6, 'N', 'assets/books/9781501142970.webp'),
(17, '9781785656461', 'The Turing Game', 'Christina Uss', 1, '2021', 4, 'N', 'assets/books/9781785656461.webp'),
(18, '9781853260240', 'Shogun', 'James Clavell', 2, '1975', 7, 'N', 'assets/books/9781853260240.webp'),
(19, '9780141185366', 'Endurance', 'Alfred Lansing', 1, '1959', 8, 'N', 'assets/books/9780141185366.webp'),
(20, '9780743222627', 'Touching the Void', 'Joe Simpson', 2, '1988', 8, 'N', 'assets/books/9780743222627.webp'),
(21, '9780451524935', '1984', 'George Orwell', 1, '1949', 10, 'N', 'assets/books/9780451524935.webp'),
(22, '9780439023528', 'The Hunger Games', 'Suzanne Collins', 2, '2008', 10, 'N', 'assets/books/9780439023528.webp'),
(23, '9780061122415', 'To Kill a Mockingbird', 'Harper Lee', 1, '1960', 5, 'N', 'assets/books/9780061122415.webp'),
(24, '9781529954227', 'Jane Eyre', 'Charlotte Brontë', 2, '0000', 3, 'N', 'assets/books/9781529954227.webp'),
(25, '9780099590088', 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 1, '2011', 8, 'N', 'assets/books/9780099590088.webp');
