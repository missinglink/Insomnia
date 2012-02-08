--- You must have a working MYSQL server for this example ---

--- Start by creating a new MYSQL user & granting privileges ---
CREATE USER 'php'@'localhost' IDENTIFIED BY '3889y23b4jh2bhjh5vjv2jh3vjhv5j23tg545';
GRANT ALL PRIVILEGES ON *.* TO 'php'@'localhost' IDENTIFIED BY '3889y23b4jh2bhjh5vjv2jh3vjhv5j23tg545';

--- Create a new database for the example ---
CREATE DATABASE test;

--- You can now run the doctrine2 command line application (requires php5-cli) ---
cd Application/Module/CrudExample/Scripts/
php doctrine.php orm:schema-tool:create

--- You can modify this class at any time to modify your MYSQL server settings ---
\Application\Module\CrudExample\Bootstrap\Doctrine

--- The example does not come with any fixtures, you will need to create your own entites using the Client ---