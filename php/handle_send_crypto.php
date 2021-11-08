<?php
session_start();
   if(isset($_POST['payment'])){
       $crypto = $_POST['crypto'];
       
      if($crypto == "btc"){
          header("Location: handleCheckSendBtc.php");
      }else if($crypto == "eth"){
          header("Location: handleCheckSendEth.php");
      }else if($crypto == "ltc"){
          header("Location: handleCheckSendLtc.php");
      }else if($crypto == "xpl"){
          header("Location: handleCheckSendXrp.php");
      }else if($crypto == "Bch"){
          header("Location: handleCheckSendBch.php");
      }
       
      
   }else{

      echo "no";
   }

?>
