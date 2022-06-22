<?php 
    session_start();

    include 'Db.php';
    
    unset($_SESSION['IS_LOGIN']);
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 48000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Finally, destroy the session.
    session_destroy();
    header('location:login.php');
    exit();
?>