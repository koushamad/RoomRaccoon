-- Create a new database
CREATE DATABASE room_raccoon CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Create a new user with a password if not exists
CREATE USER 'user_room'@'%' IDENTIFIED BY 'pass';

-- Grant all privileges on the new database to the new user
GRANT ALL PRIVILEGES ON room_raccoon.* TO 'user_room'@'%';

-- Apply the privileges
FLUSH PRIVILEGES;