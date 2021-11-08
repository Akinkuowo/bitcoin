<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/ethereum-for-bitcoin.php?error=Kindly input how much Ethereum you want to Sell"); 
        }else{
              $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $ethereumBalance = $row['ethereum_amount'];
                $BitcoinBalance = $row['bitcoin_amount'];
                $ethereumAmount = $amount * 1985;
                $bitcoin = $ethereumAmount / 32162;

                if($amount > $ethereumBalance){
                    header("location: ../users/ethereum-for-bitcoin.php?error=Insufficient Wallet Fund Kindly select a different payment method or fund your wallet"); 
                }else{
                  
                    
                    $bitcoinNewBalance = $BitcoinBalance + $bitcoin;
                    $ethereumNewBalance = $ethereumBalance - $amount;

                   

                    $sql = "UPDATE `users` SET  bitcoin_amount='$bitcoinNewBalance' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  ethereum_amount=' $ethereumNewBalance' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount ethereum sold successfully"); 
                        }else{
                            header("location: ../users/ethereum-for-bitcoin.php?error=An error occur");
                        }
                        
                    }else{
                        header("location: ../users/ethereum-for-bitcoin.php?error=An error occur"); 
                    }
                }
            }
        }
      
   }else{

      echo "no";
   }

?>