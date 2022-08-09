<?php
session_start();
include'database.php';
//Checking session is valid or not
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{

// for updating user info    
if(isset($_POST['edit']))
{
  $id=$_SESSION['id'];
  $name=$_POST['name'];
  $ic=$_POST['ic'];
	$category=$_POST['slct1'];
	//$matric=$_POST['matric'];
	$course=$_POST['slct2'];
  $semester=$_POST['slct3'];

$query=mysqli_query($link,"update users set name = '$name', ic= '$ic', category = '$category', course = '$course', semester = '$semester' where id='$id'");
//$_SESSION['msg']="Profile Updated successfully";
        echo '<script> alert("Staff\'s Information Successfully Updated.")</script>';
        header("location: profiles.php");
}
  }
?>