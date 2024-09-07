<?php

require_once('database/dbconn.php');

//Checks if username already exists or not

if (!empty($_POST["username"])) {
  $query = "SELECT * FROM user WHERE username=:username";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':username', $_POST["username"], PDO::PARAM_STR);
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    echo "<span style='color:red'> Sorry Username already use or exists .</span>";
  } else {
    echo "<span style='color:green'> Username available for Registration .</span>";
    echo "<script>$('#submit').prop('disabled',false);</script>";
  }
}

//Checks if email already exists or not
if (!empty($_POST["email"])) {
  $query = "SELECT * FROM registration WHERE email=:email";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    echo "<span style='color:red'> Sorry email is already used. .</span>";
    echo "<script>$('#submit').prop('disabled',true);</script>";
  } else {
    echo "<span style='color:green'> Email available for Registration .</span>";
    echo "<script>$('#submit').prop('disabled',false);</script>";
  }
}

if (!empty($_POST["newPhoneNumber"])) {
  $query = "SELECT * FROM customer WHERE PhoneNumber = :PhoneNumber";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':PhoneNumber', $_POST["newPhoneNumber"], PDO::PARAM_STR);
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    echo "<span style='color:red'> Sorry Number is already used. .</span>";
    echo "<script>$('#submit').prop('disabled',true);</script>";
  } else {
    echo "<span style='color:green'> Mobile Number is available.</span>";
    echo "<script>$('#submit').prop('disabled',false);</script>";
  }
}


if (!empty($_GET["PhoneNumber"])) {
  $query = "SELECT * FROM registration WHERE PhoneNumber = :PhoneNumber";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':PhoneNumber', $_GET["PhoneNumber"], PDO::PARAM_STR);
  $stmt->execute();
  $count = $stmt->rowCount();
  if ($count > 0) {
    echo "already_used";
  } else {
    echo "available";
  }
}
