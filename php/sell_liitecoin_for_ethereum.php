<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/sell-litecoin-for-ethereum.php?error=Kindly input how much Litecoin you want to sell"); 
        }else{
              $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $ethereumAmount = $row['ethereum_amount'];
                $litecoinBalance = $row['litecoin_amount'];
                $litecoinAmount = $amount * 133;
                $ethereum = $litecoinAmount / 1985;

                if($amount > $litecoinBalance){
                    header("location: ../users/sell-litecoin-for-ethereum.php?error=Insufficient Litecoin Fund Kindly select a different payment method"); 
                }else{
                  
                    
                    $ethereumNewBalance = $ethereumAmount + $ethereum;
                    $litecoinNewbalance = $litecoinBalance - $amount;

                    $sql = "UPDATE `users` SET  litecoin_amount='$litecoinNewbalance' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  ethereum_amount='$ethereumNewBalance' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount Litecoin sold successfully"); 
                        }else{
                            header("location: ../users/buy-litecoin-with-ethereum.php?error=An error occur");
                        }
                        
                    }else{
                        header("location: ../users/buy-litecoin-with-ethereum.php?error=An error occur"); 
                    }
                }
            }
        }
      
   }else{

      echo "no";
   }

?>