<?php
session_start();
if(isset($_POST['payment'])){
       $crypto = $_POST['crypto'];
       $currencies = $_POST['pmCurrency'];
       $method = $_POST['method'];
       
        if($crypto == 'btc' && $method == 'Bank'){
            $_SESSION['convertMethod'] = $method;
            $_SESSION['convert'] = $crypto;
            $_SESSION['pmCurrency'] = $currencies;
        header("Location: handleCheckConvertBtc.php");
            
        }else if($crypto == 'btc' && $method == 'perfect-money'){
            $_SESSION['convertMethod'] = $method;
            $_SESSION['convert'] = $crypto;
            $_SESSION['pmCurrency'] = $currencies;
        header("Location: handleCheckConvertBtc.php");
        }else if($crypto == 'eth' && $method == 'Bank'){
            $_SESSION['convertMethod'] = $method;
            $_SESSION['convert'] = $crypto;
            $_SESSION['pmCurrency'] = $currencies;
        header("Location: handleCheckConvertEth.php");
        }else if($crypto == 'eth' && $method == 'perfect-money'){
            $_SESSION['convertMethod'] = $method;
            $_SESSION['convert'] = $crypto;
            $_SESSION['pmCurrency'] = $currencies;
        header("Location: handleCheckConvertEth.php");
        }else if($crypto == 'ltc' && $method == 'Bank'){
            $_SESSION['convertMethod'] = $method;
            $_SESSION['convert'] = $crypto;
            $_SESSION['pmCurrency'] = $currencies;
        header("Location: handleCheckConvertLtc.php");
        }else if($crypto == 'ltc' && $method == 'perfect-money'){
            $_SESSION['convertMethod'] = $method;
            $_SESSION['convert'] = $crypto;
            $_SESSION['pmCurrency'] = $currencies;
        header("Location: handleCheckConvertLtc.php");
        }else if($crypto == 'xpl' && $method == 'Bank'){
            $_SESSION['convertMethod'] = $method;
            $_SESSION['convert'] = $crypto;
            $_SESSION['pmCurrency'] = $currencies;
        header("Location: handleCheckConvertXrp.php");
        }else if($crypto == 'xpl' && $method == 'perfect-money'){
            $_SESSION['convertMethod'] = $method;
            $_SESSION['convert'] = $crypto;
            $_SESSION['pmCurrency'] = $currencies;
        header("Location: handleCheckConvertXrp.php");
        }else if($crypto == 'Bch' && $method == 'Bank'){
            $_SESSION['convertMethod'] = $method;
            $_SESSION['convert'] = $crypto;
            $_SESSION['pmCurrency'] = $currencies;
        header("Location: handleCheckConvertBch.php");
        }else if($crypto == 'Bch' && $method == 'perfect-money'){
            $_SESSION['convertMethod'] = $method;
            $_SESSION['convert'] = $crypto;
            $_SESSION['pmCurrency'] = $currencies;
        header("Location: handleCheckConvertBch.php");
        }
}else{

      echo "no";
   }

?>
