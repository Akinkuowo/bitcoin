<?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $BTCAmount = $_POST['BtcAmount'];
       $VaultaWalletReciever = $_POST['VaultaWalletBTC'];
       $VaultaWalletOutside = $_POST['OutsideVaultaWalletBTC'];
       $id = $_SESSION['id'];
       $fee = $_POST['feeamount'];
       $vaultfee = $_POST['vaultafeeamount'];
       $selectBTCWallet = $_POST['BTCAddress'];
       $id = $_SESSION['id'];

       if($BTCAmount == ""){
            header("location: ../users/send-bitcoin.php?error=Kindly input how much bitcoin you want to send"); 
        }else{
            if($selectBTCWallet == ''){
                header("location: ../users/send-bitcoin.php?error=Kindly select the wallet your are sending Btc to");
            }else{

               $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                $sql = "SELECT * FROM users WHERE id = '$id'";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) === 1){
                    $row = mysqli_fetch_assoc($result);
                    $level = $row['level'];
                    $send_limit = $row['send_limit'];
                    $senderBitcoinBalance = $row['bitcoin_amount'];
                    $senderEthereumBalance = $row['ethereum_amount'];
                    $senderName = $row['first_name'];
                    $senderEmail = $row['email'];
                    $senderWalletAddress = $row['bitcoin'];

                        
                    if($level == "Basic"){
                        if($amount < 10){
                            header("location: ../users/send-bitcoin.php?error=The minimum amount you can send is $10");
                        }else{
                            if($selectBTCWallet == "vaulta-wallet"){
                                if($VaultaWalletReciever == ""){
                                    header("location: ../users/send-bitcoin.php?error=Kindly enter reciever's wallet address");
                                }else{
                                    $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE bitcoin = '$VaultaWalletReciever'";
                                    $result = mysqli_query($conn, $sql);
                                    

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $TodayDate = date("Y-m-d");
                                        $send_date = $row['send_date'];
                                        $receiverBitcoinBalance = $row['bitcoin_amount'];
                                        
                                        if($senderWalletAddress  == $VaultaWalletReciever){
                                            header("location: ../users/send-bitcoin.php?error=You can't send BTC to your BTC wallet address");
                                        }else{
                                            if($BTCAmount > $senderBitcoinBalance){
                                                header("location: ../users/send-bitcoin.php?error=Insufficient Bitcoin Balance Kindly buy more bitcoin to complete this transaction");
                                            }else{
                                                $_SESSION['Amount'] = $amount;
                                                $_SESSION['usd'] =  $BTCAmount;
                                                $_SESSION['reciever'] =  $VaultaWalletReciever;
                                                header("location: ../users/send-bitcoin-confirmation.php");
                                            }
                                        }
                                            
                    
                                            
                                        
                                    }else{
                                        header("location: ../users/send-bitcoin.php?error=BTC Wallet Address can't be found");
                                    }
                                }
                            }else if($selectBTCWallet == "outside"){
                                if($VaultaWalletOutside == ""){
                                    header("location: ../users/send-bitcoin.php?error=Kindly enter reciever's wallet address");
                                }else{
                                    $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE id = '$id'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $send_limit = $row['send_limit'];
                                        $senderBitcoinBalance = $row['bitcoin_amount'];
                                        $senderEthereumBalance = $row['ethereum_amount'];
                                        $senderName = $row['first_name'];
                                        $senderEmail = $row['email'];
                                        
                                        // if($send_limit >= 1000){
                                        //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a basic member is $10 to $1000, kindly upgrade your membership verification level to increase your transaction limit");
                                        // }else{
                                            
                    
                                            if($BTCAmount > $senderBitcoinBalance){
                                                header("location: ../users/send-bitcoin.php?error=Insufficient Bitcoin Balance Kindly buy more bitcoin to complete this transaction");
                                            }else{
                                                
                                                    // $eligable = $send_limit + $amount;
                                                    // if($eligable <= 1000){
                                                        $_SESSION['Amount'] = $amount;
                                                        $_SESSION['usd'] =  $BTCAmount;
                                                        $_SESSION['reciever'] =  $VaultaWalletOutside;
                                                        header("location: ../users/send-bitcoin-confirmation.php");
                                                        
                                                    // }else{
                                                    //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a basic member is $10 to $1000, You have sent BTC worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                                                    // }
                                                
                                            }
                                        // }
                                    }
                                    
                                }
                            }
                        }
                    }else if($level == "Bronze"){
                        if($amount < 10){
                            header("location: ../users/send-bitcoin.php?error=The minimum amount you can send is $10");
                        }else{
                            // if($amount > 5000 && $selectBTCWallet == "outside"){
                            //     header("location: ../users/send-bitcoin.php?error=Your limit as a Bronze member is $10 to $5000, kindly upgrade your membership verification level to increase your transaction limit");
                            // }else{
                                // if($send_limit >= 5000 && $selectBTCWallet == "outside"){
                                //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a Bronze member is $10 to $5000, kindly upgrade your membership verification level to increase your transaction limit");
                                // }else{
                                    if($selectBTCWallet == "vaulta-wallet"){
                                        if($VaultaWalletReciever == ""){
                                            header("location: ../users/send-bitcoin.php?error=Kindly enter reciever's wallet address");
                                        }else{
                                           $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                            $sql = "SELECT * FROM users WHERE bitcoin = '$VaultaWalletReciever'";
                                            $result = mysqli_query($conn, $sql);
                                            // echo $VaultaWalletReciever;
        
                                            if(mysqli_num_rows($result) === 1){
                                                $row = mysqli_fetch_assoc($result);
                                                $TodayDate = date("Y-m-d");
                                                $send_date = $row['send_date'];
                                                 $receiverBitcoinBalance = $row['bitcoin_amount'];
                                                $receiverEthereumBalance = $row['ethereum_amount'];
                                                $senderName = $row['first_name'];
                                                $senderEmail = $row['email'];
                                                    
                            
                                                  if($senderWalletAddress  == $VaultaWalletReciever){
                                                        header("location: ../users/send-bitcoin.php?error=You can't send btc to your btc wallet address");
                                                    }else{
                                                        if($BTCAmount > $senderBitcoinBalance){
                                                            header("location: ../users/send-bitcoin.php?error=Insufficient Bitcoin Balance Kindly buy more bitcoin to complete this transaction");
                                                        }else{
                                                            $_SESSION['Amount'] = $amount;
                                                            $_SESSION['usd'] =  $BTCAmount;
                                                            $_SESSION['reciever'] =  $VaultaWalletReciever;
                                                            header("location: ../users/send-bitcoin-confirmation.php");
                                                        }
                                                    }
                                                
                                            }else{
                                                header("location: ../users/send-bitcoin.php?error=BTC Wallet Address can't be found");
                                            }
                                        }
                                    }else if($selectBTCWallet == "outside"){
                                        if($VaultaWalletOutside == ""){
                                            header("location: ../users/send-bitcoin.php?error=Kindly enter reciever's wallet address");
                                        }else{
                                           $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                            $sql = "SELECT * FROM users WHERE id = '$id'";
                                            $result = mysqli_query($conn, $sql);

                                            if(mysqli_num_rows($result) === 1){
                                                $row = mysqli_fetch_assoc($result);
                                                $send_limit = $row['send_limit'];
                                                $senderBitcoinBalance = $row['bitcoin_amount'];
                                                $senderEthereumBalance = $row['ethereum_amount'];
                                                $senderName = $row['first_name'];
                                                $senderEmail = $row['email'];
                                                
                                                // if($send_limit >= 5000){
                                                //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a bronze member is $10 to $5000, kindly upgrade your membership verification level to increase your transaction limit");
                                                // }else{
                                                    
                            
                                                    if($BTCAmount > $senderBitcoinBalance){
                                                        header("location: ../users/send-bitcoin.php?error=Insufficient Bitcoin Balance Kindly buy more bitcoin to complete this transaction");
                                                    }else{
                                                        
                                                            // $eligable = $send_limit + $amount;
                                                            // if($eligable < 5000){
                                                                
                                                                $_SESSION['Amount'] = $amount;
                                                        $_SESSION['usd'] =  $BTCAmount;
                                                        $_SESSION['reciever'] =  $VaultaWalletOutside;
                                                        header("location: ../users/send-bitcoin-confirmation.php");
                                                                
                                                            // }else{
                                                            //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a bronze member is $10 to $5000, You have sent BTC worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                                                            // }
                                                        
                                                    }
                                                // }
                                            }
                                            
                                        }
                                    }
                                // }
                            // }
                        }
                    }else if($level == "Silver"){
                        if($amount < 10){
                            header("location: ../users/send-bitcoin.php?error=The minimum amount you can send is $10");
                        }else{
                            // if($amount > 10000){
                            //     header("location: ../users/send-bitcoin.php?error=Your limit as a silver member is $10 to $10000, kindly upgrade your membership verification level to increase your transaction limit");
                            // }else{
                                // if($send_limit >= 10000){
                                //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a Bronze member is $10 to $10000, kindly upgrade your membership verification level to increase your transaction limit");
                                // }else{
                                    if($selectBTCWallet == "vaulta-wallet"){
                                        if($VaultaWalletReciever == ""){
                                            header("location: ../users/send-bitcoin.php?error=Kindly enter reciever's wallet address");
                                        }else{
                                            $VaultaWalletReciever;
                                            $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                            $sql = "SELECT * FROM users WHERE bitcoin = '$VaultaWalletReciever'";
                                            $result = mysqli_query($conn, $sql);

                                            if(mysqli_num_rows($result) === 1){
                                                $row = mysqli_fetch_assoc($result);
                                                $TodayDate = date("Y-m-d");
                                                $send_date = $row['send_date'];
                                                 $receiverBitcoinBalance = $row['bitcoin_amount'];
                                                $receiverEthereumBalance = $row['ethereum_amount'];
                                                $senderName = $row['first_name'];
                                                $senderEmail = $row['email'];
                                                
                                                // if($send_limit >= 10000){
                                                //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a silver member is $10 to $10000, kindly upgrade your membership verification level to increase your transaction limit");
                                                // }else{
                                                    
                            
                                                    if($senderWalletAddress  == $VaultaWalletReciever){
                                                        header("location: ../users/send-bitcoin.php?error=You can't send btc to your btc wallet address");
                                                    }else{
                                                        if($BTCAmount > $senderBitcoinBalance){
                                                            header("location: ../users/send-bitcoin.php?error=Insufficient Bitcoin Balance Kindly buy more bitcoin to complete this transaction");
                                                        }else{
                                                            $_SESSION['Amount'] = $amount;
                                                            $_SESSION['usd'] =  $BTCAmount;
                                                            $_SESSION['reciever'] =  $VaultaWalletReciever;
                                                            header("location: ../users/send-bitcoin-confirmation.php");
                                                        }
                                                    }
                                                // }
                                            }else{
                                                header("location: ../users/send-bitcoin.php?error=BTC Wallet Address can't be found");
                                            }
                                        }
                                    }else if($selectBTCWallet == "outside"){
                                        if($VaultaWalletOutside == ""){
                                            header("location: ../users/send-bitcoin.php?error=Kindly enter reciever's wallet address");
                                        }else{
                                            $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                            $sql = "SELECT * FROM users WHERE id = '$id'";
                                            $result = mysqli_query($conn, $sql);

                                            if(mysqli_num_rows($result) === 1){
                                                $row = mysqli_fetch_assoc($result);
                                                $send_limit = $row['send_limit'];
                                                $senderBitcoinBalance = $row['bitcoin_amount'];
                                                $senderEthereumBalance = $row['ethereum_amount'];
                                                $senderName = $row['first_name'];
                                                $senderEmail = $row['email'];
                                                
                                                // if($send_limit >= 10000){
                                                //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a silver member is $10 to $10000, kindly upgrade your membership verification level to increase your transaction limit");
                                                // }else{
                                                    
                            
                                                    if($BTCAmount > $senderBitcoinBalance){
                                                        header("location: ../users/send-bitcoin.php?error=Insufficient Bitcoin Balance Kindly buy more bitcoin to complete this transaction");
                                                    }else{
                                                        
                                                            // $eligable = $send_limit + $amount;
                                                            // if($eligable < 10000){
                                                                $_SESSION['Amount'] = $amount;
                                                        $_SESSION['usd'] =  $BTCAmount;
                                                        $_SESSION['reciever'] =  $VaultaWalletOutside;
                                                        header("location: ../users/send-bitcoin-confirmation.php");
                                                                
                                                            // }else{
                                                            //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a basic member is $10 to $1000, You have sent BTC worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                                                            // }
                                                        
                                                    }
                                                // }
                                            }
                                            
                                        }
                                    }
                                // }
                            // }
                        }
                    }else if($level == "Gold"){
                        if($amount < 10){
                            header("location: ../users/send-bitcoin.php?error=The minimum amount you can send is $10");
                        }else{
                            // if($amount > 15000){
                            //     header("location: ../users/send-bitcoin.php?error=Your limit as a gold member is $10 to $15000, kindly upgrade your membership verification level to increase your transaction limit");
                            // }else{
                                // if($send_limit >= 15000){
                                //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a gold member is $10 to $15000, kindly upgrade your membership verification level to increase your transaction limit");
                                // }else{
                                    if($selectBTCWallet == "vaulta-wallet"){
                                        if($VaultaWalletReciever == ""){
                                            header("location: ../users/send-bitcoin.php?error=Kindly enter reciever's wallet address");
                                        }else{
                                            $VaultaWalletReciever;
                                           $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                            $sql = "SELECT * FROM users WHERE bitcoin = '$VaultaWalletReciever'";
                                            $result = mysqli_query($conn, $sql);

                                            if(mysqli_num_rows($result) === 1){
                                                $row = mysqli_fetch_assoc($result);
                                                $TodayDate = date("Y-m-d");
                                                $send_date = $row['send_date'];
                                                $receiverBitcoinBalance = $row['bitcoin_amount'];
                                                $recieverEthereumBalance = $row['ethereum_amount'];
                                                $senderName = $row['first_name'];
                                                $senderEmail = $row['email'];
                                                
                                                // if($send_limit >= 15000){
                                                //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a gold member is $10 to $15000, kindly upgrade your membership verification level to increase your transaction limit");
                                                // }else{
                                                    
                            
                                                    if($BTCAmount > $senderBitcoinBalance){
                                                        header("location: ../users/send-bitcoin.php?error=Insufficient Bitcoin Balance Kindly buy more bitcoin to complete this transaction");
                                                    }else{
                                                        
                                                            $_SESSION['Amount'] = $amount;
                                                            $_SESSION['usd'] =  $BTCAmount;
                                                            $_SESSION['reciever'] =  $VaultaWalletReciever;
                                                            header("location: ../users/send-bitcoin-confirmation.php");
                                                            

                                                        
                                                    }
                                                // }
                                            }else{
                                                header("location: ../users/send-bitcoin.php?error=BTC Wallet Address can't be found");
                                            }
                                        }
                                    }else if($selectBTCWallet == "outside"){
                                        if($VaultaWalletOutside == ""){
                                            header("location: ../users/send-bitcoin.php?error=Kindly enter reciever's wallet address");
                                        }else{
                                           $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                            $sql = "SELECT * FROM users WHERE id = '$id'";
                                            $result = mysqli_query($conn, $sql);

                                            if(mysqli_num_rows($result) === 1){
                                                $row = mysqli_fetch_assoc($result);
                                                $send_limit = $row['send_limit'];
                                                $senderBitcoinBalance = $row['bitcoin_amount'];
                                                $senderEthereumBalance = $row['ethereum_amount'];
                                                $senderName = $row['first_name'];
                                                $senderEmail = $row['email'];
                                                
                                                // if($send_limit >= 15000){
                                                //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a gold member is $10 to $15000, kindly upgrade your membership verification level to increase your transaction limit");
                                                // }else{
                                                    
                            
                                                    if($BTCAmount > $senderBitcoinBalance){
                                                        header("location: ../users/send-bitcoin.php?error=Insufficient Bitcoin Balance Kindly buy more bitcoin to complete this transaction");
                                                    }else{
                                                        
                                                        // $eligable = $send_limit + $amount;
                                                        // if($eligable < 15000){
                                                             $_SESSION['Amount'] = $amount;
                                                        $_SESSION['usd'] =  $BTCAmount;
                                                        $_SESSION['reciever'] =  $VaultaWalletOutside;
                                                        header("location: ../users/send-bitcoin-confirmation.php");
                                                            
                                                        // }else{
                                                        //     header("location: ../users/send-bitcoin.php?upgrade=Your daily limit as a gold member is $10 to $15000, You have sent BTC worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                                                        // }
                                                    }
                                                // }
                                            }
                                            
                                        }
                                    }
                                // }
                            // }
                        }
                    }else if($level == "GoldExtra"){
                        if($amount < 10){
                            header("location: ../users/send-bitcoin.php?error=The minimum amount you can send is $10");
                        }else{
                           
                            if($selectBTCWallet == "vaulta-wallet"){
                                if($VaultaWalletReciever == ""){
                                    header("location: ../users/send-bitcoin.php?error=Kindly enter reciever's wallet address");
                                }else{
                                    
                                    $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE bitcoin = '$VaultaWalletReciever'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $TodayDate = date("Y-m-d");
                                        $send_date = $row['send_date'];
                                         $receiverBitcoinBalance = $row['bitcoin_amount'];
                                        $receiverEthereumBalance = $row['ethereum_amount'];
                                        $senderName = $row['first_name'];
                                        $senderEmail = $row['email'];                
                            
                                        if($senderWalletAddress  == $VaultaWalletReciever){
                                            header("location: ../users/send-bitcoin.php?error=You can't send btc to your btc wallet address");
                                        }else{
                                            if($BTCAmount > $senderBitcoinBalance){
                                                header("location: ../users/send-bitcoin.php?error=Insufficient Bitcoin Balance Kindly buy more bitcoin to complete this transaction");
                                            }else{
                                                $_SESSION['Amount'] = $amount;
                                                $_SESSION['usd'] =  $BTCAmount;
                                                $_SESSION['reciever'] =  $VaultaWalletReciever;
                                                header("location: ../users/send-bitcoin-confirmation.php");
                                            }
                                        }
                                    }else{
                                        header("location: ../users/send-bitcoin.php?error=BTC Wallet Address can't be found");
                                    }
                                }
                                
                            }else if($selectBTCWallet == "outside"){
                                if($VaultaWalletOutside == ""){
                                    header("location: ../users/send-bitcoin.php?error=Kindly enter reciever's wallet address");
                                }else{
                                    $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE id = '$id'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $send_limit = $row['send_limit'];
                                        $senderBitcoinBalance = $row['bitcoin_amount'];
                                        $senderEthereumBalance = $row['ethereum_amount'];
                                        $senderName = $row['first_name'];
                                        $senderEmail = $row['email'];
                                            
                    
                                            if($BTCAmount > $senderBitcoinBalance){
                                                header("location: ../users/send-bitcoin.php?error=Insufficient Bitcoin Balance Kindly buy more bitcoin to complete this transaction");
                                            }else{
                                                  $_SESSION['Amount'] = $amount;
                                                        $_SESSION['usd'] =  $BTCAmount;
                                                        $_SESSION['reciever'] =  $VaultaWalletOutside;
                                                        header("location: ../users/send-bitcoin-confirmation.php");
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

      echo "no";
   }

?>
 <script>
        var BTCType = <?= $selectBTCWallet ?>;
       

        localStorage.setItem( 'BtcType', BTCType);
       
       
    </script>