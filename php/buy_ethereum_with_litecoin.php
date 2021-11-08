<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/buy-ethereum-with-litecoin.php?error=Kindly input how much Ethereum you want to buy"); 
        }else{
            $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');


            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $ethereumBalance = $row['ethereum_amount'];
                $litecoinBalance = $row['litecoin_amount'];
                $ethereumAmount = $amount * 1985;
                $litecoin = $ethereumAmount / 133;

                if($litecoin > $litecoinBalance){
                    header("location: ../users/buy-ethereum-with-litecoin.php?error=Insufficient litecoin Balance, Kindly Fund your litecoin wallet to complete transaction"); 
                }else{
                  
                    
                    $ethereumNewBalance = $ethereumBalance + $amount;
                    $litecoinNewbalance = $litecoinBalance - $litecoin;

                    $sql = "UPDATE `users` SET  litecoin_amount='$litecoinNewbalance' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  ethereum_amount='$ethereumNewBalance' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount ethereum purchased successfully"); 
                        }else{
                            header("location: ../users/buy-ethereum-with-litecoin.php?error=An error occur");
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