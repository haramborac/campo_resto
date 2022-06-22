<?php
    include "Db.php";

    //login
    function logIn(){
        global $connection;
        
    }
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
                echo "<p style='color: red; font-style: italic;'>Missing Input</p>";
            }else{
                if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM ingredients_used WHERE ingredient_used = '$ingredient' AND status = 'added' "))>0){
                    echo "<p style='color: red; font-style: italic;'>Ingredient Already Added</p>";
                }elseif(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$ingredient' ")) == 0){
                    echo "<p style='color: red; font-style: italic;'>Ingredient Does Not Exist</p>";
                }else{
                    $checkstock = mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$ingredient' ");
                    while($stock = mysqli_fetch_assoc($checkstock)){
                        $remaining_stock = $stock['ingQuantity'];
                    }
                    if($remaining_stock<$quantity){
                        echo "<p style='color: red; font-style: italic;'>Not Enough Stock</p>";
                    }else{
                        echo "heh";
                        $getingredients = "UPDATE ingredients SET ingQuantity = ingQuantity-$quantity WHERE ingName = '$ingredient' ";
                        mysqli_query($connection, $getingredients);
                        $addtolist = "INSERT INTO ingredients_used (ingredient_used, quantity, status) VALUES ('$ingredient', $quantity, 'added') ";
                        mysqli_query($connection, $addtolist);
                        header('location:Cook.php');
                    } 
                } 
            }               
        }
    }

    //add 1 in cook.php
    if(isset($_GET['add'])){
        $name = $_GET['add'];
        $checkstock = mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$name' ");
        while($row = mysqli_fetch_assoc($checkstock)){
            if($row['ingQuantity'] == 0 ){
                header('location:Cook.php?stock=empty');
                exit();
            }else{
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
        $checkstock = mysqli_query($connection, "SELECT * FROM ingredients_used WHERE ingredient_used = '$name' ");
        while($row = mysqli_fetch_assoc($checkstock)){
            if($row['quantity'] == 0 ){
                $delete_from_list = "DELETE FROM ingredients_used WHERE ingredient_used = '$name' ";
                mysqli_query($connection, $delete_from_list);
                header('location:Cook.php');
                exit();  
            }
        }
    }
    //change:not finished
    function cookList(){
        global $connection;
        if(isset($_POST['cookIngredients'])){
            // $foodid = $_POST['foodid'];
            $listName = $_POST['ingListName'];
            $listQuantity = $_POST['ingListQuantity'];
            $listUnit = $_POST['ingListUnit'];
            $listCost = $_POST['ingListCost'];
            if(!empty($listName) || !empty($listQuantity) || !empty($listCost)){
                foreach($listName as $key => $n ) {
                    echo $n;
                    // $cook = "INSERT INTO current_ingredients (name, quantity, cost) VALUES ('$n', '$listQuantity[$key]', '$listCost[$key]')";
                    // mysqli_query($connection, $cook);
                   

                    // $ingredient_history = "INSERT INTO ingredient_used_history (ingredient, quantity, cost, date_used) 
                    // VALUES ('$n', '$listQuantity[$key]', '$listCost[$key]', now()) ";
                    // mysqli_query($connection, $ingredient_history);

                    // mysqli_query($connection, " DELETE FROM ingredients_used WHERE ingredient_used = '$n' ");
                    // header('location:Cook.php');

                    $cook = "UPDATE ingredients_used SET 
                    unit = '$listUnit[$key]', 
                    cost = $listCost[$key], 
                    status = 'cooked', 
                    date_added = now() 
                    where status = 'added' AND ingredient_used = '$n'  ";
                    mysqli_query($connection, $cook);
                    header('location:Cook.php');
                }
            }
        }
    }

    function cookMeal (){
        global $connection;
        if(isset($_POST['cookMeal'])){
            $mealname = mysqli_real_escape_string($connection, $_POST['nameMeal']);
            $mealserving =  mysqli_real_escape_string($connection, $_POST['servingMeal']);
            $mealcost =  mysqli_real_escape_string($connection, $_POST['bcostMeal']);

            if(empty($mealname) ||empty($mealserving) ||empty($mealcost)){
                echo "<p style='color: red; font-style: italic;'>Please Input All Fields</p>";
            }else{
                $cookmeal = "INSERT INTO meals (name, serving, base_cost, status) 
                VALUES ('$mealname', $mealserving, $mealcost, 'cooked')";
                mysqli_query($connection, $cookmeal);
                header('location:Cook.php');
            }
        }
    }
    //change
    function addMeal(){
        global $connection;
        if(isset($_POST['AddMeal'])){
            $cookMealName = $_POST['cookMealName'];
            $cookMealServing = $_POST['cookMealServing'];
            $cookMealCost = $_POST['cookMealCost'];

            if(empty($cookMealName)||empty($cookMealName)||empty($cookMealName)){
                echo "<p style='color: red; font-style: italic;'>Please Input All Fields</p>";
            }else{
                foreach($cookMealName as $key => $n ) {
                    $addMeal = "UPDATE meals SET 
                    status = 'available'
                    where name = '$n' AND status = 'cooked'";
                    //$addMeal = "INSERT INTO served_meals (name, serving, base_cost) VALUES ('$n', $cookMealServing[$key], $cookMealCost[$key] )";
                    mysqli_query($connection, $addMeal);
                    //mysqli_query($connection, " DELETE FROM cooked_meals WHERE name = '$n' ");
                    // header('location:Cook.php');
                    mysqli_query($connection, "UPDATE ingredients_used SET status = 'used' WHERE status = 'cooked' ");
                    header('location:Cook.php');

                }
            }
        }
    }

    function serveMeal(){
        global $connection;
        if(isset($_POST['serveMeal'])){
            $serveMealName = $_POST['availMealName'];
            $serveMealServing = $_POST['availMealServing'];
            $serveMealCost = $_POST['availMealCost'];
    
            foreach($serveMealName as $key => $n ) {
                $serveMeal = "UPDATE meals SET status = 'serving' WHERE name = '$n' AND status = 'available'  ";
                mysqli_query($connection, $serveMeal);
                header('location:Cook.php');
            }
        }
    }
?>