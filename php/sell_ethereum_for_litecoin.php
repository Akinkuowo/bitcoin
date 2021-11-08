<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/sell-ethereum-for-litecoin.php?error=Kindly input how much ethereum you want to sell"); 
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

                if($amount > $ethereumBalance){
                    header("location: ../users/sell-ethereum-for-litecoin.php?error=Insufficient Ethereum balance, kindly Fund your Ethereum wallet to complete transaction"); 
                }else{
                  
                    
                    $ethereumNewBalance = $ethereumBalance - $amount;
                    $litecoinNewbalance = $litecoinBalance + $litecoin;

                    $sql = "UPDATE `users` SET  litecoin_amount='$litecoinNewbalance' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  ethereum_amount='$ethereumNewBalance' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount Ethereum sold successfully"); 
                        }else{
                            header("location: ../users/sell-ethereum-for-litecoin.php?error=An error occur");
                        }
                        
                    }else{
                        header("location: ../users/sell-ethereum-for-litecoin.php?error=An error occur"); 
                    }
                }
            }
        }
      
   }else{

      echo "no";
   }

?>