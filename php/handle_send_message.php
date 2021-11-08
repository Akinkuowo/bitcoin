<?php


    if(isset($_POST['add-account'])){

        $Name = $_POST['account-name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        
        

        if($Name == "" || $email == "" || $subject == "" || $message == ""){
             header("Location: ../users/send-message.php?error=Kindly fill all form");
            // echo $Name;
            // echo $email;
            // echo $subject;
            // echo $message;
        }else{
            // allow for demo mode testing of emails
                define("DEMO", false); // setting to TRUE will stop the email from sending.

                // set the location of the template file to be loaded
                $template_file = "../email_templates/send_message.php";
                    // $template_file = "$message";
                // set the email 'from' information
                $email_from = "Vaulta Wallet <info@vaulta-wallet.com>";

                // create a list of the variables to be swapped in the html template
                $swap_var = array(
                    "{SITE_ADDR}" => "https://vaulta-wallet.com",
                    "{EMAIL_LOGO}" => "https://vaulta-wallet.com/images/logo2.png",
                    "{EMAIL_TITLE}" => "$subject",
                    "{TO_NAME}" => "$Name",
                    "{MESSAGE_CONTENT}" => "$message",
                    "{TO_EMAIL}" => "$email"
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
                      header("Location: ../users/send-message.php?success=message sent");      
                }
                else{
                    echo '<hr /><center> UNSUCCESSFUL... Your email was <b>NOT</b> sent. </center>';
                }
        }
    }

   


?>