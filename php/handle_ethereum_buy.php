<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];
       $_SESSION['amount'] = $amount;
        $price = $_POST['price'];
       $current = $_POST['current'];
       $_SESSION['price'] = $price;
        $_SESSION['current'] = $current;
       

       if($amount == ""){
            header("location: ../users/ethereum-buy.php?error=Kindly input how much ethereum you want to buy"); 
        }else{
             header("location: ../users/buy-ethereum.php"); 
                   
        }
      
   }else{

      echo "no";
   }

?>