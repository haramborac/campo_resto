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
                            <tr>
                                <td width="40%">Dinuguan</td>
                                <td width="30%">10</td>
                                <td width="40%">₱ 10000.00</td>
                            </tr>
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