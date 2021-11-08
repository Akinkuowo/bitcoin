<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $price = $_POST['price'];
       $current = $_POST['current'];
       $id = $_SESSION['id'];
       $_SESSION['amount'] = $amount;
       $_SESSION['price'] = $price;
        $_SESSION['current'] = $current;
       
       

      if($amount == ""){
            header("location: ../users/bitcoin-buy.php?error=Kindly input how much bitcoin you want to buy"); 
        }else{
             header("location: ../users/buy-bitcoin.php"); 
                   
        }
      
   }else{

      echo "no";
   }

?>