<?php

session_start();
    if(isset($_POST['add-account'])){

        $accountName = $_POST['account-name'];
        $accountNumber = $_POST['account-number'];
        $bankName = $_POST['bank-name'];
        $id = $_SESSION['id'];

        $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

        $sql = "INSERT INTO bank_details(account_name, account_number, bank_name, user_id) VALUES('$accountName', '$accountNumber', '$bankName', '$id')";

        $run_query = mysqli_query($conn, $sql);
        if($run_query == 1){
            header("Location: ../users/bank-account.php?success=Account Details Added Successfully");
               
        }
    
             
    }

   


?>