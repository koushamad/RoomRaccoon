-- Apply the privileges
FLUSH PRIVILEGES;

-- Use the new database
USE room_raccoon;
-- Create the shopping_list table
CREATE TABLE shopping_list (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               item_name VARCHAR(255) NOT NULL,
                               checked BOOLEAN NOT NULL DEFAULT FALSE,
                               quantity INT NOT NULL
);