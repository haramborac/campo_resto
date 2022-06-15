<?php include 'header.php'; ?>
<style>
    <?php include 'CSS/dashboard.css'; ?>
</style>

<section class="campoDashboard" id="campoDashboard">
    <div class="campoWelcome">
        <div class="welcome">
            <img src="IMG/campoLogoBlack.png" alt="">
            <h1>Welcome <span>Josh</span>,</h1>
            <p>Serve Well and Enjoy!</p>
        </div>
        <div class="currentStats">
            <h1>DASHBOARD</h1>
            <div class="campoCard">
                <h1>Inventory</h1>
                <p>Here you can see the current number of Ingredients listed on the system</p>
                <div class="breakNumbers">
                    <div>
                        <h3>Total Ingredients</h3>
                        <?php
                            $showingredients = "SELECT COUNT(ingName) AS NumberOfIngredients FROM ingredients";
                            $showingredients_query = mysqli_query($connection, $showingredients);
                            if(mysqli_num_rows($showingredients_query)>0){
                                while($total_ing = mysqli_fetch_assoc($showingredients_query)){
                                    $total_ingredients = $total_ing['NumberOfIngredients'];
                                }
                            }else{
                                $total_ingredients = 0;
                            }
                        ?>
                        <h1><?php echo $total_ingredients ?> kinds</h1>
                    </div>
                    <hr>
                    <div>
                        <h3>Ingredients Cost</h3>
                        <?php
                            $ingredientprices = "SELECT SUM(ingCost) AS ingredientCost FROM ingredients";
                            $ingredientprices_query = mysqli_query($connection, $ingredientprices);
                            if(mysqli_num_rows($showingredients_query)>0){
                                while($ing_cost = mysqli_fetch_assoc($ingredientprices_query)){
                                    $ingredient_cost = $ing_cost['ingredientCost'];
                                }
                            }else{
                                $ingredient_cost = 0;
                            }   
                        ?>
                        <h1>₱ <?php echo number_format($ingredient_cost, 2) ?></h1>
                    </div>
                </div>
                <?php
                        $lowIngredients = "SELECT COUNT(ingQuantity) AS lowingredients FROM ingredients WHERE ingQuantity <= 10 ";
                        $lowIngredients_query = mysqli_query($connection, $lowIngredients);
                        if(mysqli_num_rows($lowIngredients_query)>0){
                            while($lowing = mysqli_fetch_assoc($lowIngredients_query)){
                                $low_ingredients = $lowing['lowingredients'];
                            }    
                                if($low_ingredients == 0){
                                    $echo = "";
                                }else{
                                    if($low_ingredients == 1){
                                        $echo = "<div class='warningMessage'>
                                        <h4><span>WARNING :</span> $low_ingredients Ingredient at Low Level !</h4>
                                        </div>";
                                    } else{
                                        $echo = "<div class='warningMessage'>
                                        <h4><span>WARNING :</span> $low_ingredients Ingredients at Low Level !</h4>
                                        </div>";
                                    }

                                }
                        }else{
                            $low_ingredients = 0;
                        }   
                    ?>
                    <?php echo $echo ?>

            </div>
            <div class="campoCard">
                <h1>Cook</h1>
                <p>Here you can see the Ingredients used and Meal Base Cost</p>
                <div class="breakNumbers">
                    <div>
                        <h3>Ingredients Used</h3>
                        <h1>100 kinds</h1>
                    </div>
                    <hr>
                    <div>
                        <h3>Meal Cost</h3>
                        <h1>₱ 999999.99</h1>
                    </div>
                </div>
                <div class="warningMessage">
                    <h4><span>WARNING :</span> 3 Meals not sold.</h4>
                </div>
            </div>
            <div class="campoCard">
                <h1>Cashier</h1>
                <p>Here You can see the Overall Sale of the Restobar.</p>
                <div class="breakNumbers">
                    <div>
                        <h3>Total Meals</h3>
                        <h1>100</h1>
                    </div>
                    <hr>
                    <div>
                        <h3>Overall Sale</h3>
                        <h1>₱ 999999.99</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>