<?php
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dvconnect.php';
    $user_email = $_POST['email'];
    $pass = $_POST['password'];
    $sql = "SELECT * FROM `user` WHERE `user_email` LIKE '$user_email'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_query($conn, $sql);
    $numRow = mysqli_num_rows($result);
    if($numRow == 1){
        $row = mysqli_fetch_assoc($result);
            if(password_verify($pass, $row['user_pass'])){
                $getinfo = "select user_name from `user` where `user_email` ='$user_email' ";
// $query = mysqli_query($conn, $getinfo );
// $row = mysqli_fetch_array($query);
// $user_name = $row['user_name'];
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['useremail'] = $user_email;
                $_SESSION['sno'] = $row['sno'];
                // $_SESSION['username'] = $user_name;
                $_SESSION['username'] = $row['user_name'];
                header("location: /forum/index.php");
            }else{
                $showError="Unable to login";
            }

    }
}