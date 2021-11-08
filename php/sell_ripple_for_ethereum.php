<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/sell-ripple-for-ethereum.php?error=Kindly input how much Ripple you want to Sell"); 
        }else{
              $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $ethereumAmount = $row['ethereum_amount'];
                $rippleBalance = $row['ripple_amount'];
                $rippleAmount = $amount * 0.63;
                $ethereum = $rippleAmount / 1985;

                if($amount > $rippleBalance){
                    header("location: ../users/sell-ripple-for-ethereum.php?error=Insufficient Fund Kindly select a different payment method"); 
                }else{
                  
                    
                    $ethereumMinus = $ethereumAmount + $ethereum;
                    $rippleAdd = $rippleBalance - $amount;


                    $sql = "UPDATE `users` SET  ripple_amount='$rippleAdd' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  ethereum_amount='$ethereumMinus' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount ripple sold successfully"); 
                        }else{
                            header("location: ../users/sell-ripple-for-ethereum.php?error=An error occur");
                        }
                        
                    }else{
                        header("location: ../users/sell-ripple-for-ethereum.php?error=An error occur"); 
                    }
                }
            }
        }
      
   }else{

      echo "no";
   }

?>