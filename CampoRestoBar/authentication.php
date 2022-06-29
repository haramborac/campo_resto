<?php 
    session_start();
    include 'Db.php';

    if(isset($_POST['login'])){
        $username = mysqli_real_escape_string($connection,$_POST['pUsername']);
        $password = mysqli_real_escape_string($connection,$_POST['pPassword']);
        if(!empty($username) || !empty($password)) {
            $result = mysqli_query($connection, "SELECT * FROM employee_login where username = '$username'");
            if(mysqli_num_rows($result)>0) {
                $row       = mysqli_fetch_assoc($result);
                $verify = $row['password'];
                // $verify    = password_verify($password,$row['password']); // cant hash yet
                if($verify==$password){
                    echo $_SESSION['IS_LOGIN']=true;
                    $_SESSION['UNAME']=$row['username'];
                    header("location:Dashboard.php");
                }
                else{
                    echo 'invalid account';
                    header ("location:login.php?login=incorrectpassword");
                    exit ();
                }
            }else{
                header ("location:login.php");
            }
        }else{
            header ("location:login.php");
            exit ();
        }
        
    }
?>