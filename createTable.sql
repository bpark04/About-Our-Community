
CREATE TABLE Residence (
   city VARCHAR2(50),
   street VARCHAR2(50),
   house_number int,
   owner_name VARCHAR2(50),
   PRIMARY KEY (city, street, house_number)
);

CREATE TABLE Resident (
   resident_sin INTEGER,
   resident_name VARCHAR2(50),
   city VARCHAR2(50) NOT NULL,
   street VARCHAR2(50) NOT NULL,
   house_number int NOT NULL,
   PRIMARY KEY (resident_sin)
);

CREATE TABLE Cafe
(
   cafe_name VARCHAR2(50),
   rating INTEGER NOT NULL,
   PRIMARY KEY(cafe_name)
);

CREATE TABLE Visited
(
   cafe_name VARCHAR2(50),
   resident_sin INTEGER,
   PRIMARY KEY(cafe_name, resident_sin),
   FOREIGN KEY(cafe_name) REFERENCES Cafe(cafe_name),
   FOREIGN KEY(resident_sin) REFERENCES Resident(resident_sin)
);
 
 
CREATE TABLE Residence_PC(
   street VARCHAR2(50),
   house_number int,
   postal_code VARCHAR2(50),
   PRIMARY KEY (street, house_number)
   -- FOREIGN KEY (street, house_number) REFERENCES Residence(street, house_number)
);
 
 
CREATE TABLE School (
   school_name VARCHAR2(50),
   grade_range VARCHAR2(50),
   instructor_number int,
   PRIMARY KEY (school_name)
);
 
CREATE TABLE CurrentlyAttending(
   resident_sin int,
   school_name VARCHAR2(50),
   PRIMARY KEY (resident_sin, school_name),
   FOREIGN KEY (resident_sin) REFERENCES Resident(resident_sin),
   FOREIGN KEY (school_name) REFERENCES School(school_name)
);
 
CREATE TABLE Park(
   park_name VARCHAR2(50),
   park_address VARCHAR2(50),
   rating VARCHAR2(50),
   PRIMARY KEY (park_name),
   UNIQUE (park_address)
);
 
CREATE TABLE PlayAt(
   resident_sin int,
   park_name VARCHAR2(50),
   PRIMARY KEY (resident_sin,park_name),
   FOREIGN KEY (resident_sin) REFERENCES Resident(resident_sin),
   FOREIGN KEY (park_name) REFERENCES Park(park_name)
);
 
 
CREATE TABLE Activity(
   activity_name VARCHAR2(50),
   PRIMARY KEY (activity_name)
);
 
 
CREATE TABLE Library(
   library_name VARCHAR2(50),
   number_books int,
   rating int,
   PRIMARY KEY (library_name)
);
 
 
CREATE TABLE StudyAt(
   resident_sin int,
   library_name VARCHAR2(50),
   PRIMARY KEY (resident_sin, library_name),
   FOREIGN KEY (resident_sin) REFERENCES Resident,
   FOREIGN KEY (library_name) REFERENCES Library(library_name)
);
 
 
CREATE TABLE Drink
(
   drinkName VARCHAR2(50),
   price float NOT NULL,
   rating float NOT NULL,
   hotOrCold VARCHAR2(10), 
   calories float NOT NULL,
   PRIMARY KEY (drinkName)
);
 
CREATE TABLE Tea
(
   tname VARCHAR2(50),
   tea_type VARCHAR2(50) NOT NULL,
   PRIMARY KEY(tname),
   FOREIGN KEY(tname) REFERENCES Drink(drinkName) ON DELETE CASCADE
);
 
-- CREATE TABLE Coffee_types(
--    coffee_type VARCHAR2(50),
--    caffine_amount int NOT NULL,
--    PRIMARY KEY(coffee_type)
-- );

