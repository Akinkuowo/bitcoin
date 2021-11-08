<?php

session_start();

if (isset($_POST['upload'])) {
    
    $Target = "../users/images/".basename($_FILES['pfp']['name']);
  
    $db = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

    $pics = $_FILES['pfp']['name'];

    if($pics == ""){
        header("location: ../users/update_profile.php?error= Kindly select a profile picture");
    }else{
        $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

        $id = $_SESSION['id'];
        
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) === 1){
             $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
            $update = "UPDATE `users` SET profile_pics='$pics' WHERE id='$id'";
            $query = mysqli_query($conn, $update);
            if($query == 1){
                move_uploaded_file($_FILES['pfp']['tmp_name'],  $Target);
                header("location: ../users/index.php?success=Profile Picture Updated Successfuly");  
            }else{
                header("location: ../users/update_profile.php?error= There was an error updating your profile picture");
            }
        }else{
            header("location: ../users/update_profile.php?error= User Not Found");
        }
    }

}


?>