<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/sell-bitcoincash-for-litecoin.php?error=Kindly input how much Bitcoin Cash you want to sell"); 
        }else{
             $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $bitcoinCashBalance = $row['bitcoin_cash_amount'];
                $litecoinBalance = $row['litecoin_amount'];
                $bitcoinCashAmount = $amount * 497;
                $litecoin = $bitcoinCashAmount / 133;

                if($amount > $bitcoinCashBalance){
                    header("location: ../users/sell-bitcoincash-for-litecoin.php?error=Insufficient bitcoin cash balance, Kindly Fund your wallet to complete this transaction"); 
                }else{
                  
                    
                    $bitcoinCashNewBalance = $bitcoinCashBalance - $amount;
                    $litecoinNewbalance = $litecoinBalance + $litecoin;

                    echo $bitcoinCashNewBalance;
                    
                    $sql = "UPDATE `users` SET  litecoin_amount='$litecoinNewbalance' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  bitcoin_cash_amount='$bitcoinCashNewBalance' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount bitcoin cash Sold successfully"); 
                        }else{
                            header("location: ../users/sell-bitcoincash-for-litecoin.php?error=An error occur");
                        }
                        
                    }else{
                        header("location: ../users/sell-bitcoincash-for-litecoin.php?error=An error occur"); 
                    }
                }
            }
        }
      
   }else{

      echo "no";
   }

?>