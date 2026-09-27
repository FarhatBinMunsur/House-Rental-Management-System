-- =========================================
-- BOOKING TABLE
-- =========================================

CREATE TABLE `booking` (
  `bookingID` int(11) NOT NULL AUTO_INCREMENT,
  `clientID` int(11) NOT NULL,
  `propertyID` int(11) NOT NULL,
  `bookingDate` date NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`bookingID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `booking`
(`bookingID`, `clientID`, `propertyID`, `bookingDate`, `status`)
VALUES
(201, 6, 102, '2025-01-01', 'Active'),
(202, 7, 104, '2025-01-05', 'Active');


-- =========================================
-- NOTIFICATION TABLE
-- =========================================

CREATE TABLE `notification` (
  `notificationID` int(11) NOT NULL AUTO_INCREMENT,
  `bookingID` int(11) NOT NULL,
  `managerID` int(11) NOT NULL,
  `clientID` int(11) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `dueDate` date DEFAULT NULL,
  `sentDate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`notificationID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `notification`
(`notificationID`, `bookingID`, `managerID`, `clientID`, `message`, `dueDate`, `sentDate`)
VALUES
(1, 202, 2, 7, 'amount is due.please clear it soon', '2026-09-09', '2026-09-07 19:55:18'),
(2, 201, 2, 6, 'clear it quickly', '2026-09-12', '2026-09-07 20:01:41'),
(3, 202, 2, 7, 'clear it soon', '2026-09-24', '2026-09-14 14:38:36');


-- =========================================
-- PAYMENT TABLE
-- =========================================

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL AUTO_INCREMENT,
  `bookingID` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `paymentDate` date NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`paymentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `payment`
(`paymentID`, `bookingID`, `amount`, `paymentDate`, `status`)
VALUES
(301, 201, 2800.00, '2025-01-01', 'Completed'),
(302, 202, 1950.00, '2025-01-15', 'Completed');


-- =========================================
-- PROPERTY TABLE
-- =========================================

CREATE TABLE `property` (
  `propertyID` int(11) NOT NULL AUTO_INCREMENT,
  `ownerID` int(11) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `propertyType` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `rent` decimal(12,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `bedrooms` int(11) NOT NULL DEFAULT 0,
  `bathrooms` int(11) NOT NULL DEFAULT 0,
  `area` int(11) NOT NULL DEFAULT 0,
  `availabilityDate` date DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `images` text DEFAULT NULL,
  PRIMARY KEY (`propertyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `property`
(`propertyID`, `ownerID`, `Title`, `propertyType`, `status`, `rent`,
 `location`, `bedrooms`, `bathrooms`, `area`, `availabilityDate`,
 `description`, `images`)
VALUES
(101, 4, 'Parkside Modern Villa', '', 'Accepted', 3800.00,
 'Seattle, WA', 0, 0, 0, NULL,
 'Modern villa with spacious rooms and garden.', NULL),

(102, 5, 'Sunset Luxury Penthouse', '', 'Accepted', 2800.00,
 'Seattle, WA', 0, 0, 0, NULL,
 'Luxury penthouse with beautiful city views.', NULL),

(103, 4, 'Riverside Cabin Deluxe', '', 'Rejected', 3100.00,
 'Denver, CO', 0, 0, 0, NULL,
 'Comfortable cabin near the riverside.', NULL),

(104, 5, 'Oakwood Townhouse', '', 'Accepted', 1950.00,
 'Portland, OR', 0, 0, 0, NULL,
 'Modern townhouse suitable for families.', NULL),

(105, 4, 'Ocean Breeze Cabin', '', 'Accepted', 3400.00,
 'Malibu, CA', 0, 0, 0, NULL,
 'Beachside cabin with ocean views.', NULL),

(106, 5, 'Golsan Villa', '', 'Rejected', 50000.00,
 'Dhaka', 0, 0, 0, NULL,
 'This is high class villa', NULL),

(107, 5, 'Uttara', 'Apartment', 'Pending', 20000.00,
 'Dhaka', 2, 1, 500, '2026-09-16',
 'this is a small apartment',
 '[\"uploads/property_6a9ecc8327b658.10526639.jpg\"]');


-- =========================================
-- USERS TABLE
-- =========================================

CREATE TABLE `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(150) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userRole` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `salary` decimal(12,2) DEFAULT NULL,
  `joiningDate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users`
(`userID`, `userName`, `userEmail`, `userPassword`, `userRole`,
 `phone`, `salary`, `joiningDate`, `address`)
VALUES
(1, 'Admin Supervisor', 'admin@rentease.com', '123456',
 'ADMIN', '01710000001', 80000.00, '2024-01-01', 'Dhaka, Bangladesh'),

(2, 'Marcus Sterling', 'marcus.s@rentease.com',
 '123789', 'manager', '01710000002',
 60000.00, '2024-02-01', 'Dhaka, Bangladesh'),

(3, 'Daniel Miller', 'daniel.m@rentease.com',
 '$2y$10$wAfS9cdUR77eKXMIMkZaOuHhPSg5Kg43bcl2OwdeU4DmCtwjAAeqW',
 'manager', '01710000003',
 58000.00, '2024-03-01', 'Dhaka, Bangladesh'),

(4, 'Alice Henderson', 'alice.h@rentease.com',
 '123456', 'manager', '01710000004',
 NULL, NULL, 'Gulshan, Dhaka'),

(5, 'Sarah Jenkins', 'sarah.j@rentease.com',
 '123456', 'OWNER', '01710000005',
 NULL, NULL, 'Banani, Dhaka'),

(6, 'Robert Fox', 'robert@rentease.com',
 '123456', 'CLIENT', '01710000006',
 NULL, NULL, 'Uttara, Dhaka'),

(7, 'Jenny Wilson', 'jenny@rentease.com',
 '123456', 'CLIENT', '01710000007',
 NULL, NULL, 'Mirpur, Dhaka');