<?php
session_start();
     if(isset($_POST['payment'])){
         $id = $_SESSION['id'];
         $vaultafeeamount = $_POST['vaultafeeamount'];
         $coin = "LTC";
         $date = date('y/m/d');;
         $details = "USD";
         function createToken($len=32){
            return substr(md5(openssl_random_pseudo_bytes(30)), -$len);
        }
        $transaction_id = createToken(20);

          $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
         $sql = "SELECT * FROM users WHERE id = '$id'";
         $result = mysqli_query($conn, $sql);

         $usd = $amount * 175;
         $usd_amount = number_format($usd); 

         if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            $Bitcoin = $row['litecoin'];
            $send_limit = $row['send_limit'];
            $senderBitcoinBalance = $row['litecoin_amount'];
            $ethereum_amount = $row['ethereum_amount'];
            $reciever = $_SESSION['reciever'];
            $BTCAmount = round($_SESSION['usd'], 8);
            $amount = $_SESSION['Amount'];
            $TotalSend = $send_limit + $amount;
            $usd = $amount * 195.52;
            $usd_amount = number_format($usd);
            $send_limit = $row['send_limit'];
            $level = $row['level'];
            $eligible = $amount + $send_limit;
            $unique_id = $row['user_id'];
             $senderEmail = $row['email'];
            $Name = $row['first_name'];
          
            $sql = "SELECT * FROM users WHERE litecoin = '$reciever'";
            $result = mysqli_query($conn, $sql);
   
            if(mysqli_num_rows($result) === 1){
               $row = mysqli_fetch_assoc($result);
               $reciever_bitcoin_balance = $row['litecoin_amount'];
               $recieveEmail = $row['email'];
               $recieveFirstName = $row['first_name']; 
              
               if($vaultafeeamount > $ethereum_amount){
                  header("location: ../users/send-litecoin-confirmation.php?error=Insuffient ETH balance (Note: Your ETH balance must be sufficient to cover the network fee)");
               }else{
                  $senderNewBitcoinBalance = $senderBitcoinBalance - $BTCAmount;
                  $senderNewEthereumBalance = $ethereum_amount - $vaultafeeamount;
                  $receiverNewBitcoinBalance = $reciever_bitcoin_balance + $BTCAmount;
                     
                     $sql = "UPDATE `users` SET  litecoin_amount='$senderNewBitcoinBalance' WHERE id='$id'";
                     $run_query = mysqli_query($conn, $sql);
   
                     if($run_query == 1){

                           $sql = "UPDATE `users` SET  ethereum_amount='$senderNewEthereumBalance' WHERE id='$id'";
                           $run_query = mysqli_query($conn, $sql);
      
                           if($run_query == 1){
                              $sql = "UPDATE `users` SET  litecoin_amount='$receiverNewBitcoinBalance' WHERE litecoin='$reciever'";
                              $run_query = mysqli_query($conn, $sql);
                              
                              if($run_query == 1){
                                 $sql = "UPDATE `users` SET  send_limit='$TotalSend' WHERE id='$id'";
                                 $run_query = mysqli_query($conn, $sql);
               
                                 if($run_query == 1){
                                     $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE id = '$id'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                       $row = mysqli_fetch_assoc($result);
                                       $wallet = $row["litecoin"];
                                       $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type, status) VALUES('$details', '$BTCAmount', '$coin', '$date', '$id', '$amount', '$reciever', '$transaction_id','towallet', 'Send', 'Complete')";
                                       $run_query = mysqli_query($conn, $sql);
                                       if($run_query == 1){
                                            $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                          $sql = "SELECT * FROM users WHERE litecoin
                                           = '$reciever'";
                                          $result = mysqli_query($conn, $sql);

                                          if(mysqli_num_rows($result) === 1){
                                             $row = mysqli_fetch_assoc($result);
                                             $receiver_id = $row["id"];
                                             $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type, status) VALUES('$details', '$BTCAmount', '$coin', '$date', '$receiver_id', '$amount', '$reciever', '$transaction_id','towallet', 'Recieve', 'Complete')";
                                             $run_query = mysqli_query($conn, $sql);
                                             if($run_query == 1){
                                                    // allow for demo mode testing of emails
                                                define("DEMO", false); // setting to TRUE will stop the email from sending.
                                            
                                                // set the location of the template file to be loaded
                                                $template_file = "../email_templates/templete_ltc_received.php";
                                            
                                                // set the email 'from' information
                                                $email_from = "Vaulta Wallet <info@vaulta-wallet.com>";
                                            
                                                // create a list of the variables to be swapped in the html template
                                                $swap_var = array(
                                                    "{SITE_ADDR}" => "https://vaulta-wallet.com",
                                                    "{EMAIL_LOGO}" => "https://vaulta-wallet.com/images/logo2.png",
                                                    "{EMAIL_TITLE}" => "$BTCAmount LTC Received! ",
                                                    "{TO_NAME}" => "$recieveFirstName",
                                                     "{BTC_AMOUNT}" => "$BTCAmount",
                                                    "{TO_EMAIL}" => "$recieveEmail"
                                                );
                                            
                                                // create the email headers to being the email
                                                $email_headers = "From: ".$email_from."\r\nReply-To: ".$email_from."\r\n";
                                                $email_headers .= "MIME-Version: 1.0\r\n";
                                                $email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                            
                                                // load the email to and subject from the $swap_var
                                                $email_to = $swap_var['{TO_EMAIL}'];
                                                $email_subject = $swap_var['{EMAIL_TITLE}']; // you can add time() to get unique subjects for testing: time();
                                            
                                                // load in the template file for processing (after we make sure it exists)
                                                if (file_exists($template_file))
                                                    $email_message = file_get_contents($template_file);
                                                else
                                                    die ("Unable to locate your template file");
                                            
                                                // search and replace for predefined variables, like SITE_ADDR, {NAME}, {lOGO}, {CUSTOM_URL} etc
                                                foreach (array_keys($swap_var) as $key){
                                                    if (strlen($key) > 2 && trim($swap_var[$key]) != '')
                                                        $email_message = str_replace($key, $swap_var[$key], $email_message);
                                                }
                                            
                                                // display the email template back to the user for final approval
                                                echo $email_message;
                                            
                                                // check if the email script is in demo mode, if it is then dont actually send an email
                                                if (DEMO)
                                                    die("<hr /><center>This is a demo of the HTML email to be sent. No email was sent. </center>");
                                            
                                                // send the email out to the user	
                                                if ( mail($email_to, $email_subject, $email_message, $email_headers) ){
                                                    
                                                 header("location: ../users/wallets.php?success=$BTCAmount litecoin sent successfully");
                                                }
                                                 
                                             }
                                          }
                                       }
                                    }
                                      
                                 }
                              }
                           }
                     }
                                                 
               }

            }else{
               if($vaultafeeamount > $ethereum_amount){
                  header("location: ../users/send-litecoin-confirmation.php?error=Insuffient ETH balance (Note: Your ETH balance must be sufficient to cover the network fee)");
               }else{
                  if($level == "Basic"){
                      if($amount > 1000){
                          header("location: ../users/send-litecoin.php?upgrade=Your daily limit as a basic member is $10 to $1,000, kindly upgrade your membership verification level to increase your transaction limit");
                      }else{
                          if($eligible > 1000){
                              header("location: ../users/send-litecoin.php?error=Your daily limit as a basic member is $10 to $1,000, You have sent LTC worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                          }else{
                              $senderNewBitcoinBalance = $senderBitcoinBalance - $BTCAmount;
                              $senderNewEthereumBalance = $ethereum_amount - $vaultafeeamount;
                              
                                 
                                 $sql = "UPDATE `users` SET  litecoin_amount='$senderNewBitcoinBalance' WHERE id='$id'";
                                 $run_query = mysqli_query($conn, $sql);
               
                                 if($run_query == 1){
            
                                       $sql = "UPDATE `users` SET  ethereum_amount='$senderNewEthereumBalance' WHERE id='$id'";
                                       $run_query = mysqli_query($conn, $sql);
                  
                                       
                                       if($run_query == 1){
                                          $sql = "UPDATE `users` SET  send_limit='$TotalSend' WHERE id='$id'";
                                          $run_query = mysqli_query($conn, $sql);
                        
                                          if($run_query == 1){
                                          
                                               $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                             $sql = "SELECT * FROM users WHERE id = '$id'";
                                             $result = mysqli_query($conn, $sql);
            
                                             if(mysqli_num_rows($result) === 1){
                                                $row = mysqli_fetch_assoc($result);
                                                $wallet = $row["litecoin"];
                                                $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type) VALUES('$details', '$BTCAmount', '$coin', '$date', '$id', '$amount', '$reciever', '$transaction_id','towallet', 'Send')";
                                                $run_query = mysqli_query($conn, $sql);
                                                if($run_query == 1){
                                                    $to = "admin@vaulta-wallet.com";
                                                    // $to = "akinseun1990@gmail.com";
                                                    $subject = "Sent Litecoin Outside of Vaulta-wallet";
                                                    $email = "$email";
                                                    $message = "Sent Litecoin Outside of Vaulta-wallet:";
                                                    $body = "";
                                        
                                                    $body .= "from Wallet:".$Bitcoin."\r\n";
                                                    $body .= "To Wallet: ".$reciever."\r\n";
                                                    $body .= "Amount USD: ".$amount."\r\n";
                                                    $body .= "Amount LTC: ".$BTCAmount."\r\n";
                                                     $body .= "Unique ID: ".$unique_id."\r\n";
                                                    
                                        
                                                    mail($to, $subject, $body);
                                                   header("location: ../users/wallets.php?success=$BTCAmount litecoin sent successfully");
                                                }else{
                                                   
                                                }
                                             }
                                          }
                                       }
                                    
                                 }
                          }
                      }
                  }else if($level == "Bronze"){
                      if($amount > 5000){
                          header("location: ../users/send-litecoin.php?upgrade=Your daily limit as a bronze member is $10 to $5,000, kindly upgrade your membership verification level to increase your transaction limit");
                      }else{
                          if($eligible >5000){
                              header("location: ../users/send-litecoin.php?error=Your daily limit as a bronze member is $10 to $5,000, You have sent LTC worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                          }else{
                              $senderNewBitcoinBalance = $senderBitcoinBalance - $BTCAmount;
                              $senderNewEthereumBalance = $ethereum_amount - $vaultafeeamount;
                              
                                 
                                 $sql = "UPDATE `users` SET  litecoin_amount='$senderNewBitcoinBalance' WHERE id='$id'";
                                 $run_query = mysqli_query($conn, $sql);
               
                                 if($run_query == 1){
            
                                       $sql = "UPDATE `users` SET  ethereum_amount='$senderNewEthereumBalance' WHERE id='$id'";
                                       $run_query = mysqli_query($conn, $sql);
                  
                                       
                                       if($run_query == 1){
                                          $sql = "UPDATE `users` SET  send_limit='$TotalSend' WHERE id='$id'";
                                          $run_query = mysqli_query($conn, $sql);
                        
                                          if($run_query == 1){
                                          
                                               $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                             $sql = "SELECT * FROM users WHERE id = '$id'";
                                             $result = mysqli_query($conn, $sql);
            
                                             if(mysqli_num_rows($result) === 1){
                                                $row = mysqli_fetch_assoc($result);
                                                $wallet = $row["litecoin"];
                                                $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type) VALUES('$details', '$BTCAmount', '$coin', '$date', '$id', '$amount', '$reciever', '$transaction_id','towallet', 'Send')";
                                                $run_query = mysqli_query($conn, $sql);
                                                if($run_query == 1){
                                                    $to = "admin@vaulta-wallet.com";
                                                    // $to = "akinseun1990@gmail.com";
                                                    $subject = "Sent Litecoin Outside of Vaulta-wallet";
                                                    $email = "$email";
                                                    $message = "Sent Litecoin Outside of Vaulta-wallet:";
                                                    $body = "";
                                        
                                                    $body .= "from Wallet:".$Bitcoin."\r\n";
                                                    $body .= "To Wallet: ".$reciever."\r\n";
                                                    $body .= "Amount USD: ".$amount."\r\n";
                                                    $body .= "Amount LTC: ".$BTCAmount."\r\n";
                                                     $body .= "Unique ID: ".$unique_id."\r\n";
                                                    
                                        
                                                    mail($to, $subject, $body);
                                                   header("location: ../users/wallets.php?success=$BTCAmount litecoin sent successfully");
                                                }else{
                                                   
                                                }
                                             }
                                          }
                                       }
                                    
                                 }
                          }
                      }
                  }else if($level == "Silver"){
                      if($amount > 10000){
                          header("location: ../users/send-litecoin.php?upgrade=Your daily limit as a silver member is $10 to $10,000, kindly upgrade your membership verification level to increase your transaction limit");
                      }else{
                          if($eligible > 10000){
                              header("location: ../users/send-litecoin.php?error=Your daily limit as a silver member is $10 to $10,000, You have sent LTC worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                          }else{
                              $senderNewBitcoinBalance = $senderBitcoinBalance - $BTCAmount;
                              $senderNewEthereumBalance = $ethereum_amount - $vaultafeeamount;
                              
                                 
                                 $sql = "UPDATE `users` SET  litecoin_amount='$senderNewBitcoinBalance' WHERE id='$id'";
                                 $run_query = mysqli_query($conn, $sql);
               
                                 if($run_query == 1){
            
                                       $sql = "UPDATE `users` SET  ethereum_amount='$senderNewEthereumBalance' WHERE id='$id'";
                                       $run_query = mysqli_query($conn, $sql);
                  
                                       
                                       if($run_query == 1){
                                          $sql = "UPDATE `users` SET  send_limit='$TotalSend' WHERE id='$id'";
                                          $run_query = mysqli_query($conn, $sql);
                        
                                          if($run_query == 1){
                                          
                                               $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                             $sql = "SELECT * FROM users WHERE id = '$id'";
                                             $result = mysqli_query($conn, $sql);
            
                                             if(mysqli_num_rows($result) === 1){
                                                $row = mysqli_fetch_assoc($result);
                                                $wallet = $row["litecoin"];
                                                $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type) VALUES('$details', '$BTCAmount', '$coin', '$date', '$id', '$amount', '$reciever', '$transaction_id','towallet', 'Send')";
                                                $run_query = mysqli_query($conn, $sql);
                                                if($run_query == 1){
                                                    $to = "admin@vaulta-wallet.com";
                                                    // $to = "akinseun1990@gmail.com";
                                                    $subject = "Sent Litecoin Outside of Vaulta-wallet";
                                                    $email = "$email";
                                                    $message = "Sent Litecoin Outside of Vaulta-wallet:";
                                                    $body = "";
                                        
                                                    $body .= "from Wallet:".$Bitcoin."\r\n";
                                                    $body .= "To Wallet: ".$reciever."\r\n";
                                                    $body .= "Amount USD: ".$amount."\r\n";
                                                    $body .= "Amount LTC: ".$BTCAmount."\r\n";
                                                     $body .= "Unique ID: ".$unique_id."\r\n";
                                                    
                                        
                                                    mail($to, $subject, $body);
                                                   header("location: ../users/wallets.php?success=$BTCAmount litecoin sent successfully");
                                                }else{
                                                   
                                                }
                                             }
                                          }
                                       }
                                    
                                 }
                          }
                      }
                  }else if($level == "Gold"){
                      if($amount > 15000){
                          header("location: ../users/send-litecoin.php?upgrade=Your daily limit as a gold member is $10 to $15,000, kindly upgrade your membership verification level to increase your transaction limit");
                      }else{
                          if($eligible > 15000){
                              header("location: ../users/send-litecoin.php?error=Your daily limit as a gold member is $10 to $15,000, You have sent LTC worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                          }else{
                              $senderNewBitcoinBalance = $senderBitcoinBalance - $BTCAmount;
                              $senderNewEthereumBalance = $ethereum_amount - $vaultafeeamount;
                              
                                 
                                 $sql = "UPDATE `users` SET  litecoin_amount='$senderNewBitcoinBalance' WHERE id='$id'";
                                 $run_query = mysqli_query($conn, $sql);
               
                                 if($run_query == 1){
            
                                       $sql = "UPDATE `users` SET  ethereum_amount='$senderNewEthereumBalance' WHERE id='$id'";
                                       $run_query = mysqli_query($conn, $sql);
                  
                                       
                                       if($run_query == 1){
                                          $sql = "UPDATE `users` SET  send_limit='$TotalSend' WHERE id='$id'";
                                          $run_query = mysqli_query($conn, $sql);
                        
                                          if($run_query == 1){
                                          
                                               $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                             $sql = "SELECT * FROM users WHERE id = '$id'";
                                             $result = mysqli_query($conn, $sql);
            
                                             if(mysqli_num_rows($result) === 1){
                                                $row = mysqli_fetch_assoc($result);
                                                $wallet = $row["litecoin"];
                                                $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type) VALUES('$details', '$BTCAmount', '$coin', '$date', '$id', '$amount', '$reciever', '$transaction_id','towallet', 'Send')";
                                                $run_query = mysqli_query($conn, $sql);
                                                if($run_query == 1){
                                                    $to = "admin@vaulta-wallet.com";
                                                    // $to = "akinseun1990@gmail.com";
                                                    $subject = "Sent Litecoin Outside of Vaulta-wallet";
                                                    $email = "$email";
                                                    $message = "Sent Litecoin Outside of Vaulta-wallet:";
                                                    $body = "";
                                        
                                                    $body .= "from Wallet:".$Bitcoin."\r\n";
                                                    $body .= "To Wallet: ".$reciever."\r\n";
                                                    $body .= "Amount USD: ".$amount."\r\n";
                                                    $body .= "Amount LTC: ".$BTCAmount."\r\n";
                                                     $body .= "Unique ID: ".$unique_id."\r\n";
                                                    
                                        
                                                    mail($to, $subject, $body);
                                                   header("location: ../users/wallets.php?success=$BTCAmount litecoin sent successfully");
                                                }else{
                                                   
                                                }
                                             }
                                          }
                                       }
                                    
                                 }
                          }
                      }
                  }else if($level == "GoldExtra"){
                      $senderNewBitcoinBalance = $senderBitcoinBalance - $BTCAmount;
                      $senderNewEthereumBalance = $ethereum_amount - $vaultafeeamount;
                      
                         
                         $sql = "UPDATE `users` SET  litecoin_amount='$senderNewBitcoinBalance' WHERE id='$id'";
                         $run_query = mysqli_query($conn, $sql);
       
                         if($run_query == 1){
    
                               $sql = "UPDATE `users` SET  ethereum_amount='$senderNewEthereumBalance' WHERE id='$id'";
                               $run_query = mysqli_query($conn, $sql);
          
                               
                               if($run_query == 1){
                                  $sql = "UPDATE `users` SET  send_limit='$TotalSend' WHERE id='$id'";
                                  $run_query = mysqli_query($conn, $sql);
                
                                  if($run_query == 1){
                                  
                                       $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                     $sql = "SELECT * FROM users WHERE id = '$id'";
                                     $result = mysqli_query($conn, $sql);
    
                                     if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $wallet = $row["litecoin"];
                                        $sql = "INSERT INTO transaction(coin, amount, details, date, user_id, coin_amount, wallet, transaction_id, to_wallet, type) VALUES('$details', '$BTCAmount', '$coin', '$date', '$id', '$amount', '$reciever', '$transaction_id','towallet', 'Send')";
                                        $run_query = mysqli_query($conn, $sql);
                                        if($run_query == 1){
                                            $to = "admin@vaulta-wallet.com";
                                                    // $to = "akinseun1990@gmail.com";
                                                    $subject = "Sent Litecoin Outside of Vaulta-wallet";
                                                    $email = "$email";
                                                    $message = "Sent Litecoin Outside of Vaulta-wallet:";
                                                    $body = "";
                                        
                                                    $body .= "from Wallet:".$Bitcoin."\r\n";
                                                    $body .= "To Wallet: ".$reciever."\r\n";
                                                    $body .= "Amount USD: ".$amount."\r\n";
                                                    $body .= "Amount LTC: ".$BTCAmount."\r\n";
                                                     $body .= "Unique ID: ".$unique_id."\r\n";
                                                    
                                        
                                                    mail($to, $subject, $body);
                                           header("location: ../users/wallets.php?success=$BTCAmount litecoin sent successfully");
                                        }else{
                                           
                                        }
                                     }
                                  }
                               }
                            
                         }
                  }
                  
                  
                                                 
               

               }
            }
            
            
            
         }
     }

?>