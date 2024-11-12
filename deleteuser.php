<?php
include 'connection.php';

$userId=$_GET['id'];

$deleteSql="DELETE FROM prayojan WHERE id='$userId'";
 $deleteResult = mysqli_query($connection,$deleteSql);

 if($deleteResult){
     echo "User has been deleted successfully.";
     header("location:studentdata.php");
 } else{
     echo "Sorry, user can't be deleted.";
 }




?>