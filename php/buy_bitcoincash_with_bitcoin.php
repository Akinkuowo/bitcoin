<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/buy-bitcoincash-with-bitcoin.php?error=Kindly input how much Bitcoin Cash you want to buy"); 
        }else{
           $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $BitcoinAmount = $row['bitcoin_amount'];
                $bitcoinCashBalance = $row['bitcoin_cash_amount'];
                
                $bitcoinCashAmount = $amount * 497;
                $bitcoin = $bitcoinCashAmount / 32162;

                if($bitcoin > $BitcoinAmount){
                    header("location: ../users/buy-bitcoincash-with-bitcoin.php?error=Insufficient Bitcoin Balance"); 
                }else{
                   
                     $bitcoinNewBalance = $BitcoinAmount - $bitcoin;
                     $bitcoinCashNewBalance = $amount + $bitcoinCashBalance;
                  
 
                     $sql = "UPDATE `users` SET  bitcoin_amount='$bitcoinNewBalance' WHERE id='$id'";
                     $run_query = mysqli_query($conn, $sql);
                     if($run_query == 1){
 
                         $sql = "UPDATE `users` SET  bitcoin_cash_amount='$bitcoinCashNewBalance' WHERE id='$id'";
                         $run_query = mysqli_query($conn, $sql);
                         
                         if($run_query == 1){
                             header("location: ../users/wallets.php?success=$amount bitcoin cash purchased successfully"); 
                         }else{
                             header("location: ../users/wallets.php?error=An error occur"); 
                         }
                     }
                 
                }

                   
            }
        }
      
   }else{

      echo "no";
   }

?>