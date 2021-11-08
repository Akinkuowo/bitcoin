<?php
session_start();

    if(isset($_POST['login'])){

        $email = $_POST['signup-email'];
        $password = $_POST['signup-passkey'];
        
        $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

        $sql = "SELECT * FROM admin WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
           
                if(password_verify($password, $row['password'])){
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['last_login_stamp'] = time();
                    header("Location: ../admin/dashboard.php");
                }else{
                    header("Location: ../admin/index.php?error=Password is incorrect");
                    exit();
                }
           

        }else{
            
            header("Location: ../admin/index.php?error=email is incorrect");
            exit();
        }



    }