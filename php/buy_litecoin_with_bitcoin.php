<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/buy-litecoin-with-bitcoin.php?error=Kindly input how much Litecoin you want to buy"); 
        }else{
            $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');


            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $BitcoinAmount = $row['bitcoin_amount'];
                $LitecoinBalance = $row['litecoin_amount'];
                
                $litecoinAmount = $amount * 133;
                $bitcoin = $litecoinAmount / 32162;

                if($bitcoin > $BitcoinAmount){
                    header("location: ../users/buy-litecoin-with-bitcoin.php?error=Insufficient Bitcoin Fund"); 
                }else{
                   echo "yes";
                   
                     $bitcoinNewBalance = $BitcoinAmount - $bitcoin;
                     $litecoinNewBalance = $amount + $LitecoinBalance;
                  
 
                     $sql = "UPDATE `users` SET  bitcoin_amount='$bitcoinNewBalance' WHERE id='$id'";
                     $run_query = mysqli_query($conn, $sql);
                     if($run_query == 1){
 
                         $sql = "UPDATE `users` SET  litecoin_amount='$litecoinNewBalance' WHERE id='$id'";
                         $run_query = mysqli_query($conn, $sql);
                         
                         if($run_query == 1){
                             header("location: ../users/wallets.php?success=$amount litecoin purchased successfully"); 
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