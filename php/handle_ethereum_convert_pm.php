 
 <?php
session_start();
   if(isset($_POST['payment'])){
       $amount = $_POST['amount'];
       $id = $_SESSION['id'];
       $_SESSION['amount'] = $amount;
       $price = $_POST['price'];
       $current = $_POST['current'];
       $_SESSION['price'] = $price;
        $_SESSION['current'] = $current;
        
        $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');

      $id = $_SESSION['id'];
         
      $sql = "SELECT * FROM users WHERE id = '$id'";
      $result = mysqli_query($conn, $sql);
 

       if($amount == ""){
            header("location: ../users/convert-ethereum-to-bank.php?error=Kindly input how much ethereum you want to convert"); 
        }else{
             $conn = mysqli_connect('localhost', 'rockdnur_user', 'Mother@1990', 'rockdnur_db');
            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $BTCAmount = $row['ethereum_amount'];

                if($amount > $BTCAmount){
                    header("location: ../users/convert-ethereum-to-bank.php?error=Sorry, the amount you want to convert is greater than your Eth wallet balance"); 
                }else{
                    header("location: ../users/select-pm-eth-account.php"); 
                }

             
            }      
        }
      
   }else{

      echo "no";
   }

?>