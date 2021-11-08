<?php
session_start();
   if(isset($_POST['payment'])){
       $name = $_POST['name'];
       $number = $_POST['pm-number'];
       $unique_id = $_POST['unique_id'];
       $id = $_SESSION['id'];
       $qty = $_SESSION['amount'];
       $amount = $_SESSION['price'];
       $crypto= $_POST['crypto'];
       $fee = $_POST['vaultafeeamount'];
       $coin = "LTC";
      $date = date("y/m/d");
      $details = $_SESSION['current'];
      function createToken($len=32){
         return substr(md5(openssl_random_pseudo_bytes(30)), -$len);
      }
     $transaction_id = createToken(20);
       

       $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

       $id = $_SESSION['id'];
         
       $sql = "SELECT * FROM users WHERE id = '$id'";
       $result = mysqli_query($conn, $sql);
 
       if(mysqli_num_rows($result) === 1){
         $row = mysqli_fetch_assoc($result);
         $bitcoin = $row['litecoin_amount'];
         $ethereum_amount = $row['ethereum_amount'];
         $convert_limit = $row['send_limit'];
         $uniqueid = $row["unique_id"];
     
         $level = $row['level'];
         if($name == ""){
            header("location: ../users/select-pm-ltc-account.php?error=Kindly enter your name");
         }else if($unique_id == ""){
            header("location: ../users/select-pm-ltc-account.php?error=Kindly enter your unique id");
         }else if($number == ""){
            header("location: ../users/select-pm-ltc-account.php?error=Kindly enter your Perfect Money account number");
         }else{
            if($level == "Basic"){
               if($convert_limit >= 1000){
                  header("location: ../users/convert-litecoin-to-bank.php?upgrade=Your daily limit as a basic member is $10 to $1,000, kindly upgrade your membership verification level to increase your transaction limit");
               }else{
                  if($fee > $ethereum_amount){
                     header("location: ../users/convert-litecoin-to-bank.php?error=Insuffient ETH balance (Note: Your ETH balance must be sufficient to cover the network fee)");
                  }else{
                  
                     $bitcoinBalance = $bitcoin - $qty;
                     $send_limit = $convert_limit + $amount; 
                     $newEthereumBalance = $ethereum_amount - $fee;


                     $sql = "UPDATE `users` SET  litecoin_amount='$bitcoinBalance' WHERE id='$id'";
                     $run_query = mysqli_query($conn, $sql);

                     if($run_query == 1){
                        
                        $sql = "UPDATE `users` SET  send_limit='$send_limit' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){

                           $sql = "UPDATE `users` SET  ethereum_amount='$newEthereumBalance' WHERE id='$id'";
                           $run_query = mysqli_query($conn, $sql);

                           if($run_query == 1){

                              $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                              $sql = "SELECT * FROM users WHERE id = '$id'";
                              $result = mysqli_query($conn, $sql);

                              if(mysqli_num_rows($result) === 1){
                                 $row = mysqli_fetch_assoc($result);
                                 $wallet = $row["bitcoin_cash"];
                                 $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type) VALUES('$details', '$qty', '$coin', '$date', '$id', '$amount', '$number', '$transaction_id','towallet', 'Convert')";
                                 $run_query = mysqli_query($conn, $sql);
                                 
                                 if($run_query == 1){
                                    
                                    $to = "akinseun1990@gmail.com";
                                    $subject = "Convert Litecoin for perfect money";
                                    $email = "$email";
                                    $message = "Convert Litecoin";
                                    $body = "";
                           
                                    $body .= "from: Vaulta-Wallet"."\r\n";
                                    $body .= "First Name: ".$name."\r\n";
                                    $body .= "Account Number: ".$number."\r\n";
                                    $body .= "Qyantity: ".$qty."\r\n";
                                    $body .= "Amount: ".$amount."\r\n";
                                    $body .= "Unique Id: ".$uniqueid."\r\n";
                           
                                    mail($to, $subject, $body);
                                    
                                    header('Location: ../users/convert.php?success= Your application to convert bitcoin to US Dollar has been sent successfully. Your account will be created within 24-48 hours.. ');
                                 }
                              }
                           }
                        }
                  
                     }
                  }
               }
            }else if($level == "Bronze"){
               if($convert_limit >= 5000){
                  header("location: ../users/convert-litecoin-to-bank.php?upgrade=Your daily limit as a bronze member is $10 to $5,000, kindly upgrade your membership verification level to increase your transaction limit");
               }else{
                  if($fee > $ethereum_amount){
                     header("location: ../users/convert-litecoin-to-bank.php?error=Insuffient ETH balance (Note: Your ETH balance must be sufficient to cover the network fee)");
                  }else{
                     if($fee > $ethereum_amount){
                        header("location: ../users/convert-litecoin-to-bank.php?error=Insuffient ETH balance (Note: Your ETH balance must be sufficient to cover the network fee)");
                     }else{
                        $bitcoinBalance = $bitcoin - $qty;
                        $send_limit = $convert_limit + $amount; 
                        $newEthereumBalance = $ethereum_amount - $fee;

                        $sql = "UPDATE `users` SET  litecoin_amount='$bitcoinBalance' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                     if($run_query == 1){
                        
                        $sql = "UPDATE `users` SET  send_limit='$send_limit' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){

                           $sql = "UPDATE `users` SET  ethereum_amount='$newEthereumBalance' WHERE id='$id'";
                           $run_query = mysqli_query($conn, $sql);

                           if($run_query == 1){

                              $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                              $sql = "SELECT * FROM users WHERE id = '$id'";
                              $result = mysqli_query($conn, $sql);

                              if(mysqli_num_rows($result) === 1){
                                 $row = mysqli_fetch_assoc($result);
                                 $wallet = $row["bitcoin_cash"];
                                 $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type) VALUES('$details', '$qty', '$coin', '$date', '$id', '$amount', '$number', '$transaction_id','towallet', 'Convert')";
                                 $run_query = mysqli_query($conn, $sql);
                                 
                                 if($run_query == 1){
                                    
                                    $to = "akinseun1990@gmail.com";
                                    $subject = "Convert Litecoin for perfect money";
                                    $email = "$email";
                                    $message = "Convert Litecoin";
                                    $body = "";
                           
                                    $body .= "from: Vaulta-Wallet"."\r\n";
                                    $body .= "First Name: ".$name."\r\n";
                                    $body .= "Account Number: ".$number."\r\n";
                                    $body .= "Qyantity: ".$qty."\r\n";
                                    $body .= "Amount: ".$amount."\r\n";
                                     $body .= "Unique Id: ".$uniqueid."\r\n";
                           
                                    mail($to, $subject, $body);
                                    
                                    header('Location: ../users/convert.php?success= Your application to convert bitcoin to US Dollar has been sent successfully. Your account will be created within 24-48 hours.. ');
                                 }
                              }
                           }
                     
                        }
                     }
                  }
                  }
               }
            }elseif($level == "Silver"){
               if($convert_limit >= 10000){
                  header("location: ../users/convert-litecoin-to-bank.php?upgrade=Your daily limit as a silver member is $10 to $10,000, kindly upgrade your membership verification level to increase your transaction limit");
               }else{
                  if($fee > $ethereum_amount){
                     header("location: ../users/convert-litecoin-to-bank.php?error=Insuffient ETH balance (Note: Your ETH balance must be sufficient to cover the network fee)");
                  }else{
                     $bitcoinBalance = $bitcoin - $qty;
                     $send_limit = $convert_limit + $amount; 
                     $newEthereumBalance = $ethereum_amount - $fee;

                     $sql = "UPDATE `users` SET  litecoin_amount='$bitcoinBalance' WHERE id='$id'";
                     $run_query = mysqli_query($conn, $sql);

                     if($run_query == 1){
                        
                        $sql = "UPDATE `users` SET  send_limit='$send_limit' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){

                           $sql = "UPDATE `users` SET  ethereum_amount='$newEthereumBalance' WHERE id='$id'";
                           $run_query = mysqli_query($conn, $sql);

                           if($run_query == 1){

                             $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                              $sql = "SELECT * FROM users WHERE id = '$id'";
                              $result = mysqli_query($conn, $sql);

                              if(mysqli_num_rows($result) === 1){
                                 $row = mysqli_fetch_assoc($result);
                                 $wallet = $row["bitcoin_cash"];
                                 $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type) VALUES('$details', '$qty', '$coin', '$date', '$id', '$amount', '$number', '$transaction_id','towallet', 'Convert')";
                                 $run_query = mysqli_query($conn, $sql);
                                 
                                 if($run_query == 1){
                                    
                                    $to = "akinseun1990@gmail.com";
                                    $subject = "Convert Litecoin for perfect money";
                                    $email = "$email";
                                    $message = "Convert Litecoin";
                                    $body = "";
                           
                                    $body .= "from: Vaulta-Wallet"."\r\n";
                                    $body .= "First Name: ".$name."\r\n";
                                    $body .= "Account Number: ".$number."\r\n";
                                    $body .= "Qyantity: ".$qty."\r\n";
                                    $body .= "Amount: ".$amount."\r\n";
                                     $body .= "Unique Id: ".$uniqueid."\r\n";
                           
                                    mail($to, $subject, $body);
                                    
                                    header('Location: ../users/convert.php?success= Your application to convert bitcoin to US Dollar has been sent successfully. Your account will be created within 24-48 hours.. ');
                                 }
                              }
                           }
                        }
                  
                     }
                  }
               }
            }elseif($level == "Gold"){
               if($convert_limit >= 15000){
                  header("location: ../users/convert-litecoin-to-bank.php?upgrade=Your daily limit as a gold member is $10 to $15,000, kindly upgrade your membership verification level to increase your transaction limit");
               }else{
                  if($fee > $ethereum_amount){
                     header("location: ../users/convert-litecoin-to-bank.php?error=Insuffient ETH balance (Note: Your ETH balance must be sufficient to cover the network fee)");
                  }else{
                     $bitcoinBalance = $bitcoin - $qty;
                     $send_limit = $convert_limit + $amount; 
                     $newEthereumBalance = $ethereum_amount -$fee;

                     $sql = "UPDATE `users` SET  litecoin_amount='$bitcoinBalance' WHERE id='$id'";
                     $run_query = mysqli_query($conn, $sql);

                     if($run_query == 1){
                        
                        $sql = "UPDATE `users` SET  send_limit='$send_limit' WHERE id='$id'";
                        $run_query = mysqli_query($conn, $sql);

                        if($run_query == 1){

                           $sql = "UPDATE `users` SET  ethereum_amount='$newEthereumBalance' WHERE id='$id'";
                           $run_query = mysqli_query($conn, $sql);

                           if($run_query == 1){

                              $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                              $sql = "SELECT * FROM users WHERE id = '$id'";
                              $result = mysqli_query($conn, $sql);

                              if(mysqli_num_rows($result) === 1){
                                 $row = mysqli_fetch_assoc($result);
                                 $wallet = $row["bitcoin_cash"];
                                 $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type) VALUES('$details', '$qty', '$coin', '$date', '$id', '$amount', '$number', '$transaction_id','towallet', 'Convert')";
                                 $run_query = mysqli_query($conn, $sql);
                                 
                                 if($run_query == 1){
                                    
                                    $to = "akinseun1990@gmail.com";
                                    $subject = "Convert Litecoin for perfect money";
                                    $email = "$email";
                                    $message = "Convert Litecoin";
                                    $body = "";
                           
                                    $body .= "from: Vaulta-Wallet"."\r\n";
                                    $body .= "First Name: ".$name."\r\n";
                                    $body .= "Account Number: ".$number."\r\n";
                                    $body .= "Qyantity: ".$qty."\r\n";
                                    $body .= "Amount: ".$amount."\r\n";
                                     $body .= "Unique Id: ".$uniqueid."\r\n";
                           
                                    mail($to, $subject, $body);

                                    header('Location: ../users/convert.php?success= Your application to convert bitcoin to US Dollar has been sent successfully. Your account will be created within 24-48 hours.. ');
                                 }
                              }
                           }
                        }
                  
                     }
                  }
               }
            }elseif($level == "GoldExtra"){
               $bitcoinBalance = $bitcoin - $qty;
               $newEthereumBalance = $ethereum_amount - $fee;

               $sql = "UPDATE `users` SET  litecoin_amount='$bitcoinBalance' WHERE id='$id'";
               $run_query = mysqli_query($conn, $sql);

               if($run_query == 1){

               
                  $sql = "UPDATE `users` SET  ethereum_amount='$newEthereumBalance' WHERE id='$id'";
                           $run_query = mysqli_query($conn, $sql);

                           if($run_query == 1){

                              $row = mysqli_fetch_assoc($result);
                                 $wallet = $row["litecoin"];
                                 $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type) VALUES('$details', '$qty', '$coin', '$date', '$id', '$amount', '$number', '$transaction_id','towallet', 'Convert')";
                                 $run_query = mysqli_query($conn, $sql);
                                 
                                 if($run_query == 1){
                                    
                                    $to = "akinseun1990@gmail.com";
                                    $subject = "Convert litecoin for perfect money";
                                    $email = "$email";
                                    $message = "Convert litecoin:";
                                    $body = "";
                           
                                    $body .= "from: Vaulta-Wallet"."\r\n";
                                    $body .= "First Name: ".$name."\r\n";
                                    $body .= "Account Number: ".$number."\r\n";
                                    $body .= "Qyantity: ".$qty."\r\n";
                                    $body .= "Amount: ".$amount."\r\n";
                                     $body .= "Unique Id: ".$uniqueid."\r\n";
                           
                                    mail($to, $subject, $body);
                                    
                                    header('Location: ../users/convert.php?success= Your application to convert bitcoin to US Dollar has been sent successfully. Your account will be created within 24-48 hours.. ');
                                 }
                           }               
               
               }
            }
         }
         
       }

       
   }else{

      echo "no";
   }

?>