CREATE TABLE Coffee (
   cname VARCHAR2(50),
   coffee_type VARCHAR2(50) NOT NULL,
   PRIMARY KEY(cname),
   FOREIGN KEY(cname) REFERENCES Drink(drinkName) ON DELETE CASCADE
   -- FOREIGN KEY(coffee_type) REFERENCES Coffee_types(coffee_type) 
);

CREATE TABLE Serve
(
   cafe_name VARCHAR2(50),
   drink_name VARCHAR2(50),
   PRIMARY KEY(cafe_name, drink_name),
   FOREIGN KEY(cafe_name) REFERENCES Cafe(cafe_name),
   FOREIGN KEY(drink_name) REFERENCES Drink(drinkName)
);

 
CREATE TABLE Community_Centre(
   cc_address VARCHAR2(50),
   cc_name VARCHAR2(30),
   PRIMARY KEY (cc_name),
   UNIQUE (cc_address)
);
 
CREATE TABLE Has_Facility(
   facility_name VARCHAR2(30),
   room_number INTEGER,
   cc_name VARCHAR2(30) NOT NULL,
   PRIMARY KEY (room_number,cc_name),
   FOREIGN KEY (cc_name) REFERENCES Community_Centre(cc_name) ON DELETE CASCADE
);
 

CREATE TABLE Gym(
   room_number INTEGER,
   cc_name VARCHAR2(30) NOT NULL,
   PRIMARY KEY (room_number,cc_name),
   FOREIGN KEY (cc_name) REFERENCES Community_Centre(cc_name) ON DELETE CASCADE
   -- FOREIGN KEY (room_number) REFERENCES Has_Facility(room_number) ON DELETE CASCADE
);
 
CREATE TABLE Has_Equipment (
   -- Total participation on both ends, we haven't cover how to use assertions yet
   serial_number VARCHAR2(15),
   type VARCHAR2(30),
   PRIMARY KEY (serial_number)
);
 
CREATE TABLE GoesTo(
   resident_sin INTEGER,
   cc_name VARCHAR2(30),
   PRIMARY KEY (cc_name,resident_sin),
   FOREIGN KEY (cc_name) REFERENCES Community_Centre(cc_name),
   FOREIGN KEY (resident_sin) REFERENCES Resident(resident_sin)
);

--Resident(SIN, Name, city,  street, House_Number)
INSERT INTO Resident VALUES (1234567890, 'Sun Park', 'Vancouver', 'Main Mall', 1);
INSERT INTO Resident VALUES (7777777777, 'Laura Lee', 'Richmond', 'Main Avenue', 2);
INSERT INTO Resident VALUES (8888888888, 'Chris Tayler', 'Richmond', 'Spruce Street', 3);
INSERT INTO Resident VALUES (6666666666, 'Su Kim', 'Burnaby', 'Oak Street', 104);
INSERT INTO Resident VALUES (5555555555, 'Lynn Do', 'Burnaby', 'Fraser Street', 53);
INSERT INTO Resident VALUES (1234567891, 'Lion Ha', 'Burnaby', 'Fraser Street', 53);
INSERT INTO Resident VALUES (1234567892, 'Ian Dow', 'Burnaby', 'Fraser Street', 53);
INSERT INTO Resident VALUES (1234567893, 'Hayoung Lee', 'Burnaby', 'Fraser Street', 53);
INSERT INTO Resident VALUES (1234567894, 'Nara Song', 'Burnaby', 'Fraser Street', 53);
 
 
--Residence(city, Street, House_Number, Owner Name)
INSERT INTO Residence VALUES ('Vancouver', 'Main Mall', 1, 'Sun Park');
INSERT INTO Residence VALUES ('Richmond', 'Main Avenue', 2, 'Ian Lee');
INSERT INTO Residence VALUES ('Richmond', 'Spruce Street', 3, 'Richard Tayler');
INSERT INTO Residence VALUES ('Burnaby', 'Oak Street', 104, 'Su Kim');
INSERT INTO Residence VALUES ('Burnaby', 'Fraser Street', 53, 'Lianne Do');
 
