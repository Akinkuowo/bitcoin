<?php
session_start();
   if(isset($_POST['update'])){
      

      $first_name = $_POST['full-name'];
      $last_name = $_POST['sur-name'];
      $phone = $_POST['mobile-number'];
      $dob = $_POST['date-of-birth'];
      $country = $_POST['Nationality'];

      $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

      $id = $_SESSION['id'];
        
      $sql = "SELECT * FROM users WHERE id = '$id'";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
    
        $sql = "UPDATE `users` SET  first_name='$first_name' WHERE id='$id'";
        $run_query = mysqli_query($conn, $sql);
            
        if($run_query == 1){
            $sql = "UPDATE `users` SET  last_name='$last_name' WHERE id='$id'";
            $run_query = mysqli_query($conn, $sql);
               
            if($run_query == 1){
               $sql = "UPDATE `users` SET  phone='$phone' WHERE id='$id'";
               $run_query = mysqli_query($conn, $sql);
                     
               if($run_query == 1){
                  $sql = "UPDATE `users` SET  D_O_B='$dob' WHERE id='$id'";
                  $run_query = mysqli_query($conn, $sql);
                        
                  if($run_query == 1){
                     $sql = "UPDATE `users` SET  country='$country' WHERE id='$id'";
                     $run_query = mysqli_query($conn, $sql);
                           
                     if($run_query == 1){
                        header('Location: ../users/index.php?success= Profile updated successfully. ');
                     }
                  }
               }
            }
        
        }else{
            echo "not updated";
        }
      }
              
   }else{

      echo "no";
   }

?>