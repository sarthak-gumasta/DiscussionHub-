<?php
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dvconnect.php';
    $user_name = $_POST['username'];
    $user_email = $_POST['email'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];

    $existSql = "SELECT * from `user` WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);
    if($numRows > 0){
        $showError = "This email is already exist.";
    }else{ 
       if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `user` (`user_name`, `user_email`, `user_pass`, `timestamp`) VALUES ('$user_name', '$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if($result){
                $showAlert = true;
                header("location: /forum/index.php?signupsuccess=true");
                exit();
            }
            
        }else{
            $showError = "Password do not match.";
        }
    }
    header("location: /forum/index.php?signupsuccess=false&error = $showError");

}
?>