--
-- Creates a admin user that can connect from any host and sets the password for all admin users in Mariadb
--
USE mysql;
CREATE user 'admin'@'%';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%';
--UPDATE user SET password=PASSWORD("Lab123#") WHERE user='admin';
SET PASSWORD FOR 'admin'@'%' = PASSWORD('Lab123#');
flush privileges;