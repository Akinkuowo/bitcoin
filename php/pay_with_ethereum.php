<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/pay-with-ethereum.php?error=Kindly input how much bitcoin you want to buy"); 
        }else{
             $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $ethereumAmount = $row['ethereum_amount'];
                $BitcoinBalance = $row['bitcoin_amount'];
                $bitcoinAmount = $amount * 32162;
                $ethereum = $bitcoinAmount / 1985;

                
                if($ethereum > $ethereumAmount){
                    header("location: ../users/pay-with-ethereum.php?error=Insufficient Fund Kindly select a different payment method"); 
                }else{
                  
                    
                    $ethereumMinus = $ethereumAmount - $ethereum;
                    $bitcoinAdd = $BitcoinBalance + $amount;

                    echo 

                    $sql = "UPDATE `users` SET  bitcoin_amount='$bitcoinAdd' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  ethereum_amount='$ethereumMinus' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount bitcoin purchased successfully"); 
                        }else{
                            header("location: ../users/pay-with-ethereum.php?error=An error occur");
                        }
                        
                    }else{
                        header("location: ../users/pay-with-ethereum.php?error=An error occur"); 
                    }
                }
            }
        }
      
   }else{

      echo "no";
   }

?>