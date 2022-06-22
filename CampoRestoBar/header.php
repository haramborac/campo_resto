<?php ob_start() ?>
<?php
    session_start();

    if(!isset($_SESSION['UNAME'])){
        header('location:Login.php');
        die();
    }
?>
<?php include 'Db.php';?>
<?php include 'Functions.php';?>
<script type="text/javascript" src="JS/inventory.js"></script>
<style>
    <?php include 'CSS/header.css';?>
</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <title>Campo</title>
</head>
<header>
    <div class="campoLogo">
        <a href="Dashboard.php"><img src="IMG/campoLogoBlack.png" alt=""></a>
    </div>
    <div class="campoNav">
        <ul>
            <li><a href="Dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
            <?php
                        $lowIngredients = "SELECT COUNT(ingQuantity) AS lowingredients FROM ingredients WHERE ingQuantity <= 10 ";
                        $lowIngredients_query = mysqli_query($connection, $lowIngredients);
                        if(mysqli_num_rows($lowIngredients_query)>0){
                            while($lowing = mysqli_fetch_assoc($lowIngredients_query)){
                                $low_ingredients = $lowing['lowingredients'];
                            }    
                                if($low_ingredients == 0){
                                    $warning = "none";
                                }else{
                                    $warning = "block";
                                }
                        }else{
                            $low_ingredients = 0;
                        }   
                    ?>
            <li><a href="Inventory.php"><div id="cWarning" style="display:<?php echo $warning?>"><p><?php echo $low_ingredients?></p></div><i class="fas fa-boxes"></i>Inventory</a></li>
            <li><a href="Cook.php"><i class="fas fa-utensils"></i>Cook</a></li>
            <li><a href="Cashier.php"><i class="fas fa-file-invoice-dollar"></i>Cashier</a></li>
            <li><a href="Settings.php"><i class="fas fa-cogs"></i></a></li>
            <a href="logout.php"><button>LOGOUT</button></a>
        </ul>
    </div>
</header>
</html>