-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2024 at 10:30 AM
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
-- Database: `user_auth_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date_start` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ticket_price` char(10) DEFAULT NULL,
  `event_time_start` time DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `max_participants` int(11) NOT NULL,
  `event_status` enum('available','full') DEFAULT 'available',
  `event_pic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `event_date_end` varchar(255) NOT NULL,
  `event_time_end` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_name`, `event_date_start`, `description`, `ticket_price`, `event_time_start`, `event_location`, `max_participants`, `event_status`, `event_pic`, `created_at`, `updated_at`, `event_date_end`, `event_time_end`) VALUES
(13, 'Concert Night', '2024-01-15', 'A night of live music with various artists.', '150000', '19:00:00', 'City Hall', 200, 'available', 'image1.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-01-15', '23:00:00'),
(14, 'Tech Conference 2024', '2024-02-05', 'A conference showcasing the latest in tech innovations.', '50000', '09:00:00', 'Tech Park', 300, 'available', 'image2.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-02-06', '17:00:00'),
(15, 'Art Exhibition', '2024-03-01', 'Exhibition of local artists’ works.', '25000', '10:00:00', 'Art Gallery', 100, 'available', 'image3.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-03-10', '18:00:00'),
(16, 'Food Festival', '2024-03-20', 'Taste cuisines from around the world.', '10000', '11:00:00', 'Food Plaza', 150, 'full', 'image4.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-03-22', '22:00:00'),
(17, 'Book Fair', '2024-04-01', 'Join us for a weekend of books and authors.', '20000', '10:00:00', 'Community Center', 50, 'available', 'image5.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-04-03', '18:00:00'),
(18, 'Yoga Retreat', '2024-04-10', 'A peaceful retreat to rejuvenate your body and mind.', '80000', '08:00:00', 'Nature Park', 30, 'available', 'image6.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-04-12', '16:00:00'),
(19, 'Startup Pitch Night', '2024-04-20', 'Present your startup ideas and get feedback.', '30000', '17:00:00', 'Startup Hub', 100, 'available', 'image7.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-04-20', '21:00:00'),
(20, 'Film Festival', '2024-05-05', 'Showcasing independent films from around the globe.', '50000', '18:00:00', 'Cineplex', 150, 'available', 'image8.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-05-07', '22:00:00'),
(21, 'Charity Run', '2024-05-15', 'Run for a cause and help those in need.', '150000', '07:00:00', 'City Park', 500, 'available', 'image9.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-05-15', '10:00:00'),
(22, 'Science Fair', '2024-06-01', 'Explore amazing projects by students and professionals.', '20000', '09:00:00', 'School Auditorium', 200, 'available', 'image10.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-06-03', '16:00:00'),
(23, 'Dance Workshop', '2024-06-10', 'Learn different dance styles in a fun environment.', '30000', '15:00:00', 'Dance Studio', 40, 'available', 'image11.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-06-10', '20:00:00'),
(24, 'Annual Sports Meet', '2024-06-20', 'Join us for a day of sports and fun activities.', '10000', '08:00:00', 'Sports Complex', 300, 'available', 'image12.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-06-20', '17:00:00'),
(25, 'Photography Contest', '2024-07-01', 'Capture the best moments and win exciting prizes.', '25000', '10:00:00', 'Photo Gallery', 60, 'available', 'image13.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-07-05', '20:00:00'),
(26, 'Music Festival', '2024-07-15', 'Enjoy a variety of music genres in one place.', '200000', '14:00:00', 'City Stadium', 1000, 'full', 'image14.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-07-17', '23:00:00'),
(27, 'Cooking Class', '2024-08-01', 'Learn to cook with top chefs.', '150000', '10:00:00', 'Cooking School', 20, 'available', 'image15.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-08-01', '15:00:00'),
(28, 'Cultural Festival', '2024-08-20', 'Celebrate cultural diversity with food, music, and performances.', '50000', '11:00:00', 'Cultural Center', 500, 'available', 'image16.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-08-22', '20:00:00'),
(29, 'Career Fair', '2024-09-01', 'Meet potential employers and find your dream job.', '0', '09:00:00', 'Expo Center', 1000, 'available', 'image17.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-09-01', '17:00:00'),
(30, 'Innovation Summit', '2024-09-15', 'A gathering of innovators and entrepreneurs.', '75000', '08:00:00', 'Innovation Center', 300, 'available', 'image18.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-09-16', '18:00:00'),
(31, 'Holiday Market', '2024-10-01', 'Find unique gifts and crafts for the holidays.', '20000', '10:00:00', 'Market Square', 200, 'available', 'image19.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-10-05', '22:00:00'),
(32, 'Charity Gala', '2024-10-15', 'A gala event to raise funds for local charities.', '50000', '18:00:00', 'Grand Ballroom', 300, 'available', 'image20.jpg', '2024-10-25 07:57:14', '2024-10-25 07:57:14', '2024-10-15', '23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_registration`
--

CREATE TABLE `event_registration` (
  `registration_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('registered','cancelled') NOT NULL DEFAULT 'registered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `reset_token`, `created_at`, `updated_at`, `role`) VALUES
(4, 'Bobi\r\n', 'admin1@example.com', '$2y$10$LRKA5qutcwDVLBg48ZazF.0RFdHy0/KW.GrAneYkTS7jv7wf2WNEO', NULL, '2024-10-25 07:52:32', '2024-10-25 08:26:13', 'admin'),
(5, 'Susi', 'admin2@example.com', '$2y$10$B8abcp6NMtYOkW4ox8Iguu9wTCloLvniE3mZeS3juy/B/blhoV85e', NULL, '2024-10-25 07:52:32', '2024-10-25 08:26:47', 'admin'),
(6, 'budi', 'user1@example.com', '$2y$10$EpTZ93r4Rzy.HuP0To0mkOnJUvvha6nTw.6ICrn16P0J5tjUTyG.2', NULL, '2024-10-25 07:52:32', '2024-10-25 08:27:08', 'user'),
(7, 'jonathan', 'user2@example.com', '$2y$10$BZl04zNXQBXi.Qhlz8IYsOQiiSnDnrruMmyqXSVoeMllOQt255SLu', NULL, '2024-10-25 07:52:32', '2024-10-25 08:27:25', 'user'),
(8, 'theresia', 'user3@example.com', '$2y$10$1U5sUOoQ.Zr4xGYmbpBEKuqEeSIUMPMZE/XO75uE.w4us2xyJIAJK', NULL, '2024-10-25 07:52:32', '2024-10-25 08:27:38', 'user'),
(9, 'susilo', 'user4@example.com', '$2y$10$JS1XnqenoVn7s43Nvipp9.lgQZL/lYHQwt/03z5pIowGKgitcn7/O', NULL, '2024-10-25 07:52:32', '2024-10-25 08:27:56', 'user'),
(10, 'samuel', 'user5@example.com', '$2y$10$Mtm/PVa2I/tNEgguBwoeVu4n78U4eiopOtvSJ1TgPxZ33EbMm4H..', NULL, '2024-10-25 07:52:32', '2024-10-25 08:28:13', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `event_name` (`event_name`);

--
-- Indexes for table `event_registration`
--
ALTER TABLE `event_registration`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `event_registration`
--
ALTER TABLE `event_registration`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_registration`
--
ALTER TABLE `event_registration`
  ADD CONSTRAINT `event_registration_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_registration_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
