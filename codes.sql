CREATE DATABASE Railbooking;

-- Creating the Trains table
CREATE TABLE Railbooking.Trains (
    TrainID INT PRIMARY KEY AUTO_INCREMENT,
    Source VARCHAR(100) NOT NULL,
    Destination VARCHAR(100) NOT NULL,
    DepartureTime TIME NOT NULL,
    ArrivalTime TIME NOT NULL,
    DeparturePlatform VARCHAR(10),
    ArrivalPlatform VARCHAR(10),
    AvailableSeats INT,
    Class VARCHAR(50),
    Price DECIMAL
);

-- Customers table
CREATE TABLE Railbooking.Customers (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    FullName VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Phone VARCHAR(15)
);

-- Railcard table
CREATE TABLE Railbooking.Railcard (
    RailcardID INT PRIMARY KEY AUTO_INCREMENT,
    RailcardType VARCHAR(50) NOT NULL,
    DiscountAmount DECIMAL NOT NULL
);

-- RegisteredCustomers table
CREATE TABLE Railbooking.RegisteredCustomers (
    CustomerID INT PRIMARY KEY,
    RailcardID INT,
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID),
    FOREIGN KEY (RailcardID) REFERENCES Railcard(RailcardID),
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(50) NOT NULL
);

-- Bookings table
CREATE TABLE Railbooking.Bookings (
    BookingID INT PRIMARY KEY AUTO_INCREMENT,
    TrainID INT NOT NULL,
    CustomerID INT NOT NULL,
    BookingDate DATE NOT NULL,
    BookingTime TIME NOT NULL,
    TravelDate DATE NOT NULL,
    NumberOfSeats INT NOT NULL,
    TotalPrice DECIMAL NOT NULL,
    DepartureStation VARCHAR(100) NOT NULL,
    ArrivalStation VARCHAR(100) NOT NULL,
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID),
    FOREIGN KEY (TrainID) REFERENCES Trains(TrainID)
);

-- Payment table
CREATE TABLE Railbooking.Payment (
    PaymentID INT PRIMARY KEY AUTO_INCREMENT,
    BookingID INT NOT NULL,
    AmountPaid DECIMAL NOT NULL,
    PaymentMethod VARCHAR(50) NOT NULL,
    RailcardID INT,
    FOREIGN KEY (BookingID) REFERENCES Bookings(BookingID),
    FOREIGN KEY (RailcardID) REFERENCES Railcard(RailcardID)
);

-- Ticket table
CREATE TABLE Railbooking.Ticket (
    TicketID INT PRIMARY KEY AUTO_INCREMENT,
    BookingID INT NOT NULL,
    NumberOfSeats INT NOT NULL,
    TravelDate DATE NOT NULL,
    Dept_time TIME NOT NULL,
    Arrival_time TIME NOT NULL,
    FOREIGN KEY (BookingID) REFERENCES Bookings(BookingID)
);

-- GuestCustomers table
CREATE TABLE Railbooking.GuestCustomers (
    CustomerID INT PRIMARY KEY,
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);


-- Inserting data with both First Class and Standard options for each train into the Trains table
INSERT INTO Railbooking.Trains 
    (TrainID, Source, Destination, DepartureTime, ArrivalTime, DeparturePlatform, ArrivalPlatform, AvailableSeats, Class, Price)
VALUES 
    (1, 'London', 'Manchester', '08:00:00', '11:00:00', 'A1', 'B2', 100, 'Standard', 50.00),
    (11, 'London', 'Manchester', '08:00:00', '11:00:00', 'A1', 'B2', 50, 'First Class', 80.00),
    (2, 'Manchester', 'London', '13:00:00', '16:00:00', 'C3', 'D4', 80, 'First Class', 80.00),
    (12, 'Manchester', 'London', '13:00:00', '16:00:00', 'C3', 'D4', 120, 'Standard', 50.00),
    (3, 'Birmingham', 'Glasgow', '10:30:00', '15:30:00', 'E5', 'F6', 120, 'Standard', 60.00),
    (13, 'Birmingham', 'Glasgow', '10:30:00', '15:30:00', 'E5', 'F6', 60, 'First Class', 90.00),
    (4, 'Glasgow', 'Birmingham', '12:00:00', '17:00:00', 'G7', 'H8', 90, 'First Class', 90.00),
    (14, 'Glasgow', 'Birmingham', '12:00:00', '17:00:00', 'G7', 'H8', 130, 'Standard', 60.00),
    (5, 'Edinburgh', 'London', '09:45:00', '15:45:00', 'I9', 'J10', 150, 'Standard', 70.00),
    (15, 'Edinburgh', 'London', '09:45:00', '15:45:00', 'I9', 'J10', 75, 'First Class', 100.00),
    (6, 'London', 'Edinburgh', '11:30:00', '17:30:00', 'K11', 'L12', 110, 'First Class', 100.00),
    (16, 'London', 'Edinburgh', '11:30:00', '17:30:00', 'K11', 'L12', 160, 'Standard', 70.00),
    (7, 'Liverpool', 'Bristol', '14:15:00', '18:15:00', 'M13', 'N14', 80, 'Standard', 55.00),
    (17, 'Liverpool', 'Bristol', '14:15:00', '18:15:00', 'M13', 'N14', 40, 'First Class', 85.00),
    (8, 'Bristol', 'Liverpool', '16:00:00', '20:00:00', 'O15', 'P16', 70, 'First Class', 85.00),
    (18, 'Bristol', 'Liverpool', '16:00:00', '20:00:00', 'O15', 'P16', 110, 'Standard', 55.00),
    (9, 'Cardiff', 'Manchester', '10:00:00', '13:00:00', 'Q17', 'R18', 120, 'Standard', 60.00),
    (19, 'Cardiff', 'Manchester', '10:00:00', '13:00:00', 'Q17', 'R18', 60, 'First Class', 90.00),
    (10, 'Manchester', 'Cardiff', '14:30:00', '17:30:00', 'S19', 'T20', 100, 'First Class', 90.00),
    (20, 'Manchester', 'Cardiff', '14:30:00', '17:30:00', 'S19', 'T20', 150, 'Standard', 60.00);

