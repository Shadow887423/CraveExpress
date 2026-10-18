-- 1. Create the Database
IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'CraveExpressDB')
BEGIN
    CREATE DATABASE CraveExpressDB;
END
GO

-- 2. Switch to the new Database
USE CraveExpressDB;
GO

-- 3. Create the Users Table
IF NOT EXISTS (SELECT * FROM sys.tables WHERE name = 'Users')
BEGIN
    CREATE TABLE Users (
        UserID INT IDENTITY(1,1) PRIMARY KEY, -- Auto-increments (1, 2, 3...)
        FullName NVARCHAR(100) NOT NULL,       -- Supports special characters
        Email NVARCHAR(255) UNIQUE NOT NULL,   -- Prevents duplicate accounts
        PhoneNumber NVARCHAR(20),
        PasswordHash NVARCHAR(MAX) NOT NULL,   -- Long enough for PHP password_hash()
        CreatedAt DATETIME DEFAULT GETDATE()   -- Automatically logs the time
    );
END
GO

-- 4. INSERT INTO (Manual Test Example)
-- Note: We do NOT include UserID or CreatedAt because SQL handles them automatically.
INSERT INTO Users (FullName, Email, PhoneNumber, PasswordHash)
VALUES ('John Doe', 'john@example.com', '09123456789', 'this_will_be_a_hashed_string_from_php');
GO

-- 5. Verify the data is there
SELECT * FROM Users;