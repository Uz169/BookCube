<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "MySQL123*";
$dbname = "websql";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
