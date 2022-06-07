<?php include 'header.php'; ?>
<style>
    <?php include 'CSS/inventory.css';?>
</style>
<script>
      document.addEventListener('DOMContentLoaded',function (){
        sortName();
});
</script>
<section class="campoInventory" id="campoInventory">
    <div class="invContent">
        <h1>INGREDIENTS INVENTORY</h1>
        <form action="" method="post">
            <div class="addNewIng">
                <h1>Add New Ingredient</h1>
                <div class="addNew">
                    <div>
                        <label for="ingNameNew">Ingredient Name</label>
                        <input type="text" id="ingNameNew" class="ingNameNew" name="ingNameNew">
                    </div>
                    <div>
                        <label for="ingNewQuan">Quantity</label>
                        <input type="number" id="ingNewQuan" class="ingNewQuan" name="ingNewQuan" style="text-align: right;">

                        <Select id="ingNewVolume" class="ingNewVolume" name="ingNewVolume">

                            <option value="Pc">Piece/s</option>
                            <option value="Kg">Kilogram/s</option>
                            <option value="g">Gram/s</option>
                            <option value="L">Liter/s</option>
                            <option value="ml">Mililiter/s</option>

                        </Select>
                    </div>
                    <div>
                        <label for="ingNewPrice" id="labelForPrice">Price</label>
                        <span>₱</span><input type="text" id="ingNewPrice" class="ingNewPrice" name="ingPrice" value="0.00">
                    </div>
                    <div>
                        <button type="submit" id="addIngSubmit" name="addIngredients">Add Ingredient</button>
                    </div>
                </div>
            </div>
            <div class="totalCostInv new">
                <p>New Ingredients Total Cost</p>
                <?php
                            
                    $ingredientprices = "SELECT SUM(ingCost) AS ingredientCost FROM ingredients /*WHERE ingListed = now()*/";
                    $ingredientprices_query = mysqli_query($connection, $ingredientprices);
                    while($ing_cost = mysqli_fetch_assoc($ingredientprices_query)){
                
                ?>
                <h1>₱ <?php echo number_format($ing_cost['ingredientCost'], 2) ?></h1>
                <?php } ?>
            </div>
        </form>
        <?php 
            if(isset($_POST['addIngredients'])){
                $ing_name = $_POST['ingNameNew'];
                $ing_quantity = $_POST['ingNewQuan'];
                $ing_unit = $_POST['ingNewVolume'];
                $ing_price = $_POST['ingPrice'];

                if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$ing_name'"))>0){
                    echo "ingredient already exists";
                }else{
                    $addIngredient = "INSERT INTO ingredients (ingName, ingQuantity, ingUnit, ingCost, ingListed, ingUpdated) 
                    VALUES ('$ing_name', $ing_quantity, '$ing_unit', $ing_price, now(), now() ) ";
                    $adding_query = mysqli_query($connection, $addIngredient);
                    header('location:Inventory.php');
                } 
            }
        ?>
        <form action="" method="post">
            <div class="ingRestock">
                <h1>Restock Ingredient</h1>
                <div class="ingRes">
                    <div id="ingResName" class="ingResName">
                        <div>
                            <label for="ingredientName">Ingredient Name</label>
                            <select name="restockIngredientName" id="ingredientName">
                                <?php 
                                    $showingredients = "SELECT * FROM ingredients";
                                    $showingredients_query = mysqli_query($connection, $showingredients);
                                    while($row = mysqli_fetch_assoc($showingredients_query)){
                                    
                                ?>
                                <option value="<?php echo $row['ingName'] ?>"><?php echo $row['ingName'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div>
                            <label for="resVol">Quantity</label>
                            <input type="number" id="resVol" class="resVol" name="resVol">
                        </div>
                        <div>
                            <Select id="ingVolume" class="ingVolume" name="ingVolume">
                                <option value="Pc">Pcs</option>
                                <option value="Kg">Kgs</option>
                                <option value="g">Grams</option>
                                <option value="L">Liters</option>
                                <option value="ml">mililiters</option>
                            </Select>
                        </div>
                    </div>
                    <div>
                        <label for="resPrice">Price</label>
                        <span>₱</span><input type="number" id="resPrice" class="resPrice" name="resPrice" value="0000.00">
                    </div>
                    <div>
                        <button type="submit" name="restockIngredients">Restock Ingredient</button>
                    </div>
                </div>
            </div>
            <div class="totalCostInv old">
                <p>Overall Ingredients Total Cost</p>
                <?php
                            
                    $ingredientprices1 = "SELECT SUM(ingCost) AS ingredientCost FROM ingredients";
                    $ingredientprices_query1 = mysqli_query($connection, $ingredientprices1);
                    while($ing_cost1 = mysqli_fetch_assoc($ingredientprices_query1)){
                
                ?>
                <h1>₱ <?php echo number_format($ing_cost1['ingredientCost'], 2) ?></h1>
                <?php } ?>
            </div>
        </form>
        <?php 
            if(isset($_POST['restockIngredients'])){
                $restockIng_name = $_POST['restockIngredientName'];
                $restockIng_quantity = $_POST['resVol'];

                $restockIng = "UPDATE ingredients SET 
                ingQuantity = ingQuantity+$restockIng_quantity, 
                ingUpdated = now() 
                WHERE ingName = '$restockIng_name' ";
                $restockIng_query = mysqli_query($connection, $restockIng);
                header('location:Inventory.php');
            }
        ?>
        <div class="invModalButtons">
            <button>History</button>
            <button>Summary</button>
        </div>
    </div>
    <div class="invList">
        <div class="invListContainer">
            <div class="sortIngredients">
                <div>
                    <label for="searchIng">Search Ingredient</label>
                    <input type="text" id="searchIng" class="searchIng" name="searchIng" onkeyup= "searchFilter();">
                </div>
                <div>
                    <label for="sortIngBy">Sort</label>
                    <select name="sortIngBy" id="sortIngBy" onchange="sorting();">
                        <option value="name">Name</option>
                        <option value="quantity">Quantity</option>
                        <option value="unit">Unit</option>
                        <option value="price">Price</option>
                        <option value="status">Status</option>
                        <option value="date">Date</option>
                    </select>
                </div>
            </div>
            <div class="ingredientsList">
                <table id="tableTitle">
                    <tr>
                        <th width="20%">Ingredient Name</th>
                        <th width="10%">Quantity</th>
                        <th width="5%">Unit</th>
                        <th width="10%">Cost</th>
                        <th width="15%">Cost/Unit</th>
                        <th width="10%">Status</th>
                        <th width="15%">Date Listed</th>
                        <th width="15%">Date Updated</th>
                    </tr>
                    <?php 
                        $showingredients = "SELECT * FROM ingredients";
                        $showingredients_query = mysqli_query($connection, $showingredients);
                        while($row = mysqli_fetch_assoc($showingredients_query)){
                            $costperunit = $row['ingCost']/100;
                    ?>
                    <tr>
                        <td width="20%"><?php echo $row['ingName'] ?></td>
                        <td width="10%"><?php echo $row['ingQuantity'] ?></td>
                        <td width="5%"><?php echo $row['ingUnit'].'/s' ?></td>
                        <td width="10%">₱ <?php echo number_format($row['ingCost'], 2) ?></td>
                        <td width="15%">₱ <?php echo $costperunit ?>/<?php echo $row['ingUnit'] ?></td>
                        <td width="10%" id="highLight">High Level</td>
                        <td width="15%"><?php echo date('F m, Y', strtotime($row['ingListed'])) ?></td>
                        <td width="15%"><?php echo date('F m, Y', strtotime($row['ingUpdated'])) ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    
</section>
