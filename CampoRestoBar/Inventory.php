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
                        <button id="addIngSubmit">Add Ingredient</button>
                    </div>
                </div>
            </div>
            <div class="totalCostInv new">
                <p>New Ingredients Total Cost</p>
                <h1>₱ 99999.99</h1>
            </div>
        </form>
        <form action="">
            <div class="ingRestock">
                <h1>Restock Ingredient</h1>
                <div class="ingRes">
                    <div id="ingResName" class="ingResName">
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
                                <option value="Pcs">Pcs</option>
                                <option value="Kgs">Kgs</option>
                                <option value="Grms">gms</option>
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
                        <button>Restock Ingredient</button>
                    </div>
                </div>
            </div>
            <div class="totalCostInv old">
                <p>Overall Ingredients Total Cost</p>
                <h1>₱ 99999.99</h1>
            </div>
        </form>
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
                    <input type="text" id="searchIng" class="searchIng" name="searchIng">
                </div>
                <div>
                    <label for="sortIngBy">Sort</label>
                    <select name="sortIngBy" id="sortIngBy">
                        <option value="name">Name</option>
                        <option value="volume">Volume</option>
                        <option value="price">Price</option>
                        <option value="status">Status</option>
                        <option value="dateListed">Date</option>
                    </select>
                </div>
            </div>
            <div class="ingredientsList">
                <table id="tableTitle">
                    <tr>
                        <th width="20%">Ingredient Name</th>
                        <th width="10%">Quantity</th>
                        <th width="10%">Unit</th>
                        <th width="10%">Status</th>
                        <th width="10%">Cost</th>
                        <th width="20%">Date Listed</th>
                        <th width="20%">Date Updated</th>
                    </tr>
                    <tr>
                        <td width="20%">Salt Papi</td>
                        <td width="10%">69</td>
                        <td width="10%">Kgs</td>
                        <td width="10%" id="">High Level</td>
                        <td width="10%">₱ 99999.99</td>
                        <td width="20%">January 24 1999</td>
                        <td width="20%">June 07 2022</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>