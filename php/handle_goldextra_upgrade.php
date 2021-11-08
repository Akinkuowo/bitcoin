<?php
session_start();
   if(isset($_POST['upgrade'])){
      
      $first_name = $_POST['first-name'];
      $last_name = $_POST['last-name'];
      $email = $_POST['email-address'];
      $unique_id = $_POST['unique-id'];
      $pics = $_FILES['file']['name'];

      $Target = "../users/file/".basename($_FILES['file']['name']);

      $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

      $id = $_SESSION['id'];
        
      $sql = "SELECT * FROM users WHERE id = '$id'";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        $Ethereum = $row['ethereum_amount'];

            if($Ethereum >= 120){

                
                    move_uploaded_file($_FILES['file']['tmp_name'],  $Target);

                    $to = "admin@vaulta-wallet.com";
                    $image = "https://vaulta-wallet.com/users/file/$pics";
                    $HtmlImage = "<img src'$image' />";
                    $subject = "Upgrade to goldextra verification level";
                    $email = "$email";
                    $message = "Account Upgrade:";
                    $body = "";
        
                    $body .= "from: Vaulta-Wallet"."\r\n";
                    $body .= "First Name: ".$first_name."\r\n";
                    $body .= "Last Name: ".$last_name."\r\n";
                    $body .= "email: ".$email."\r\n";
                    $body .= "Unique ID: ".$unique_id."\r\n";
                    $body .= "Uploaded file: ".$HtmlImage."\r\n";
        
                    mail($to, $subject, $body);
                    
                    header('Location: ../users/goldExtra_upgrade.php?success= Your upgrade application to goldExtra member  has been sent successfully. We will email you within 24-48 hours once your documents are verified and approved.');
                
        
            }else{
                header("location: ../users/goldExtra_upgrade.php?error= Sorry, your ETH balance does not meet up with the minimum limit for the upgrade. You must have a balance of 120 ETH to qualify for a goldExtra member. (NB: This is not a fee but just a qualification for the upgrade as it remains on your ETH wallet balance after the upgrade).");
            }

      }

   }else{

      echo "no";
   }

?>