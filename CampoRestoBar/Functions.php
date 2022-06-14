<?php 
    include "Db.php";
    
    //add new stock in inventory.php
    function addStock(){
        global $connection;
        if(isset($_POST['addIngredients'])){
            $ing_name = mysqli_real_escape_string($connection, $_POST['ingNameNew']);
            $ing_quantity = mysqli_real_escape_string($connection, $_POST['ingNewQuan']);
            $ing_unit = mysqli_real_escape_string($connection, $_POST['ingNewVolume']);
            $ing_price = mysqli_real_escape_string($connection, $_POST['ingPrice']);
            
            if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$ing_name'"))>0){
                echo "<p style='color: red; font-style: italic;'>Ingredient Already Exists</p>";
            }else{
                $addIngredient = "INSERT INTO ingredients 
                (ingName, ingQuantity, ingUnit, ingCost, ingCostperUnit, ingListed, ingUpdated) 
                VALUES ('$ing_name', $ing_quantity, '$ing_unit', $ing_price, $ing_price/$ing_quantity, now(), now() ) ";
                $adding_query = mysqli_query($connection, $addIngredient);
                header('location:Inventory.php');

                $inventoryhistory = "INSERT INTO inventory_history (ingredient, quantity, cost, date) 
                VALUES ('$ing_name', '$ing_quantity $ing_unit', $ing_price, now() )";
                $invhistory_query = mysqli_query($connection, $inventoryhistory);
                header('location:Inventory.php');
            } 
        }
    }

    //restock ingredients in inventory.php
    function Restock(){
        global $connection;
        if(isset($_POST['restockIngredients'])){
            $restockIng_name = mysqli_real_escape_string($connection, $_POST['restockIngredientName']);
            $restockIng_quantity = mysqli_real_escape_string($connection, $_POST['resVol']);
            $restockIng_price = mysqli_real_escape_string($connection, $_POST['resPrice']);
            
            $z = mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$restockIng_name'");

            if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$restockIng_name'"))>0){
                while($asd = mysqli_fetch_assoc($z)){
                    $rstckUnit = $asd['ingUnit'];
                    
                    $restockIng = "UPDATE ingredients SET 
                    ingQuantity = ingQuantity+$restockIng_quantity,
                    ingCost = ingCost+$restockIng_price,
                    ingCostperUnit = ((ingCost+$restockIng_price)/(ingQuantity+$restockIng_quantity))+ingCostperUnit,
                    ingUpdated = now() 
                    WHERE ingName = '$restockIng_name' ";
                    $restockIng_query = mysqli_query($connection, $restockIng);

                    $inventoryhistory = "INSERT INTO inventory_history (ingredient, quantity, cost, date) 
                    VALUES ('$restockIng_name', '$restockIng_quantity $rstckUnit', $restockIng_price, now() )";
                    $invhistory_query = mysqli_query($connection, $inventoryhistory);
                    header('location:Inventory.php');
                }
            }else{
                echo "<p style='color: red; font-style: italic;'>Ingredient doesn't exist</p>";
            }
        }
    }

    //add ingredient in cook.php
    function addIngredient(){
        global $connection;
        if(isset($_POST['addIngredient'])){
            $ingredient = mysqli_real_escape_string($connection, $_POST['ingredient']);
            $quantity =  mysqli_real_escape_string($connection, $_POST['quantity']);
            if(empty($ingredient) || empty($quantity)){
                echo "missing input";
            }else{
                if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM ingredients_used WHERE ingredient_used = '$ingredient'"))>0){
                    echo "<p style='color: red; font-style: italic;'>Ingredient Already Added</p>";
                }elseif(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM ingredients"))<0){
                    echo "<p style='color: red; font-style: italic;'>ingredient does not exist</p>";
                }else{
                    $asd = "UPDATE ingredients SET ingQuantity = ingQuantity-$quantity WHERE ingName = '$ingredient' ";
                    mysqli_query($connection, $asd);
                    $zxc = "INSERT INTO ingredients_used (ingredient_used, quantity) VALUES ('$ingredient', $quantity) ";
                    mysqli_query($connection, $zxc);
                    header('location:zxc.php'); 
                } 
            }
                 
        }
    }

    //add 1 in cook.php
    if(isset($_GET['add'])){
        $name = $_GET['add'];

        $mm = "SELECT * FROM ingredients";
        $res1 = mysqli_query($connection, $mm);
        while($rowrow = mysqli_fetch_assoc($res1)){
            if($rowrow['ingQuantity'] == 0 ){
                echo "no more stock";
                header('location:Cook.php');
                exit();
            }else{
                echo "else";
                $addIng = "UPDATE ingredients_used SET quantity = quantity+1 where ingredient_used = '$name'";
                mysqli_query($connection, $addIng);

                $deducStock = "UPDATE ingredients SET ingQuantity = ingQuantity-1 where ingName = '$name'";
                mysqli_query($connection, $deducStock);
                header('location:Cook.php');
                exit();
            }
        }
    }

    //subtract 1 in cook.php
    if(isset($_GET['subtract'])){
        $name = $_GET['subtract'];
        $deducIng = "UPDATE ingredients_used SET quantity = quantity-1 where ingredient_used = '$name'";
        mysqli_query($connection, $deducIng);

        $addStock = "UPDATE ingredients SET ingQuantity = ingQuantity+1 where ingName = '$name'";
        mysqli_query($connection, $addStock);
        header('location:Cook.php');

        //check if ingredient_used is empty
        $mm = "SELECT * FROM ingredients_used";
        $res1 = mysqli_query($connection, $mm);
        while($rowrow = mysqli_fetch_assoc($res1)){
            if($rowrow['quantity'] == 0 ){
                $delete_from_list = "DELETE FROM ingredients_used WHERE ingredient_used = '$name' ";
                mysqli_query($connection, $delete_from_list);
                header('location:Cook.php');
                exit();
            }
        }
    }
?>