<head>
//	<title>Shayna's Site</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box;}

body { 
  margin: 0;
 font-family: Arial, Helvetica, sans-serif;
}

.header {
  overflow: hidden;
 background-color: #f1f1f1;
  padding: 20px 10px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: #8B008B;
  color: white;
}

.header-right {
  float: right;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  
  .header-right {
    float: none;
  }
}
</style>

<?php
require("config.php");
session_start();
?>
<div class="header">
	<a href="login.php" class="logo">Shayna's Site</a>
	<div class="header-right">
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
	<a href="logout.php">Logout</a>
  </div>



</head>