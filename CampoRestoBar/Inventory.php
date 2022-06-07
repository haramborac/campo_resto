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
                        <label for="ingNameNew">Ingredients Name</label>
                        <input type="text" id="ingNameNew" class="ingNameNew" name="ingNameNew">
                    </div>
                    <div>
                        <label for="ingNewQuan">Quantity</label>
                        <input type="number" id="ingNewQuan" class="ingNewQuan" name="ingNewQuan" style="text-align: right;">

                        <Select id="ingNewVolume" class="ingNewVolume" name="ingNewVolume">
                            <option value="Pcs">Piece/s</option>
                            <option value="Kgs">Kilogram/s</option>
                            <option value="Grms">Gram/s</option>
                            <option value="Lts">Liter/s</option>
                            <option value="mLts">Mililiter/s</option>

                        </Select>
                    </div>
                    <div>
                        <label for="ingNewPrice" id="labelForPrice">Price</label>
                        <span>₱</span><input type="text" id="ingNewPrice" class="ingNewPrice" name="ingPrice" value="0000.00">
                    </div>
                    <div>
                        <button type="submit" id="addIngSubmit" name="addIngredients">Add Ingredient</button>
                    </div>
                </div>
            </div>
            <div class="totalCostInv new">
                <p>New Ingredients Total Cost</p>
                <h1>₱ 99999.99</h1>
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
                            <label for="ingredientName">Restock</label>
                            <select name="restockIngredientName" id="ingredientName">
                                <?php 
                                    $showingredients = "SELECT * FROM ingredients";
                                    $showingredients_query = mysqli_query($connection, $showingredients);
                                    while($row = mysqli_fetch_assoc($showingredients_query)){
                                        $row['ing_name'];
                                        $row['ing_quantity'];
                                        $row['ing_unit'];
                                        $row['ing_price'];
                                    
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
                                <option value="Pcs">Pcs</option>
                                <option value="Kgs">Kgs</option>
                                <option value="Grms">Gms</option>
                                <option value="Lts">Lts</option>
                                <option value="mLts">mLs</option>
                            </Select>
                        </div>
                    </div>
                    <div>
                        <label for="">Price</label>
                        <span>₱</span><input type="number" id="resPrice" class="resPrice" name="resPrice" value="0000.00">
                    </div>
                    <div>
                        <button type="submit" name="restockIngredients">Restock Ingredient</button>
                    </div>
                </div>
            </div>
            <div class="totalCostInv old">
                <p>Overall Ingredients Total Cost</p>
                <h1>₱ 99999.99</h1>
            </div>
        </form>
        <?php 
            if(isset($_POST['restockIngredients'])){
                $restockIng_name = $_POST['restockIngredientName'];
                $restockIng_quantity = $_POST['resVol'];

                $restockIng = "UPDATE payment_history SET ing_quantity = ing_quantity+$restockIng_quantity WHERE ing_name = '$restockIng_name' ";
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
                    <tr>
                        <td width="20%">DSalt Papi</td>
                        <td width="10%">612219</td>
                        <td width="5%">Pcs</td>
                        <td width="10%">₱ 9999.99</td>
                        <td width="15%">₱ 99.99/Kg</td>
                        <td width="10%" id="highLight">High Level</td>
                        <td width="15%">January 24 1999</td>
                        <td width="15%">June 07 2022</td>
                    </tr>
                    <tr>
                        <td width="20%">ASalt Papi</td>
                        <td width="10%">69449</td>
                        <td width="5%">Kgs</td>
                        <td width="10%">₱ 999.99</td>
                        <td width="15%">₱ 99.99/Kg</td>
                        <td width="10%" id="highLight">High Level</td>
                        <td width="15%">January 24 1999</td>
                        <td width="15%">June 07 2022</td>
                    </tr>
                    <tr>
                        <td width="20%">BSalt Papi</td>
                        <td width="10%">6999</td>
                        <td width="5%">Gms</td>
                        <td width="10%">₱ 99.99</td>
                        <td width="15%">₱ 99.99/Kg</td>
                        <td width="10%" id="highLight">High Level</td>
                        <td width="15%">January 24 1999</td>
                        <td width="15%">June 07 2022</td>
                    </tr>
                    <tr>
                        <td width="20%">CSalt Papi</td>
                        <td width="10%">69999</td>
                        <td width="5%">Kgs</td>
                        <td width="10%">₱ 9.99</td>
                        <td width="15%">₱ 99.99/Kg</td>
                        <td width="10%" id="highLight">High Level</td>
                        <td width="15%">January 24 1999</td>
                        <td width="15%">June 07 2022</td>
                    </tr>
                    <?php 
                        $showingredients = "SELECT * FROM ingredients";
                        $showingredients_query = mysqli_query($connection, $showingredients);
                        while($row = mysqli_fetch_assoc($showingredients_query)){
                    ?>
                    <tr>
                        <td width="20%"><?php echo $row['ingName'] ?></td>
                        <td width="10%"><?php echo $row['ingQuantity'] ?></td>
                        <td width="5%"><?php echo $row['ingUnit'].'/s' ?></td>
                        <td width="10%">₱ <?php echo number_format($row['ingCost'], 2) ?></td>
                        <td width="15%">₱ 99.99/ <?php echo $row['ingUnit'] ?></td>
                        <td width="10%" id="highLight">High Level</td>
                        <td width="15%">January 24 1999</td>
                        <td width="15%">June 07 2022</td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    
</section>