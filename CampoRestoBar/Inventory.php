<?php include 'header.php'; ?>
<style>
    <?php include 'CSS/inventory.css';?>
</style>

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
                        <Select id="ingNewVolume" class="ingNewVolume" name="ingUnit">
                            <option value="Try">Tray/s</option>
                            <option value="Pc">Piece/s</option>
                            <option value="Kg">Kilogram/s</option>
                            <option value="gm">Gram/s</option>
                            <option value="L">Liter/s</option>
                            <option value="ml">Mililiter/s</option>
                        </Select>
                    </div>
                    <div>
                        <label for="ingNewPrice" id="labelForPrice">Price</label>
                        <span>₱</span><input type="text" id="ingNewPrice" class="ingNewPrice" name="ingPrice" value="0000.00">
                    </div>
                    <div>
                        <input type="submit" id="addIngSubmit" name="addIngredients" value="Add Ingredient">
                    </div>
                </div>
            </div>
            <div class="totalNewInv">
                <p>New Ingredients Total Cost</p>
                <h1>₱ 99999.99</h1>
            </div>
        </form>
        <?php 
            if(isset($_POST['addIngredients'])){
                $ing_name = $_POST['ingNameNew'];
                $ing_quantity = $_POST['ingNewQuan'];
                $ing_unit = $_POST['ingUnit'];
                $ing_price = $_POST['ingPrice'];

                $addIngredient = "INSERT INTO payment_history (ing_name, ing_quantity, ing_unit, ing_price) 
                VALUES ('$ing_name', $ing_quantity, '$ing_unit', $ing_price ) ";
                $adding_query = mysqli_query($connection, $addIngredient);
                header('location:Inventory.php');
            }
        ?>
        <form action="">
            <div class="ingRestock">
                <h1>Restock Ingredient</h1>
                <div class="ingRes">
                    <div id="ingResName">
                        <div>
                            <label for="ingredientName">Restock</label>
                            <select name="ingredientName" id="ingredientName">
                                <?php 
                                    $showingredients = "SELECT * FROM payment_history";
                                    $showingredients_query = mysqli_query($connection, $showingredients);
                                    while($row = mysqli_fetch_assoc($showingredients_query)){
                                        $row['ing_name'];
                                        $row['ing_quantity'];
                                        $row['ing_unit'];
                                        $row['ing_price'];
                                    
                                ?>
                                <option value="<?php echo $row['ing_name'] ?>"><?php echo $row['ing_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div>
                            <label for="resVol">Quantity</label>
                            <input type="number" id="resVol" class="resVol" name="resVol">
                        </div>
                        <div>
                            <!-- <Select id="ingVolume" class="ingVolume" name="ingVolume">
                                <option value="Trys">Trys</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Kgs">Kgs</option>
                                <option value="Grms">gms</option>
                                <option value="Lts">Lts</option>
                                <option value="mLts">mLs</option>
                            </Select> -->
                            <!-- <button type="submit">restock</button> -->
                            <input type="submit" id="addIngSubmit" name="addIngredients" value="Restock">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
</section>