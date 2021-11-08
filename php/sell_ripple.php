<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/sell-ripple.php?error=Kindly input how much ripple you want to sell"); 
        }else{
            $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');


            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $BitcoinBalance = $row['ripple_amount'];
                $wallet = $row['ripple'];
                $date = date("Y-m-d");
                $email = $row['email'];
                $LastName = $row['last_name'];

                if($amount > $BitcoinBalance){
                    header("location: ../users/sell-ripple.php?error=Insufficient wallet balance! You have $BitcoinBalance XRP. Fund your wallet to sell"); 
                }else{
                    header("location: ../users/sell-ripple.php?error=Sorry, we are not buying cryptocurrencies at the moment, please try again later");    
                }
            }
        }
      
   }else{

      echo "no";
   }

?>