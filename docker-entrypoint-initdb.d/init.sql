-- Create a new database
CREATE DATABASE livedata;

-- Create a new user with a password
CREATE USER postgres WITH ENCRYPTED PASSWORD "Nepal@323";

-- Grant all privileges on the new database to the new user
GRANT ALL PRIVILEGES ON DATABASE livedata TO postgres;

-- Optionally: Create some tables or other database objects
-- CREATE TABLE mytable (
--   id SERIAL PRIMARY KEY,
--   name VARCHAR(100) NOT NULL
-- );
