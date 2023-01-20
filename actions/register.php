<?php
include "../classes/User.php";

// Create an obj
$user = new User;

// Call the method
$user->store($_POST);

// print_r($_POST);
