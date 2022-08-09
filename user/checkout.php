<?php
session_start();
include 'database.php';

if(isset($_POST['checkout']))
{
    $id=$_SESSION['id'];

    $query = "INSERT INTO checkout (name, ic, category, course, semester) SELECT name, ic, category, course, semester FROM users WHERE id=$id";
    $query_run = mysqli_query($link, $query);

    if($query_run){
        $_SESSION['status'] = "<span font-size='10' style='color:#FFA500'>You have successfully checked in to the library :)</span>";
        header("Location: main.php");
    }
    else{
        $_SESSION['error'] = "Check in failed";
        header("Location: indeks.php");
    }

    }
    ?>