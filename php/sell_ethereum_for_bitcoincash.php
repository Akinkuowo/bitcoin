<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/sell-ethereum-for-bitcoincash.php?error=Kindly input how much Ethereum you want to sell"); 
        }else{
               $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $ethereumBalance = $row['ethereum_amount'];
                $bitcoinCashBalance = $row['bitcoin_cash_amount'];
                $ethereumAmount = $amount * 1985;
                $bitcoinCash = $bitcoinAmount / 497;

                if($amount > $ethereumBalance){
                    header("location: ../users/sell-ethereum-for-bitcoincash.php?error=Insufficient Ethereum Balance Kindly Fund your Ethereum wallet to complete your transaction"); 
                }else{
                  
                    
                    $ethereumNewBalance = $ethereumBalance - $amount;
                    $bitcoinCashNewbalance = $bitcoinCashBalance - $bitcoinCash;

                    $sql = "UPDATE `users` SET  bitcoin_cash_amount='$bitcoinCashNewbalance' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  ethereum_amount='$ethereumNewBalance' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount Ethereum sold successfully"); 
                        }else{
                            header("location: ../users/sell-bitcoincash-for-ethereum.php?error=An error occur");
                        }
                        
                    }else{
                        header("location: ../users/sell-bitcoincash-for-ethereum.php?error=An error occur"); 
                    }
                }
            }
        }
      
   }else{

      echo "no";
   }

?>