Inserting data into the Railcard table with unique discount amounts for each railcard type
INSERT INTO Railbooking.Railcard (RailcardID, RailcardType, DiscountAmount)
VALUES 
    (1, 'Student Railcard', 0.20),  -- 20% discount
    (2, 'Senior Railcard', 0.25),  -- 25% discount
    (3, 'Family & Friends Railcard', 0.15),  -- 15% discount
    (4, 'Disabled Persons Railcard', 0.35),  -- 35% discount
    (5, 'Group Railcard', 0.10),  -- 10% discount for large groups
    (6, 'Two Together Railcard', 0.30),  -- 30% discount
    (7, 'Network Railcard', 0.20),  -- 20% discount
    (8, 'Annual Gold Card', 0.33),  -- 33% discount
    (9, 'HM Forces Railcard', 0.34),  -- 34% discount
    (10, 'Jobcentre Plus Travel Discount Card', 0.50);  -- 50% discount for job seekers

ALTER TABLE Railbooking.Railcard
MODIFY DiscountAmount DECIMAL(3, 2) NOT NULL;

-- Inserting data into the Customers table
INSERT INTO Railbooking.Customers (CustomerID, FullName, Email, Phone)
VALUES 
(1, 'John Doe', 'johndoe@example.com', '+1234567890'),
(2, 'Jane Smith', 'janesmith@example.com', '+1987654321'),
(3, 'Michael Johnson', 'michaeljohnson@example.com', '+1765432890'),
(4, 'Emily Brown', 'emilybrown@example.com', '+1657894321'),
(5, 'David Taylor', 'davidtaylor@example.com', '+1987654321'),
(6, 'Sarah Williams', 'sarahwilliams@example.com', '+1234567890'),
(7, 'James Wilson', 'jameswilson@example.com', '+1987654321'),
(8, 'Emma Jones', 'emmajones@example.com', '+1234567890'),
(9, 'Daniel Martinez', 'danielmartinez@example.com', '+1987654321'),
(10, 'Olivia Davis', 'oliviadavis@example.com', '+1234567890'),
(11, 'Charlotte White', 'charlottewhite@example.com', '+1456789123'),
(12, 'Lucas Moore', 'lucasmoore@example.com', '+1543298765'),
(13, 'Amelia Lee', 'amelialee@example.com', '+1321456789'),
(14, 'Mason Harris', 'masonharris@example.com', '+1876543210'),
(15, 'Sophia Clark', 'sophiaclark@example.com', '+1678904321'),
(16, 'Ethan Young', 'ethanyoung@example.com', '+1789654321'),
(17, 'Isabella Thompson', 'isabellathompson@example.com', '+1509876543'),
(18, 'Alexander Anderson', 'alexanderanderson@example.com', '+1456789321'),
(19, 'Mia Rodriguez', 'miarodriguez@example.com', '+1321549876'),
(20, 'William King', 'williamking@example.com', '+1987654321');

Inserting data into the GuestCustomers table
INSERT INTO Railbooking.GuestCustomers (CustomerID)
VALUES 
(11),
(12),
(13),
(14);


Inserting data into the RegisteredCustomers table
INSERT INTO Railbooking.RegisteredCustomers (CustomerID, RailcardID, Username, Password)
VALUES 
(1, 1, 'johndoe', 'password123'),
(2, 2, 'janesmith', 'password456'),
(3, 3, 'michaelj', 'pass123'),
(4, 4, 'emilyb', 'pass456'),
(5, 5, 'davidt', 'password789'),
(6, 6, 'sarahw', 'pass789'),
(7, 7, 'jamesw', 'password012'),
(8, 8, 'emmaj', 'password345'),
(9, 9, 'danielm', 'pass678'),
(10, 10, 'oliviad', 'password901');

