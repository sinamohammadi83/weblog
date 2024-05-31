<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weblog";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

    $conn->exec($sql);
    echo "Database created successfully<br>";
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = " CREATE TABLE IF NOT EXISTS Users (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(30) NOT NULL,
  lastname VARCHAR(30) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL ,
  status VARCHAR(10) NOT NULL   
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );    
    CREATE TABLE IF NOT EXISTS Posts (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id VARCHAR(30) NOT NULL,
  category_id int(2) NOT NULL,
  title VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  picture VARCHAR(250) NOT NULL,
  post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  read_time int(2) NOT NULL,
  slug VARCHAR(120) NOT NULL,
  status VARCHAR(10) NOT NULL
  );
CREATE TABLE IF NOT EXISTS Comments (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id VARCHAR(30) NOT NULL,
  post_id VARCHAR(30) NOT NULL,
  contents TEXT NOT NULL,
  comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );
CREATE TABLE IF NOT EXISTS Category (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(30) NOT NULL
  );
CREATE TABLE IF NOT EXISTS Admins (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL,
  firstname VARCHAR(30) NOT NULL,
  lastname VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL ,
  password VARCHAR(50) NOT NULL ,
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  ); 
CREATE TABLE IF NOT EXISTS Banners (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(30) NOT NULL,
  content VARCHAR(30) NOT NULL,
  picture VARCHAR(50) NOT NULL,
  contents VARCHAR(250) NOT NULL,
  start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  expire_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );
CREATE TABLE IF NOT EXISTS verification (
    id int(5) AUTO_INCREMENT,
    token VARCHAR(50),
    email VARCHAR(50),
    code int(6),
    PRIMARY KEY (id)
)
";

    $conn->exec($sql);
    echo "Tables created successfully";
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
//test
?>