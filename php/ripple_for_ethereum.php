<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];

       if($amount == ""){
            header("location: ../users/ripple-for-ethereum.php?error=Kindly input how much ethereum you want to buy"); 
        }else{
              $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $ethereumBalance = $row['ethereum_amount'];
                $rippleBalance = $row['ripple_amount'];
                $EthereumAmount = $amount * 1985;
                $ripple = $EthereumAmount / 0.63;

                if($ripple > $rippleBalance){
                    header("location: ../users/ripple-for-ethereum.php?error=Insufficient Fund Kindly select a different payment method"); 
                }else{
                  
                    
                    $rippleNewBalancce = $rippleBalance - $ripple;
                    $ethereumNewBalance = $ethereumBalance + $amount;

                    $sql = "UPDATE `users` SET  ripple_amount='$rippleNewBalancce' WHERE id='$id'";
                    $run_query = mysqli_query($conn, $sql);
                    if($run_query == 1){
                        $sql = "UPDATE `users` SET  ethereum_amount='$ethereumNewBalance' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){
                            header("location: ../users/wallets.php?success=$amount Ethereum purchased successfully"); 
                        }else{
                            header("location: ../users/ripple-for-ethereum.php?error=An error occur");
                        }
                        
                    }else{
                        header("location: ../users/ripple-for-ethereum.php?error=An error occur"); 
                    }
                }
            }
        }
      
   }else{

      echo "no";
   }

?>