--Residence_PC(Street, House#, Postal Code)
INSERT INTO Residence_PC VALUES ('Main Mall', 1, 'V6T 1Z4');
INSERT INTO Residence_PC VALUES ('Main Avenue', 2, 'V2A 1C1');
INSERT INTO Residence_PC VALUES ('Spruce Street', 3, 'V3A 1A2');
INSERT INTO Residence_PC VALUES ('Oak Street', 104, 'V7B 5D');
INSERT INTO Residence_PC VALUES ('Fraser Street', 53, 'V2C 2Y4');
 
 
--School(School_Name, Range of Grade, Instructor_Number)
INSERT INTO School VALUES ('Fraser Elementary School', '1-6', 23);
INSERT INTO School VALUES ('Fraser Middle School', '7-9', 26);
INSERT INTO School VALUES ('Fraser High School', '10-12', 22);
INSERT INTO School VALUES ('Oak Middle School', '7-9', 23);
INSERT INTO School VALUES ('Spruce High School', '10-12', 23);
 
 
--CurrentlyAttending(SIN, School Name, Range of Grade)
INSERT INTO CurrentlyAttending VALUES (1234567890, 'Fraser Elementary School');
INSERT INTO CurrentlyAttending VALUES (1234567891, 'Fraser Elementary School');
INSERT INTO CurrentlyAttending VALUES (1234567892, 'Fraser Middle School');
INSERT INTO CurrentlyAttending VALUES (1234567893, 'Spruce High School');
INSERT INTO CurrentlyAttending VALUES (1234567894, 'Spruce High School');
 
 
--Park(Park_Name, Address, Rating)
INSERT INTO Park VALUES ('Bear Creek Park', '13750 88 Ave', 'Good');
INSERT INTO Park VALUES ('Darts Hill Garden Park', '16th Avenue and 170th Street', 'Normal');
INSERT INTO Park VALUES ('Spruce House Park', '561 172 St', 'Normal');
INSERT INTO Park VALUES ('Queen Elizabeth Park', '4600 Cambie St', 'Good');
INSERT INTO Park VALUES ('UBC Botanical Garden', '6804 SW Marine Dr', 'Good');
 
 
--PlaysAt(SIN, Park_Name)
INSERT INTO PlayAt VALUES (1234567890, 'Bear Creek Park');
INSERT INTO PlayAt VALUES (1234567890, 'Darts Hill Garden Park');
INSERT INTO PlayAt VALUES (1234567891, 'Darts Hill Garden Park');
INSERT INTO PlayAt VALUES (1234567890, 'Queen Elizabeth Park');
INSERT INTO PlayAt VALUES (1234567894, 'Queen Elizabeth Park');
 
 
--Activity(Activity_Name)
INSERT INTO Activity VALUES ('Soccer');
INSERT INTO Activity VALUES ('Basket Ball');
INSERT INTO Activity VALUES ('Jogging');
INSERT INTO Activity VALUES ('Walking with a dog');
INSERT INTO Activity VALUES ('Party');
 
--Library(Library_Name, Number_Books, Rating)
INSERT INTO Library VALUES ('Vancouver Public Library', 10000, 5);
INSERT INTO Library VALUES ('IKB', 80000, 4);
INSERT INTO Library VALUES ('Koernel', 20000, 3);
INSERT INTO Library VALUES ('Burnaby General Library', 40000, 2);
INSERT INTO Library VALUES ('Old Library', 1000, 1);
 
--StudyAt(SIN, Library_Name)
INSERT INTO StudyAt VALUES (1234567890, 'Vancouver Public Library');
INSERT INTO StudyAt VALUES (1234567891, 'IKB');
INSERT INTO StudyAt VALUES (1234567892, 'Koernel');
INSERT INTO StudyAt VALUES (1234567893, 'Burnaby General Library');
INSERT INTO StudyAt VALUES (1234567894, 'Old Library');

 
-- -- Cafe
INSERT INTO Cafe
VALUES
   ('Starbucks', 4);
INSERT INTO Cafe
VALUES
   ('CafeBene', 2);
INSERT INTO Cafe
VALUES
   ('CafeOne', 3);
INSERT INTO Cafe
VALUES
   ('Blenz', 5);

-- Drink
INSERT INTO Drink
VALUES
   ('Iced Chai Tea Latte', 4.5, 6, 'cold', 200);
INSERT INTO Drink
VALUES
   ('Iced Black Tea', 5, 8, 'cold', 150);
INSERT INTO Drink
VALUES
   ('Iced Matcha Tea Latte', 5, 7, 'cold', 230);
INSERT INTO Drink
VALUES
   ('Iced Green Tea', 4.5, 5, 'cold', 100);
INSERT INTO Drink
VALUES
   ('Iced Peach Green Tea', 6,8,'cold', 180);
INSERT INTO Drink
VALUES
   ('Pumpkin Spice Frappucino', 4.99, 6, 'hot', 220);
INSERT INTO Drink
VALUES
   ('Pumpkin Spice Latte', 6, 7, 'hot', 280);
INSERT INTO Drink
VALUES
   ('Oat Latte', 5, 9, 'hot', 150);
INSERT INTO Drink
VALUES
   ('Honey Oat Latte', 5.5, 6, 'hot', 200);
INSERT INTO Drink
VALUES
   ('Vanilla Cappucino', 3, 8, 'hot', 230);
INSERT INTO Drink
VALUES
   ('Decaf Espresso', 5, 5, 'hot', 150);
INSERT INTO Drink
VALUES
   ('Lychee Black Tea', 4.5, 7, 'hot', 120);
INSERT INTO Drink
VALUES
   ('Pear White Tea', 5, 8, 'hot', 110);
INSERT INTO Drink
VALUES
   ('Lavender Tea', 4.5, 7, 'hot', 130);
INSERT INTO Drink
VALUES
   ('Iron Goddess', 5, 7, 'hot', 120);
INSERT INTO Drink
VALUES
   ('Iced White Tea', 4, 7, 'hot', 100);
INSERT INTO Drink
VALUES
   ('Rose Tea', 5, 6, 'hot', 150);
INSERT INTO Drink
VALUES
   ('Red Robe', 5.5, 8, 'hot', 130);
INSERT INTO Drink
VALUES
   ('Cinnamon Chai Tea', 6, 7, 'cold', 250);   
         
-- Tea
INSERT INTO Tea
VALUES
   ('Iced Chai Tea Latte', 'Chai Tea');
INSERT INTO Tea
VALUES
   ('Cinnamon Chai Tea', 'Chai Tea');   
INSERT INTO Tea
VALUES
   ('Iced Black Tea', 'Black Tea');
INSERT INTO Tea
VALUES
   ('Iced Matcha Tea Latte', 'Green Tea');
INSERT INTO Tea
VALUES
   ('Iced Peach Green Tea', 'Green Tea');
INSERT INTO Tea
VALUES
   ('Iced Green Tea', 'Green Tea');
INSERT INTO Tea
VALUES
   ('Lychee Black Tea', 'Black Tea');   
INSERT INTO Tea
VALUES
   ('Pear White Tea', 'White Tea');   
INSERT INTO Tea
VALUES
   ('Iced White Tea', 'White Tea');     
INSERT INTO Tea
VALUES
   ('Lavender Tea', 'Herbal Tea');    
INSERT INTO Tea
VALUES
   ('Rose Tea', 'Herbal Tea');     
INSERT INTO Tea
VALUES
   ('Iron Goddess', 'Oolong Tea');
INSERT INTO Tea
VALUES
   ('Red Robe', 'Oolong Tea');        
 

-- -- Coffee_types
-- INSERT INTO Coffee_types
-- VALUES
--    ('Latte', 32);
-- INSERT INTO Coffee_types
-- VALUES
--    ('Espresso', 212);
-- INSERT INTO Coffee_types
-- VALUES
--    ('Cappucino', 150);
-- INSERT INTO Coffee_types
-- VALUES
--    ('Cold Brew', 220);
-- INSERT INTO Coffee_types
-- VALUES
--    ('Decaf', 2);


-- Coffee
INSERT INTO Coffee
VALUES
   ('Pumpkin Spice Latte', 'Latte');
INSERT INTO Coffee
VALUES
   ('Decaf Espresso', 'Espresso');
INSERT INTO Coffee
VALUES
   ('Oat Latte', 'Latte');
INSERT INTO Coffee
VALUES
   ('Honey Oat Latte', 'Latte');
INSERT INTO Coffee
VALUES
   ('Vanilla Cappucino', 'Cappucino');

 
-- Serve
INSERT INTO Serve
VALUES
   ('Blenz', 'Iced Chai Tea Latte');
INSERT INTO Serve
VALUES
   ('Blenz', 'Iced Black Tea');
INSERT INTO Serve
VALUES
   ('Blenz', 'Iced Matcha Tea Latte');

 
-- HasDinedAt
INSERT INTO Visited VALUES ('CafeBene', 1234567890);
INSERT INTO Visited VALUES ('Starbucks', 1234567890);
INSERT INTO Visited VALUES ('Starbucks', 5555555555);
INSERT INTO Visited VALUES ('Starbucks', 6666666666);
INSERT INTO Visited VALUES ('CafeBene', 6666666666);
INSERT INTO Visited VALUES ('CafeOne', 6666666666);
INSERT INTO Visited VALUES ('Blenz', 6666666666);
INSERT INTO Visited VALUES ('Starbucks', 7777777777);
INSERT INTO Visited VALUES ('Blenz', 7777777777);
INSERT INTO Visited VALUES ('CafeOne', 7777777777);
INSERT INTO Visited VALUES ('CafeBene', 7777777777);
INSERT INTO Visited VALUES ('Blenz', 8888888888);
INSERT INTO Visited VALUES ('Starbucks', 8888888888);
INSERT INTO Visited VALUES ('CafeBene', 8888888888);
INSERT INTO Visited VALUES ('CafeOne', 8888888888);

 
INSERT INTO Community_Centre VALUES('2121 Marine Drive', 'West Vancouver');
INSERT INTO Community_Centre VALUES('145 W 1st Street', 'John Centre');
INSERT INTO Community_Centre VALUES('870 Denman Street', 'West End');
INSERT INTO Community_Centre VALUES('4397 W 2nd Ave', 'West Point');
INSERT INTO Community_Centre VALUES('480 Broughton', 'Coal Harbour');
 
INSERT INTO Has_Facility VALUES('Swimming Pool', 101, 'West Vancouver');
INSERT INTO Has_Facility VALUES('Lego Room', 208, 'West End');
INSERT INTO Has_Facility VALUES('Lego Room', 102, 'John Centre');
INSERT INTO Has_Facility VALUES('Painting Room', 111, 'West Vancouver');
INSERT INTO Has_Facility VALUES('Swimming Pool', 121, 'Coal Harbour');
 

 
INSERT INTO Gym VALUES(120, 'West Vancouver');
INSERT INTO Gym VALUES(301, 'West End');
INSERT INTO Gym VALUES(110, 'John Centre');
INSERT INTO Gym VALUES(100, 'West Point');
INSERT INTO Gym VALUES(203, 'Coal Harbour');
 
INSERT INTO Has_Equipment VALUES('40E4C2K09', 'Treadmill');
INSERT INTO Has_Equipment VALUES('2JD39NF02ND2', 'Elliptical');
INSERT INTO Has_Equipment VALUES('2JEIF029R13OF', 'Bench press');
INSERT INTO Has_Equipment VALUES('40E4C2K15', 'Treadmill');
INSERT INTO Has_Equipment VALUES('2JD39NF02ND9', 'Elliptical');
 
COMMIT WORK;

         