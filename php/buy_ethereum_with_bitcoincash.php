<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/buy-ethereum-with-bitcoincash.php?error=Kindly input how much Ethereum you want to buy"); 
        }else{
            $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');


            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $ethereumBalance = $row['ethereum_amount'];
                $bitcoinCashBalance = $row['bitcoin_cash_amount'];
                $ethereumAmount = $amount * 1985;
                $bitcoinCash = $ethereumAmount / 497;

                if($bitcoinCash > $bitcoinCashBalance){
                    header("location: ../users/buy-ethereum-with-bitcoincash.php?error=Insufficient Bitcoin Cash Balance Kindly Fund your bitcoin cash wallet to complete transaction"); 
                }else{
                  
                    
                    $ethereumNewBalance = $ethereumBalance + $amount;
                    $bitcoinCashNewbalance = $bitcoinCashBalance - $bitcoinCash;

                    $sql = "UPDATE `users` SET  bitcoin_cash_amount='$bitcoinCashNewbalance' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  ethereum_amount='$ethereumNewBalance' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount ethereum purchased successfully"); 
                        }else{
                            header("location: ../users/buy-ethereum-with-bitcoincash.php?error=An error occur");
                        }
                        
                    }else{
                        header("location: ../users/buy-ethereum-with-bitcoincash.php?error=An error occur"); 
                    }
                }
            }
        }
      
   }else{

      echo "no";
   }

?>