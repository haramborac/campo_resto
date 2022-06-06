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
                        <input type="number" id="ingNewQuan" class="ingNewQuan" name="ingNewQuan">
                        <Select id="ingNewVolume" class="ingNewVolume" name="ingNewVolume">
                            <option value="Pcs">Piece/s</option>
                            <option value="Kgs">Kilogram/s</option>
                            <option value="Grms">Gram/s</option>
                            <option value="Lts">Liter/s</option>
                            <option value="mLts">miliLiter/s</option>
                        </Select>
                    </div>
                    <div>
                        <label for="ingNewPrice">Price</label>
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
    </div>
</section>