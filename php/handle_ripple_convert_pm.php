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
         header("location: ../users/convert-ripple-to-bank.php?error=Kindly input how much ripple you want to convert"); 
     }else{
        $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
         $sql = "SELECT * FROM users WHERE id = '$id'";
         $result = mysqli_query($conn, $sql);

         if(mysqli_num_rows($result) === 1){
             $row = mysqli_fetch_assoc($result);
             $BTCAmount = $row['ripple_amount'];

             if($amount > $BTCAmount){
                 header("location: ../users/convert-ripple-to-bank.php?error=Sorry, the amount you want to convert is greater than your XRP wallet balance"); 
             }else{
                 header("location: ../users/select-pm-xrp-account.php"); 
             }

          
         }      
     }
   
}else{

   echo "no";
}

?>

?>