ALTER TABLE Railbooking.Railcard 
MODIFY DiscountAmount DECIMAL(10, 2) NOT NULL;


-- DROP DATABASE Railbooking;
ALTER TABLE Railbooking.Ticket
DROP COLUMN  BookingTime;
-- DROP COLUMN CoachType,
-- DROP COLUMN SeatNumber;

Customers table
INSERT INTO  Railbooking.Customers (CustomerID, FullName, Email, Phone) VALUES
(1, 'John Doe', 'john.doe@gmail.com', '1234567890'),
(2, 'Jane Smith', 'jane.smith@gmail.com', '0987654321'),
(7, 'Michael Johnson', 'michael.j@gmail.com', '1122334455'),
(8, 'Emily Davis', 'emily.davis@gmail.com', '2233445566'),
(9, 'Daniel Brown', 'daniel.brown@gmail.com', '3344556677'),
(10, 'Alice Green', 'alice.green@gmail.com', '4455667788'),
(11, 'Robert White', 'robert.white@gmail.com', '5566778899'),
(12, 'Laura Black', 'laura.black@gmail.com', '6677889900'),
(13, 'Chris Blue', 'chris.blue@gmail.com', '7788990011'),
(14, 'Olivia Yellow', 'olivia.yellow@gmail.com', '8899001122');

-- CustomerRailcards table
INSERT INTO Railbooking.RegisteredCustomers (CustomerID, RailcardID, Username, Password) VALUES
(1, 2, 'jdoe', 'password123'),
(2, 3, 'janesmith', 'password123'),
(7, 4, 'michaelj', 'password123'),
(8, 5, 'emilyd', 'password123'),
(9, 6, 'danielb', 'password123');

-- Bookings table
INSERT INTO Railbooking.Bookings (BookingID, TrainID, CustomerID, BookingDate, BookingTime, TravelDate, NumberOfSeats, TotalPrice, DepartureStation, ArrivalStation) VALUES
(2, 1, 1, '2024-05-23', '08:00:00', '2024-05-23', 1, 42.50, 'London', 'Manchester'),
(3, 2, 2, '2024-05-23', '10:00:00', '2024-05-23', 2, 85.00, 'Manchester', 'London'),
(4, 3, 7, '2024-05-24', '09:00:00', '2024-05-24', 1, 60.00, 'Birmingham', 'Glasgow'),
(5, 4, 8, '2024-05-24', '11:00:00', '2024-05-24', 1, 75.00, 'Glasgow', 'Birmingham'),
(6, 5, 9, '2024-05-25', '12:00:00', '2024-05-25', 1, 90.00, 'Edinburgh', 'Bristol'),
(7, 6, 10, '2024-05-26', '08:30:00', '2024-05-26', 1, 50.00, 'London', 'Edinburgh'),
(8, 7, 11, '2024-05-27', '09:30:00', '2024-05-27', 2, 100.00, 'Liverpool', 'Bristol'),
(9, 8, 12, '2024-05-28', '10:30:00', '2024-05-28', 1, 65.00, 'Bristol', 'Liverpool'),
(10, 9, 13, '2024-05-29', '11:30:00', '2024-05-29', 2, 120.00, 'Cardiff', 'Manchester'),
(11, 10, 14, '2024-05-30', '12:30:00', '2024-05-30', 1, 80.00, 'Manchester', 'Cardiff');

-- Payments table
INSERT INTO Railbooking.Payment (PaymentID, BookingID, AmountPaid, PaymentMethod, RailcardID) VALUES
(2, 2, 31.87, 'credit_card', 2),
(3, 3, 63.75, 'credit_card', 3),
(4, 4, 45.00, 'credit_card', 4),
(5, 5, 56.25, 'credit_card', 5),
(6, 6, 67.50, 'credit_card', 6),
(7, 7, 50.00, 'credit_card', NULL),
(8, 8, 100.00, 'credit_card', NULL),
(9, 9, 65.00, 'credit_card', NULL),
(10, 10, 120.00, 'credit_card', NULL),
(11, 11, 80.00, 'credit_card', NULL);

-- Tickets table
INSERT INTO Railbooking.Ticket (TicketID, BookingID, NumberOfSeats, TravelDate, Dept_time, Arrival_time) VALUES
(2, 2, 1, '2024-05-23', '08:00:00', '11:00:00'),
(3, 3, 2, '2024-05-23', '10:00:00', '13:00:00'),
(4, 4, 1, '2024-05-24', '09:00:00', '12:00:00'),
(5, 5, 1, '2024-05-24', '11:00:00', '14:00:00'),
(6, 6, 1, '2024-05-25', '12:00:00', '15:00:00'),
(7, 7, 1, '2024-05-26', '08:30:00', '11:30:00'),
(8, 8, 2, '2024-05-27', '09:30:00', '12:30:00'),
(9, 9, 1, '2024-05-28', '10:30:00', '13:30:00'),
(10, 10, 2, '2024-05-29', '11:30:00', '14:30:00'),
(11, 11, 1, '2024-05-30', '12:30:00', '15:30:00');
