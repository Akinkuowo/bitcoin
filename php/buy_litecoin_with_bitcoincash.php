<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/buy-litecoin-with-bitcoincash.php?error=Kindly input how much Litecoin you want to buy"); 
        }else{
           $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');


            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $bitcoinCashAmount = $row['bitcoin_cash_amount'];
                $litecoinBalance = $row['litecoin_amount'];
                $litecoinAmount = $amount * 133;
                $bitcoinCash = $litecoinAmount / 497;

                if($bitcoinCash > $bitcoinCashAmount){
                    header("location: ../users/buy-litecoin-with-bitcoincash.php?error=Insufficient bitcoincash Fund Kindly select a different payment method"); 
                }else{
                  
                    
                    $bitcoinCashNewBalance = $bitcoinCashAmount - $bitcoinCash;
                    $litecoinNewbalance = $litecoinBalance + $amount;

                    $sql = "UPDATE `users` SET  litecoin_amount='$litecoinNewbalance' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  bitcoin_cash_amount='$bitcoinCashNewBalance' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount Litecoin purchased successfully"); 
                        }else{
                            header("location: ../users/buy-litecoin-with-bitcoincash.php?error=An error occur");
                        }
                        
                    }else{
                        header("location: ../users/buy-litecoin-with-bitcoincash.php?error=An error occur"); 
                    }
                }
            }
        }
      
   }else{

      echo "no";
   }

?>