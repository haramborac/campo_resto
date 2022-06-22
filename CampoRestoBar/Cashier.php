<?php include 'header.php'; ?>
<script>
    <?php include 'JS/cashier.js';?>
</script>
<style>
    <?php include 'CSS/cashier.css';?>
</style>

<section>
    <div class="cashierContent">
        <div>
            <h1>Welcome To Campo</h1>
        </div>
        <div class="cashierContainer">
            <div class="tabsForCash mealAvailable">
                <h3>Available Meals</h3>
                <div class="searchMeal">
                    <span><i class="fas fa-search"></i></span><input type="text" id="searchAvMeal" name="searchAvMeal" placeholder="Search Meal..." onkeyup= "searchFilter();">
                </div>
                <div class="servedMeal">
                    <table id="tableAv">
                        <thead>
                            <tr>
                                <th width="40%">Meal</th>
                                <th width="20%">Servings</th>
                                <th width="40%">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $show_serving_meals = mysqli_query($connection, "SELECT * FROM meals WHERE status = 'serving' ");
                                while($serve = mysqli_fetch_assoc($show_serving_meals)){
                            ?>
                            <tr>
                                <td width="40%"><?php echo $serve['name'] ?></td>
                                <td width="30%"><?php echo $serve['serving'] ?></td>
                                <td width="40%">₱ <?php echo $serve['base_cost'] ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tabsForCash orderMeal">

            </div>
            <div class="tabsForCash mealReserved">

            </div>
        </div>
    </div>
</section>