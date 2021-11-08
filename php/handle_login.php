<?php
session_start();

    if(isset($_POST['login'])){

        $email = $_POST['signup-email'];
        $password = $_POST['signup-passkey'];
        
        $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['verify'] = $row['verification'];
           
            if($_SESSION['verify'] == 1){
                if(password_verify($password, $row['password'])){
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['phone'] = $row['phone'];
                    $_SESSION['D_O_B'] = $row['D_O_B'];
                    $_SESSION['country'] = $row['country'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['unique_id'] = $row['user_id'];
                    $_SESSION['bitcoin'] = $row['bitcoin'];
                    $_SESSION['profile-pics'] = $row['profile-pics'];
                    $_SESSION['ethereum'] = $row['ethereum'];
                    $_SESSION['last_login_stamp'] = time();
                    header("Location: ../users/index.php");
                    
                    
                }else{
                    $validation = "invalid";
                    header("Location: ../signup.html?error=Password is incorrect");
                    exit();
                }
            }else{
                $validation = "invalid";
                header("Location: ../signup.html?error=account is not active");
                exit();

            }   

        }else{
            $validation = "invalid";
            header("Location: ../signup.html?error=email is incorrect");
            exit();
        }



    }