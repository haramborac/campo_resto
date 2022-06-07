<?php include 'header.php'; ?>
<style>
    <?php include 'CSS/inventory.css';?>
</style>

<section class="campoInventory" id="campoInventory">
    <div class="invContent">
        <h1>INGREDIENTS INVENTORY</h1>
        <form action="">
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
                            <option value="Trys">Tray/s</option>
                            <option value="Pcs">Piece/s</option>
                            <option value="Kgs">Kilogram/s</option>
                            <option value="Grms">Gram/s</option>
                            <option value="Lts">Liter/s</option>
                            <option value="mLts">Mililiter/s</option>
                        </Select>
                    </div>
                    <div>
                        <label for="ingNewPrice" id="labelForPrice">Price</label>
                        <span>₱</span><input type="text" id="ingNewPrice" class="ingNewPrice" name="ingNewPrice" value="0000.00">
                    </div>
                    <div>
                        <input type="button" id="addIngSubmit" name="submit" value="Add Ingredient">
                    </div>
                </div>
            </div>
            <div class="totalNewInv">
                <p>New Ingredients Total Cost</p>
                <h1>₱ 99999.99</h1>
            </div>
        </form>
        <form action="">
            <div class="ingRestock">
                <h1>Restock Ingredient</h1>
                <div class="ingRes">
                    <div id="ingResName">
                        <div>
                            <label for="ingredientName">Restock</label>
                            <select name="ingredientName" id="ingredientName">
                                <option value="">Salt Papi</option>
                                <option value="">Salt Papi</option>
                                <option value="">Salt Papi</option>
                                <option value="">Salt Papi</option>
                            </select>
                        </div>
                        <div>
                            <label for="resVol">Quantity</label>
                            <input type="number" id="resVol" class="resVol" name="resVol">
                        </div>
                        <div>
                            <Select id="ingVolume" class="ingVolume" name="ingVolume">
                                <option value="Trys">Trys</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Kgs">Kgs</option>
                                <option value="Grms">gms</option>
                                <option value="Lts">Lts</option>
                                <option value="mLts">mLs</option>
                            </Select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>