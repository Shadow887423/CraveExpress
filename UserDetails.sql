CREATE DATABASE UserDetailsDB;
GO 

USE UserDetailsDB;
GO

CREATE TABLE Userdetails1(
    Username INT PRIMARY KEY IDENTITY(1,1),
    Password VARCHAR(50) NOT NULL,
    Country VARCHAR(300) NOT NULL,
    Email VARCHAR(300) NOT NULL UNIQUE,
    TimeCreated DATETIME DEFAULT GETDATE()
);
GO


INSERT INTO Userdetails1 (Username, Password, Country, Email)
VALUES (101, 'testPass123', 'Philippines', 'sample@gmail.com');

SELECT * FROM Userdetails1;

SET IDENTITY_INSERT Userdetails1 OFF;
SET IDENTITY_INSERT Userdetails1 OFF;
GO


TRUNCATE TABLE Userdetails1; 
GO