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
            header("location: ../users/send-bitcoincash.php?error=Kindly input how much bitcoin cash you want to send"); 
        }else{
            if($selectBTCWallet == ''){
                header("location: ../users/send-bitcoincash.php?error=Kindly select the wallet your are sending Bch to");
            }else{

                 $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                $sql = "SELECT * FROM users WHERE id = '$id'";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) === 1){
                    $row = mysqli_fetch_assoc($result);
                    $level = $row['level'];
                    $send_limit = $row['send_limit'];
                    $senderBitcoinBalance = $row['bitcoin_cash_amount'];
                    $senderEthereumBalance = $row['ethereum_amount'];
                    $senderName = $row['first_name'];
                    $senderEmail = $row['email'];
                    $senderWalletAddress = $row['bitcoin_cash'];
                        
                    if($level == "Basic"){
                        if($amount < 10){
                            header("location: ../users/send-bitcoincash.php?error=The minimum amount you can send is $10");
                        }else{
                            if($selectBTCWallet == "vaulta-wallet"){
                                if($VaultaWalletReciever == ""){
                                    header("location: ../users/send-bitcoincash.php?error=Kindly enter reciever's wallet address");
                                }else{
                                     $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE bitcoin_cash=  '$VaultaWalletReciever'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $TodayDate = date("Y-m-d");
                                        $send_date = $row['send_date'];
                                        $receiverBitcoinBalance = $row['bitcoin_cash_amount'];
                                       
                                            if($senderWalletAddress == $VaultaWalletReciever){
                                                header("location: ../users/send-bitcoincash.php?error=You can't send bch to your bch wallet address");
                                            }else{
                                                if($BTCAmount > $senderBitcoinBalance){
                                                    header("location: ../users/send-bitcoincash.php?error=Insufficient Bitcoin Cash Balance Kindly buy more bitcoin cash to complete this transaction");
                                                }else{
                                                    $_SESSION['Amount'] = $amount;
                                                    $_SESSION['usd'] =  $BTCAmount;
                                                    $_SESSION['reciever'] =  $VaultaWalletReciever;
                                                    header("location: ../users/send-bitcoincash-confirmation.php");
                                                }
                                            }
                    
                                            
                                        
                                    }else{
                                        header("location: ../users/send-bitcoincash.php?error=BCH Wallet Address can't be found");
                                    }
                                }
                            }else if($selectBTCWallet == "outside"){
                                if($VaultaWalletOutside == ""){
                                    header("location: ../users/send-bitcoincash.php?error=Kindly enter reciever's wallet address");
                                }else{
                                     $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE id = '$id'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $send_limit = $row['send_limit'];
                                        $senderBitcoinBalance = $row['bitcoin_cash_amount'];
                                        $senderEthereumBalance = $row['ethereum_amount'];
                                        $senderName = $row['first_name'];
                                        $senderEmail = $row['email'];
                                        
                                        // if($send_limit >= 1000){
                                        //     header("location: ../users/send-bitcoincash.php?upgrade=Your daily limit as a basic member is $10 to $1,000, kindly upgrade your membership verification level to increase your transaction limit");
                                        // }else{
                                            
                    
                                            if($BTCAmount > $senderBitcoinBalance){
                                                header("location: ../users/send-bitcoincash.php?error=Insufficient Bitcoin Cash Balance Kindly buy more bitcoin cash to complete this transaction");
                                            }else{
                                                
                                                    // $eligable = $send_limit + $amount;
                                                    // if($eligable <= 1000){
                                                        $_SESSION['Amount'] = $amount;
                                                        $_SESSION['usd'] =  $BTCAmount;
                                                        $_SESSION['reciever'] =  $VaultaWalletOutside;
                                                        header("location: ../users/send-bitcoincash-confirmation.php");
                                                        
                                                    // }else{
                                                    //     header("location: ../users/send-bitcoincash.php?upgrade=Your daily limit as a basic member is $10 to $1,000, You have sent BCH worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                                                    // }
                                                
                                            }
                                        // }
                                    }
                                    
                                }
                            }
                        }
                    }else if($level == "Bronze"){
                        if($amount < 10){
                            header("location: ../users/send-bitcoincash.php?error=The minimum amount you can send is $10");
                        }else{
                            if($selectBTCWallet == "vaulta-wallet"){
                                if($VaultaWalletReciever == ""){
                                    header("location: ../users/send-bitcoincash.php?error=Kindly enter reciever's wallet address");
                                }else{
                                    $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE bitcoin_cash = '$VaultaWalletReciever'";
                                    $result = mysqli_query($conn, $sql);
                                    echo $VaultaWalletReciever;

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $TodayDate = date("Y-m-d");
                                        $send_date = $row['send_date'];
                                        $receiverBitcoinBalance = $row['bitcoin_cash_amount'];
                                       
                                            
                    
                                            if($senderWalletAddress == $VaultaWalletReciever){
                                                header("location: ../users/send-bitcoincash.php?error=You can't send bch to your bch wallet address");
                                            }else{
                                                if($BTCAmount > $senderBitcoinBalance){
                                                    header("location: ../users/send-bitcoincash.php?error=Insufficient Bitcoin Cash Balance Kindly buy more bitcoin cash to complete this transaction");
                                                }else{
                                                    $_SESSION['Amount'] = $amount;
                                                    $_SESSION['usd'] =  $BTCAmount;
                                                    $_SESSION['reciever'] =  $VaultaWalletReciever;
                                                    header("location: ../users/send-bitcoincash-confirmation.php");
                                                }
                                            }
                    
                                        
                                    }else{
                                        header("location: ../users/send-bitcoincash.php?error=BCH Wallet Address can't be found");
                                    }
                                }
                            }else if($selectBTCWallet == "outside"){
                                if($VaultaWalletOutside == ""){
                                    header("location: ../users/send-bitcoincash.php?error=Kindly enter reciever's wallet address");
                                }else{
                                     $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE id = '$id'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $send_limit = $row['send_limit'];
                                        $senderBitcoinBalance = $row['bitcoin_cash_amount'];
                                        $senderEthereumBalance = $row['ethereum_amount'];
                                        $senderName = $row['first_name'];
                                        $senderEmail = $row['email'];
                                        
                                        // if($send_limit >= 5000){
                                        //     header("location: ../users/send-bitcoincash.php?upgrade=Your daily limit as a bronze member is $10 to $5,000, kindly upgrade your membership verification level to increase your transaction limit");
                                        // }else{
                                            
                    
                                            if($BTCAmount > $senderBitcoinBalance){
                                                header("location: ../users/send-bitcoincash.php?error=Insufficient Bitcoin Cash Balance Kindly buy more bitcoin cash to complete this transaction");
                                            }else{
                                                
                                                    // $eligable = $send_limit + $amount;
                                                    // if($eligable <= 5000){
                                                        $_SESSION['Amount'] = $amount;
                                                        $_SESSION['usd'] =  $BTCAmount;
                                                        $_SESSION['reciever'] =  $VaultaWalletOutside;
                                                        header("location: ../users/send-bitcoincash-confirmation.php");
                                                        
                                                    // }else{
                                                    //     header("location: ../users/send-bitcoincash.php?upgrade=Your daily limit as a bronze member is $10 to $5,000, You have sent BCH worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                                                    // }
                                                
                                            }
                                        // }
                                    }
                                    
                                }
                            }
                        }
                    }else if($level == "Silver"){
                        if($amount < 10){
                            header("location: ../users/send-bitcoincash.php?error=The minimum amount you can send is $10");
                        }else{
                            if($selectBTCWallet == "vaulta-wallet"){
                                if($VaultaWalletReciever == ""){
                                    header("location: ../users/send-bitcoincash.php?error=Kindly enter reciever's wallet address");
                                }else{
                                   $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE bitcoin_cash = '$VaultaWalletReciever'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $TodayDate = date("Y-m-d");
                                        $send_date = $row['send_date'];
                                        $receiverBitcoinBalance = $row['bitcoin_cash_amount'];
                                       
                                            
                    
                                            if($senderWalletAddress == $VaultaWalletReciever){
                                                header("location: ../users/send-bitcoincash.php?error=You can't send bch to your bch wallet address");
                                            }else{
                                                if($BTCAmount > $senderBitcoinBalance){
                                                    header("location: ../users/send-bitcoincash.php?error=Insufficient Bitcoin Cash Balance Kindly buy more bitcoin cash to complete this transaction");
                                                }else{
                                                    $_SESSION['Amount'] = $amount;
                                                    $_SESSION['usd'] =  $BTCAmount;
                                                    $_SESSION['reciever'] =  $VaultaWalletReciever;
                                                    header("location: ../users/send-bitcoincash-confirmation.php");
                                                }
                                            }
                    
                                        
                                    }else{
                                        header("location: ../users/send-bitcoincash.php?error=BCH Wallet Address can't be found");
                                    }
                                }
                            }else if($selectBTCWallet == "outside"){
                                if($VaultaWalletOutside == ""){
                                    header("location: ../users/send-bitcoincash.php?error=Kindly enter reciever's wallet address");
                                }else{
                                    $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE id = '$id'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $send_limit = $row['send_limit'];
                                        $senderBitcoinBalance = $row['bitcoin_cash_amount'];
                                        $senderEthereumBalance = $row['ethereum_amount'];
                                        $senderName = $row['first_name'];
                                        $senderEmail = $row['email'];
                                        
                                        // if($send_limit >= 10000){
                                        //     header("location: ../users/send-bitcoincash.php?upgrade=Your daily limit as a silver member is $10 to $10,000, kindly upgrade your membership verification level to increase your transaction limit");
                                        // }else{
                                            
                    
                                            if($BTCAmount > $senderBitcoinBalance){
                                                header("location: ../users/send-bitcoincash.php?error=Insufficient Bitcoin Cash Balance Kindly buy more bitcoin cash to complete this transaction");
                                            }else{
                                                
                                                    // $eligable = $send_limit + $amount;
                                                    // if($eligable <= 5000){
                                                        $_SESSION['Amount'] = $amount;
                                                        $_SESSION['usd'] =  $BTCAmount;
                                                        $_SESSION['reciever'] =  $VaultaWalletOutside;
                                                        header("location: ../users/send-bitcoincash-confirmation.php");
                                                        
                                                    // }else{
                                                    //     header("location: ../users/send-bitcoincash.php?upgrade=Your daily limit as a silver member is $10 to $10,000, You have sent BCH worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                                                    // }
                                                
                                            }
                                        // }
                                    }
                                    
                                }
                            }
                        }
                    }else if($level == "Gold"){
                        if($amount < 10){
                            header("location: ../users/send-bitcoincash.php?error=The minimum amount you can send is $10");
                        }else{
                            if($selectBTCWallet == "vaulta-wallet"){
                                if($VaultaWalletReciever == ""){
                                    header("location: ../users/send-bitcoincash.php?error=Kindly enter reciever's wallet address");
                                }else{
                                    $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE bitcoin_cash = '$VaultaWalletReciever'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $TodayDate = date("Y-m-d");
                                        $send_date = $row['send_date'];
                                        $receiverBitcoinBalance = $row['bitcoin_cash_amount'];
                                       
                                            
                    
                                           if($senderWalletAddress == $VaultaWalletReciever){
                                                header("location: ../users/send-bitcoincash.php?error=You can't send bch to your bch wallet address");
                                            }else{
                                                if($BTCAmount > $senderBitcoinBalance){
                                                    header("location: ../users/send-bitcoincash.php?error=Insufficient Bitcoin Cash Balance Kindly buy more bitcoin cash to complete this transaction");
                                                }else{
                                                    $_SESSION['Amount'] = $amount;
                                                    $_SESSION['usd'] =  $BTCAmount;
                                                    $_SESSION['reciever'] =  $VaultaWalletReciever;
                                                    header("location: ../users/send-bitcoincash-confirmation.php");
                                                }
                                            }
                    
                                        
                                    }else{
                                        header("location: ../users/send-bitcoincash.php?error=BCH Wallet Address can't be found");
                                    }
                                }
                            }else if($selectBTCWallet == "outside"){
                                if($VaultaWalletOutside == ""){
                                    header("location: ../users/send-bitcoincash.php?error=Kindly enter reciever's wallet address");
                                }else{
                                   $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE id = '$id'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $send_limit = $row['send_limit'];
                                        $senderBitcoinBalance = $row['bitcoin_cash_amount'];
                                        $senderEthereumBalance = $row['ethereum_amount'];
                                        $senderName = $row['first_name'];
                                        $senderEmail = $row['email'];
                                        
                                        // if($send_limit >= 5000){
                                        //     header("location: ../users/send-bitcoincash.php?upgrade=Your daily limit as a gold member is $10 to $15,000, kindly upgrade your membership verification level to increase your transaction limit");
                                        // }else{
                                            
                    
                                            if($BTCAmount > $senderBitcoinBalance){
                                                header("location: ../users/send-bitcoincash.php?error=Insufficient Bitcoin Cash Balance Kindly buy more bitcoin cash to complete this transaction");
                                            }else{
                                                
                                                    // $eligable = $send_limit + $amount;
                                                    // if($eligable <= 15000){
                                                        $_SESSION['Amount'] = $amount;
                                                        $_SESSION['usd'] =  $BTCAmount;
                                                        $_SESSION['reciever'] =  $VaultaWalletOutside;
                                                        header("location: ../users/send-bitcoincash-confirmation.php");
                                                        
                                                    // }else{
                                                    //     header("location: ../users/send-bitcoincash.php?upgrade=Your daily limit as a gold member is $10 to $15,000, You have sent BCH worth of $$send_limit, kindly upgrade your membership verification level to increase your transaction limit"); 
                                                    // }
                                                
                                            }
                                        // }
                                    }
                                    
                                }
                            }
                        }
                    }else if($level == "GoldExtra"){
                        if($amount < 10){
                            header("location: ../users/send-bitcoincash.php?error=The minimum amount you can send is $10");
                        }else{
                            if($selectBTCWallet == "vaulta-wallet"){
                                if($VaultaWalletReciever == ""){
                                    header("location: ../users/send-bitcoincash.php?error=Kindly enter reciever's wallet address");
                                }else{
                                    $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE bitcoin_cash= '$VaultaWalletReciever'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $TodayDate = date("Y-m-d");
                                        $send_date = $row['send_date'];
                                        $receiverBitcoinBalance = $row['bitcoin_cash_amount'];
                                       
                                            
                    
                                           if($senderWalletAddress == $VaultaWalletReciever){
                                                header("location: ../users/send-bitcoincash.php?error=You can't send bch to your bch wallet address");
                                            }else{
                                                if($BTCAmount > $senderBitcoinBalance){
                                                    header("location: ../users/send-bitcoincash.php?error=Insufficient Bitcoin Cash Balance Kindly buy more bitcoin cash to complete this transaction");
                                                }else{
                                                    $_SESSION['Amount'] = $amount;
                                                    $_SESSION['usd'] =  $BTCAmount;
                                                    $_SESSION['reciever'] =  $VaultaWalletReciever;
                                                    header("location: ../users/send-bitcoincash-confirmation.php");
                                                }
                                            }
                    
                                        
                                    }else{
                                        header("location: ../users/send-bitcoincash.php?error=BCH Wallet Address can't be found");
                                    }
                                }
                            }else if($selectBTCWallet == "outside"){
                                if($VaultaWalletOutside == ""){
                                    header("location: ../users/send-bitcoincash.php?error=Kindly enter reciever's wallet address");
                                }else{
                                    $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
                                    $sql = "SELECT * FROM users WHERE id = '$id'";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) === 1){
                                        $row = mysqli_fetch_assoc($result);
                                        $send_limit = $row['send_limit'];
                                        $senderBitcoinBalance = $row['bitcoin_cash_amount'];
                                        $senderEthereumBalance = $row['ethereum_amount'];
                                        $senderName = $row['first_name'];
                                        $senderEmail = $row['email'];
                                        
                                       
                                            
                    
                                            if($BTCAmount > $senderBitcoinBalance){
                                                header("location: ../users/send-bitcoincash.php?error=Insufficient Bitcoin Cash Balance Kindly buy more bitcoin cash to complete this transaction");
                                            }else{
                                                
                                                $_SESSION['Amount'] = $amount;
                                                $_SESSION['usd'] =  $BTCAmount;
                                                $_SESSION['reciever'] =  $VaultaWalletOutside;
                                                header("location: ../users/send-bitcoincash-confirmation.php");
                                                
                                                    
                                                
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