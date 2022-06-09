<?php include 'header.php'; ?>
<style>
    <?php include 'CSS/cook.css';?>
</style>

<section class="campoCook" id="campoCook">
    <div class="campoCookContent">
        <div class="cookDetails cookAddIngredient">
            <h1>ADD INGREDIENTS HERE</h1>
            <div class="addIngredient">
                <h3>Add Ingredients</h3>
                <div class="addContent">
                    <div style="width: 45%;"><input type="text" id="ingName" placeholder="Ingredient"></div>
                    <div style="width: 27%;"><input type="number" id="ingQuantity" placeholder="Qnty"> <p>Kg/s</p></div>
                    <div style="width: 25%;"><button id="addIngredientBtn">Add</button></div>
                </div>
                <div class="ingAddedList">
                    <h3>Ingredient List</h3>
                    <table>
                        <thead>
                            <tr>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="30%">Salt Papi</td>
                                <td width="20%">2 Kgs</td>
                                <td width="30%">₱ 10.00/Kgs</td>
                                <td width="10%">
                                    <button><i class="fas fa-plus"></i></button>
                                </td>
                                <td width="10%">
                                    <button><i class="fas fa-minus"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="addIngSummary">
                    <div>
                        <p>Total Ingredients</p>
                        <h2>100 Kinds</h2>
                    </div>
                    <div>
                        <p>Ingredient Total Amount</p>
                        <h2>₱ 10000.00</h2>
                    </div>
                </div>
                <div class="addSumBtn">
                    <button>HISTORY</button>
                    <button>COOK</button>
                </div>
            </div>
        </div>
        <div class="cookDetails cookFoodDetails">
            <h1>LET'S COOK!!</h1>
            
        </div>
        <div class="cookDetails cookServeToCustomer">
            <h1>SERVE HERE</h1>

        </div>
    </div>
</section>