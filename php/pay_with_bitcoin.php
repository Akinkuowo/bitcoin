<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/pay-with-bitcoin.php?error=Kindly input how much bitcoin you want to buy"); 
        }else{
             $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $BitcoinAmount = $row['bitcoin_amount'];
                $EthereumBalance = $row['ethereum_amount'];
                
                $ethereumAmount = $amount * 1985;
                $bitcoin = $ethereumAmount / 32162;

                if($bitcoin > $BitcoinAmount){
                    header("location: ../users/pay-with-bitcoin.php?error=Insufficient Fund Kindly select a different payment method"); 
                }else{
                   
                   
                     $bitcoinNewBalance = $BitcoinAmount - $bitcoin;
                     $EthereumNewBalance = $amount + $EthereumBalance;
                  
 
                     $sql = "UPDATE `users` SET  bitcoin_amount='$bitcoinNewBalance' WHERE id='$id'";
                     $run_query = mysqli_query($conn, $sql);
                     if($run_query == 1){
 
                         $sql = "UPDATE `users` SET  ethereum_amount='$EthereumNewBalance' WHERE id='$id'";
                         $run_query = mysqli_query($conn, $sql);
                         
                         if($run_query == 1){
                             header("location: ../users/wallets.php?success=$amount Ethereum purchased successfully"); 
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