CREATE DATABASE IF NOT EXISTS myDb;
CREATE USER 'new_user'@'localhost' IDENTIFIED BY '123';
GRANT ALL ON myDb.* TO 'new_user'@'localhost';