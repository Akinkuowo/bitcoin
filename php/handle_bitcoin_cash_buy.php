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
            header("location: ../users/bitcoincash-buy.php?error=Kindly input how much Bitcoin Cash you want to buy"); 
        }else{
             header("location: ../users/buy-bitcoincash.php"); 
                   
        }
      
   }else{

      echo "no";
   }

?>
