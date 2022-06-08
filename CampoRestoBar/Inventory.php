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
        <h1>INVENTORY SYSTEM</h1>
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
                            <option value="ml">Milliliter/s</option>

                        </Select>
                    </div>
                    <div>
                        <label for="ingNewPrice" id="labelForPrice">Price</label>
                        <span>₱</span><input type="text" id="ingNewPrice" class="ingNewPrice" name="ingPrice" placeholder="0.00">
                    </div>
                    <div>
                        <button type="submit" id="addIngSubmit" name="addIngredients" class="btnHover" disabled>Add Ingredient</button>
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
                $ing_name = mysqli_real_escape_string($connection, $_POST['ingNameNew']);
                $ing_quantity = mysqli_real_escape_string($connection, $_POST['ingNewQuan']);
                $ing_unit = mysqli_real_escape_string($connection, $_POST['ingNewVolume']);
                $ing_price = mysqli_real_escape_string($connection, $_POST['ingPrice']);
                
                if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$ing_name'"))>0){
                    echo "ingredient already exists";
                }else{
                    $addIngredient = "INSERT INTO ingredients (ingName, ingQuantity, ingUnit, ingCost, ingListed, ingUpdated) 
                    VALUES ('$ing_name', $ing_quantity, '$ing_unit', $ing_price, now(), now() ) ";
                    $adding_query = mysqli_query($connection, $addIngredient);
                    header('location:Inventory.php');

                    $inventoryhistory = "INSERT INTO inventory_history (ingredient, cost, date) VALUE ('$ing_name', $ing_price, now() )";
                    $invhistory_query = mysqli_query($connection, $inventoryhistory);
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
                                        $ingname = $row['ingName'];
                                ?>
                                <option value="<?php echo $row['ingName'] ?>"><?php echo $row['ingName'] ?></option>
                                
                            </select>
                        </div>
                        <div>
                            <label for="resVol">Quantity</label>
                            <input type="number" id="resVol" class="resVol" name="resVol">
                        </div>
                        <div>
                            <Select id="ingVolume" class="ingVolume" name="ingVolume">
                                <?php 
                                    $showingredients1 = "SELECT ingUnit FROM ingredients WHERE ingName = '$ingname' ";
                                    $showingredients_query1 = mysqli_query($connection, $showingredients1);
                                    while($row1 = mysqli_fetch_assoc($showingredients_query1)){
                                    
                                ?>
                                <option value="<?php echo $row1['ingUnit'] ?>"><?php echo $row1['ingUnit'] ?></option>
                                <option value="Pc">Piece/s</option>
                                <option value="Kg">Kilogram/s</option>
                                <option value="g">Gram/s</option>
                                <option value="L">Liter/s</option>
                                <option value="ml">Milliliter/s</option>
                            </Select>
                        </div>
                        <?php }} ?>
                    </div>
                   
                    <div>
                        <label for="">Price</label>
                        <span>₱</span><input type="number" id="resPrice" class="resPrice" name="resPrice" placeholder="0.00">
                    </div>
                    <div>
                        <button type="submit" id="restockIngSubmit" name="restockIngredients" class="btnHover" disabled>Restock Ingredient</button>
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
                $restockIng_name = mysqli_real_escape_string($connection, $_POST['restockIngredientName']);
                $restockIng_quantity = mysqli_real_escape_string($connection, $_POST['resVol']);

                $restockIng = "UPDATE ingredients SET 
                ingQuantity = ingQuantity+$restockIng_quantity, 
                ingUpdated = now() 
                WHERE ingName = '$restockIng_name' ";
                $restockIng_query = mysqli_query($connection, $restockIng);
                header('location:Inventory.php');
            }
        ?>
        <div class="invModalButtons">
            <button id="viewHistory" class="extrasBtn" onclick="viewHistory()">History</button>
            <button id="viewSummary" class="extrasBtn" onclick="viewSummary()">Summary</button>
        </div>
    </div>
    <div class="invList">
        <div class="invExtras" id="invExtrasHis" style="display:none">
            <span id="closeModal" class="closeModal" onclick="closeMod()"><i class="fa fa-times"></i></span>
            <div class="invExtPanel history" id="invExtraHistory">
                <h1>Inventory History</h1>
                <div class="invExtTable history">
                    <table>
                        <tr>
                            <th width="25%">Ingredient</th>
                            <th width="15%">Qnty</th>
                            <th width="30%">Cost</th>
                            <th width="30%">Date</th>
                        </tr>
                        <tr>
                            <td width="25%">Salt Papi</td>
                            <td width="15%">3 Pc/s</td>
                            <td width="30%">₱ 1,000.00</td>
                            <td width="30%">January 24,1999</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="invExtras" id="invExtrasSum" style="display:none">
            <span id="closeModal" class="closeModal" onclick="closeMod()"><i class="fa fa-times"></i></span>
            
        </div>
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
                        <th width="15%">Quantity</th>
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
                            $row['ingQuantity'];
                            $quantity = $row['ingQuantity'];
                            $cost;
                                if($quantity==0){
                                    $cost = 0;
                                    $level = "<td width='10%' id='highLight' style='background:black; color:white'>EMPTY</td>";
                                }
                                if($quantity>0 && $quantity<=10){
                                    $level = "<td width='10%' id='highLight' style='background:salmon'>LOW</td>";
                                    $cost=$row['ingCost']/$row['ingQuantity'];
                                }
                                if($quantity>10 && $quantity<=50){
                                    $level ="<td width='10%' id='highLight' style='background:lightgreen'>AVERAGE</td>";
                                    $cost=$row['ingCost']/$row['ingQuantity'];
                                }
                                if($quantity>50){
                                    $level ="<td width='10%' id='highLight' style='background:skyblue'>HIGH</td>";
                                    $cost=$row['ingCost']/$row['ingQuantity'];

                                }
                    ?>
                    <tr>
                        <td width="20%" id="ingNameCont"><?php echo $row['ingName'] ?></td>
                        <td width="15%"><?php echo $quantity?> <?php echo $row['ingUnit'].'/s' ?></td>
                        <td width="10%">₱ <?php echo number_format($row['ingCost'], 2) ?></td>
                        <td width="15%">₱ <?php echo number_format($cost,2) ?>/<?php echo $row['ingUnit'] ?></td>
                        <?php echo $level ?>
                        <td width="15%"><?php echo date('F m, Y', strtotime($row['ingListed'])) ?></td>
                        <td width="15%"><?php echo date('F m, Y', strtotime($row['ingUpdated'])) ?></td>

                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    
</section>
<script>
    let restockName = document.getElementById('ingredientName');
    let unitName = document.getElementById('ingVolume');

    restockName.onchange = function(){

        console.log(restockName.value);
        console.log(unitName.value);
    }
</script>
<script>
    document.getElementById('ingNameNew').addEventListener('keyup',enableAdd);
    document.getElementById('ingNewQuan').addEventListener('keyup',enableAdd);
    document.getElementById('ingNewPrice').addEventListener('keyup',enableAdd); 
    document.getElementById('resVol').addEventListener('keyup',enableRestock);
    document.getElementById('resPrice').addEventListener('keyup',enableRestock);
    document.getElementById('viewHistory').addEventListener('click',viewHistory);
    document.getElementById('viewSummary').addEventListener('click',viewSummary);
    document.getElementById('closeModal').addEventListener('click',closeMod);
</script>
