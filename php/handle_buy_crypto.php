<?php
session_start();
   if(isset($_POST['payment'])){
       $crypto = $_POST['crypto'];
       $currencies = $_POST['currencies'];
       
      if($crypto == "btc" && $currencies == "usd"){
          $_SESSION["currencies"] = $currencies;
          header("Location: handleCheckBuyBtc.php");
      }else if($crypto == "btc" && $currencies == "euro"){
          $_SESSION["currencies"] = $currencies;
          header("Location: handleCheckBuyBtc.php");
      }else if($crypto == "eth" && $currencies == "usd"){
          header("Location: handleCheckBuyEth.php");
      }else if($crypto == "eth" && $currencies == "euro"){
          header("Location: handleCheckBuyEth.php");
      }else if($crypto == "ltc" && $currencies == "usd"){
          header("Location: handleCheckBuyLtc.php");
      }else if($crypto == "ltc" && $currencies == "euro"){
          header("Location: handleCheckBuyLtc.php");
      }else if($crypto == "xpl" && $currencies == "usd"){
          header("Location: handleCheckBuyXrp.php");
      }else if($crypto == "xpl" && $currencies == "euro"){
          header("Location: handleCheckBuyXrp.php");
      }else if($crypto == "Bch" && $currencies == "usd"){
          header("Location: handleCheckBuyBch.php");
      }else if($crypto == "Bch" && $currencies == "euro"){
          header("Location: handleCheckBuyBch.php");
      }
       
      
   }else{

      echo "no";
   }

?>
