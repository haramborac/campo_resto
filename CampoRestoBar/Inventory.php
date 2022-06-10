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
                    <?php 
                        if(isset($_POST['addIngredients'])){
                            $ing_name = mysqli_real_escape_string($connection, $_POST['ingNameNew']);
                            $ing_quantity = mysqli_real_escape_string($connection, $_POST['ingNewQuan']);
                            $ing_unit = mysqli_real_escape_string($connection, $_POST['ingNewVolume']);
                            $ing_price = mysqli_real_escape_string($connection, $_POST['ingPrice']);
                            
                            if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$ing_name'"))>0){
                                echo "<p style='color: red; font-style: italic;'>Ingredient Already Exists</p>";
                            }else{
                                $addIngredient = "INSERT INTO ingredients 
                                (ingName, ingQuantity, ingUnit, ingCost, ingCostperUnit, ingListed, ingUpdated) 
                                VALUES ('$ing_name', $ing_quantity, '$ing_unit', $ing_price, $ing_price/$ing_quantity, now(), now() ) ";
                                $adding_query = mysqli_query($connection, $addIngredient);
                                header('location:Inventory.php');

                                $inventoryhistory = "INSERT INTO inventory_history (ingredient, quantity, cost, date) 
                                VALUES ('$ing_name', '$ing_quantity $ing_unit', $ing_price, now() )";
                                $invhistory_query = mysqli_query($connection, $inventoryhistory);
                                header('location:Inventory.php');
                            } 
                        }
                    ?>
                </div>
            </div>
            <div class="totalCostInv new">
                <p>New Ingredients Total Cost</p>
                <?php
                            
                    $ingredientprices = "SELECT SUM(ingCost) AS ingredientCost FROM ingredients WHERE date(ingListed) = curdate()";
                    $ingredientprices_query = mysqli_query($connection, $ingredientprices);
                    while($ing_cost = mysqli_fetch_assoc($ingredientprices_query)){
                
                ?>
                <h1>₱ <?php echo number_format($ing_cost['ingredientCost'], 2) ?></h1>
                <?php } ?>
            </div>
        </form>
        <form action="" method="post">
            <div class="ingRestock">
                <h1>Restock Ingredient</h1>
                <div class="ingRes">
                    
                    <div id="ingResName" class="ingResName">
                        <div>
                            <label for="ingredientName">Ingredient Name</label>
                            <input type="text" id="ingredientName" class="ingredientName" name="restockIngredientName">
                            <div class="suggestions">
                                </div>
                                <div class="invi" style ="display:none">
                                </div>
                        </div>
                        <div>
                            <label for="resVol">Quantity</label>
                            <input type="number" id="resVol" class="resVol" name="resVol">
                        </div>
                        <div>
                            <p id="yunit"></p>
                        </div>
                    </div>
                    <div>
                        <label for="">Price</label>
                        <span>₱</span><input type="number" id="resPrice" class="resPrice" name="resPrice" placeholder="0.00">
                    </div>
                    <div>
                        <button type="submit" id="restockIngSubmit" name="restockIngredients" class="btnHover" disabled>Restock Ingredient</button>
                    </div>
                    <?php 
                        if(isset($_POST['restockIngredients'])){
                            $restockIng_name = mysqli_real_escape_string($connection, $_POST['restockIngredientName']);
                            $restockIng_quantity = mysqli_real_escape_string($connection, $_POST['resVol']);
                            $restockIng_price = mysqli_real_escape_string($connection, $_POST['resPrice']);
                            
                            $z = mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$restockIng_name'");

                            if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$restockIng_name'"))>0){
                                while($asd = mysqli_fetch_assoc($z)){
                                    $rstckUnit = $asd['ingUnit'];
                                    
                                    $restockIng = "UPDATE ingredients SET 
                                    ingQuantity = ingQuantity+$restockIng_quantity,
                                    ingCost = ingCost+$restockIng_price,
                                    ingCostperUnit = ((ingCost+$restockIng_price)/(ingQuantity+$restockIng_quantity))+ingCostperUnit,
                                    ingUpdated = now() 
                                    WHERE ingName = '$restockIng_name' ";
                                    $restockIng_query = mysqli_query($connection, $restockIng);

                                    $inventoryhistory = "INSERT INTO inventory_history (ingredient, quantity, cost, date) 
                                    VALUES ('$restockIng_name', '$restockIng_quantity $rstckUnit', $restockIng_price, now() )";
                                    $invhistory_query = mysqli_query($connection, $inventoryhistory);
                                    header('location:Inventory.php');
                                }
                            }else{
                                echo "<p style='color: red; font-style: italic;'>Ingredient doesn't exist</p>";
                            }
                        }
                    ?>
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
        <div class="invModalButtons">
            <button id="viewHistory" class="extrasBtn" onclick="viewHistory()">HISTORY</button>
            <button id="viewSummary" class="extrasBtn" onclick="viewSummary()">SUMMARY</button>
        </div>
    </div>
    <div class="invList">
        <div class="invExtras" id="invExtrasHis" style="display:none">
            <span id="closeModal" class="closeModal" onclick="closeMod()"><i class="fa fa-times"></i></span>
            <div class="invExtPanel history" id="invExtraHistory">
                <h1>Inventory History</h1>
                <div class="invExtTable history">
                    <table>
                        <thead>
                            <tr>
                                <th width="25%">INGREDIENT</th>
                                <th width="15%">QNTY</th>
                                <th width="30%">COST</th>
                                <th width="30%">DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $showingredients1 = "SELECT * FROM inventory_history";
                                $showingredients_query1 = mysqli_query($connection, $showingredients1);
                                while($row1 = mysqli_fetch_assoc($showingredients_query1)){
                            ?>
                            <tr>
                                <td width="25%"><?php echo $row1['ingredient'] ?></td>
                                <td width="15%"><?php echo $row1['quantity'] ?>/s</td>
                                <td width="30%">₱ <?php echo number_format($row1['cost'], 2)  ?></td>
                                <td width="30%"><?php echo date('F d, Y', strtotime($row1['date'])) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="invExtras" id="invExtrasSum" style="display: none;">
            <span id="closeModal" class="closeModal" onclick="closeMod()"><i class="fa fa-times"></i></span>
            <div class="invExtPanel summary" id="invExtraSummary">
                <h1>Inventory Summary</h1>
                <div class="invESContent">
                    <h2>Inventory Rules</h2>
                    <h3>FIFO</h3>
                    <div class="invESCDetails">
                        <p><i class="fa fa-info-circle"></i> First-In, First-Out. It is an asset management and valuation system 
                            which helps us in selling out the commodities delivered first at the earliest.
                        </p>
                    </div>
                    <h3>Search free</h3>
                    <div class="invESCDetails">
                        <p><i class="fa fa-info-circle"></i> There should be proper segmentation for every different type of 
                            ingredient/stocks to have an organized inventory.
                        </p>
                    </div>
                    <h3>Heavy Stocks on Ground</h3>
                    <div class="invESCDetails">
                        <p><i class="fa fa-info-circle"></i> Heavy stocks should be kept on ground since keeping it at height 
                            will make it difficult to access them and might result in accidents and mishaps.
                        </p>
                    </div>
                    <h3>Fast Consumables NEAR the Entrance</h3>
                    <div class="invESCDetails">
                        <p><i class="fa fa-info-circle"></i> Stocks should be arranged in the inventories as per the rate of 
                            their consumption.
                        </p>
                    </div>
                </div>
                <div class="invStatusContainers">
                    <h1>Stock Level</h1>
                    <div class="statusCard highLevel">
                        <div style="background: skyblue;">
                            <?php 
                                $highlevel = "Select count(ingName) as high from ingredients where ingQuantity > 50";
                                $highquery = mysqli_query($connection,$highlevel);
                                if(mysqli_num_rows($highquery)>0){
                                    while($rowHigh = mysqli_fetch_assoc($highquery)){
                                        $rowH = $rowHigh['high'];
                                    }
                                }else{
                                    $rowH = 0;
                                }
                            ?>
                            <p>High Level Ingredients</p>
                            <h2><?php echo $rowH?></h2>
                        </div>
                    </div>
                    <div class="statusCard averageLevel">
                        <div style="background: lightgreen;">
                            <?php $averagelevel = "Select count(ingName) as average from ingredients where ingQuantity between 10 and 51";
                                        $averagequery = mysqli_query($connection,$averagelevel);
                                        if(mysqli_num_rows($averagequery)>0){
                                            while($rowAve = mysqli_fetch_assoc($averagequery)){
                                            $rowA = $rowAve['average'];
                                            }
                                        }else{
                                            $rowA = 0;
                                        }
                                ?>
                            <p>Average Level Ingredients</p>
                            <h2><?php echo $rowA?></h2>
                        </div>
                    </div>
                    <div class="statusCard lowLevel">
                        <div style="background: salmon;">
                        <?php $lowlevel = "Select count(ingName) as low from ingredients where ingQuantity between 0 and 11";
                                        $lowquery = mysqli_query($connection,$lowlevel);
                                        if(mysqli_num_rows($lowquery)>0){
                                            while($rowLow = mysqli_fetch_assoc($lowquery)){
                                            $rowL = $rowLow['low'];
                                            }
                                        }else{
                                            $rowL = 0;
                                        }
                                ?>
                            <p>Low Level Ingredients</p>
                            <h2><?php echo $rowL?></h2>
                        </div>
                    </div>
                    <div class="statusCard empty">
                        <div style="background: darkgray;">
                        <?php $emptylevel = "Select count(ingQuantity) as empty from ingredients where ingQuantity = 0";
                                        $emptyquery = mysqli_query($connection,$emptylevel);
                                        if(mysqli_num_rows($emptyquery)>0){
                                            while($rowEmpty = mysqli_fetch_assoc($emptyquery)){
                                            $rowE = $rowEmpty['empty'];
                                            }
                                        }else{
                                            $rowE = 0;
                                        }
                                ?>
                            <p>Out of Stock</p>
                            <h2><?php echo $rowE?></h2>
                        </div>
                    </div>
                    <div class="statusCard total">
                        <div>
                        <?php $totalIng = "Select count(ingName) as total from ingredients";
                                        $totalquery = mysqli_query($connection, $totalIng);
                                        if(mysqli_num_rows($totalquery)>0){
                                            while($rowTotal = mysqli_fetch_assoc($totalquery)){
                                            $rowT = $rowTotal['total'];
                                            }
                                        }else{
                                            $rowT = 0;
                                        }
                                ?>
                            <p>Total Number of Ingredients</p>
                            <h2><?php echo $rowT?></h2>
                        </div>
                    </div>
                </div>
            </div>
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
                        <option value="price">Cost</option>
                        <option value="status">Status</option>
                        <option value="date">Date</option>
                    </select>
                </div>
            </div>
            <div class="ingredientsList">
                <table id="tableTitle">
                    <thead>
                        <tr>
                            <th width="20%">Ingredient Name</th>
                            <th width="15%">Quantity</th>
                            <th width="10%">Cost</th>
                            <th width="15%">Cost/Unit</th>
                            <th width="10%">Status</th>
                            <th width="15%">Date Listed</th>
                            <th width="15%">Date Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $showingredients = "SELECT * FROM ingredients";
                        $showingredients_query = mysqli_query($connection, $showingredients);
                        while($row = mysqli_fetch_assoc($showingredients_query)){
                            $row['ingQuantity'];
                            $quantity = $row['ingQuantity'];
                            $row['ingUnit'];
                            $unit = $row['ingUnit'];
                            $cost;
                            $text;
                                if($quantity==0){
                                    $cost = 0;
                                    $level = "<td width='10%' id='highLight' style='background:black; color:white'>EMPTY</td>";
                                    $text = $unit;
                                }else{
                                    if($quantity>0 && $quantity<=10){
                                        $level = "<td width='10%' id='highLight' style='background:salmon'>LOW</td>";                             
                                    }
                                    if($quantity>10 && $quantity<=50){
                                        $level ="<td width='10%' id='highLight' style='background:lightgreen'>AVERAGE</td>";
                                    }
                                    if($quantity>50){
                                        $level ="<td width='10%' id='highLight' style='background:skyblue'>HIGH</td>";
                                    }
                                    $cost=$row['ingCostperUnit'];
                                    
                                    if($quantity!=1){
                                        $text = $unit."s";
                                    }else{
                                        $text = $unit;
                                    }
                                }
                    ?>
                    
                        <tr>
                            <td width="20%" id="ingNameCont"><?php echo $row['ingName'] ?></td>
                            <td width="15%"><?php echo $quantity?> <?php echo $text ?></td>
                            <td style ="display:none"><?php echo $row['ingCost'] ?></td>
                            <td width="10%">₱ <?php echo number_format($row['ingCost'], 2) ?></td>
                            <td width="15%">₱ <?php echo number_format($cost,2) ?>/<?php echo $row['ingUnit'] ?></td>
                            <?php echo $level ?>
                            <td width="15%"><?php echo date('F d, Y', strtotime($row['ingListed'])) ?></td>
                            <td width="15%"><?php echo date('F d, Y', strtotime($row['ingUpdated'])) ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('ingNameNew').addEventListener('keyup',enableAdd);
        document.getElementById('ingNewQuan').addEventListener('keyup',enableAdd);
        document.getElementById('ingNewPrice').addEventListener('keyup',enableAdd); 
        document.getElementById('ingredientName').addEventListener('keyup',enableRestock);
        document.getElementById('resVol').addEventListener('keyup',enableRestock);
        document.getElementById('resPrice').addEventListener('keyup',enableRestock);
        document.getElementById('viewHistory').addEventListener('click',viewHistory);
        document.getElementById('viewSummary').addEventListener('click',viewSummary);
        document.getElementById('closeModal').addEventListener('click',closeMod);
    </script>   
</section>
<script>
    document.getElementById('ingNameNew').addEventListener('keyup',enableAdd);
    document.getElementById('ingNewQuan').addEventListener('keyup',enableAdd);
    document.getElementById('ingNewPrice').addEventListener('keyup',enableAdd); 
    document.getElementById('ingredientName').addEventListener('keyup',enableRestock);
    document.getElementById('resVol').addEventListener('keyup',enableRestock);
    document.getElementById('resPrice').addEventListener('keyup',enableRestock);
    document.getElementById('viewHistory').addEventListener('click',viewHistory);
    document.getElementById('viewSummary').addEventListener('click',viewSummary);
    document.getElementById('closeModal').addEventListener('click',closeMod);
</script>

<script>
  const name = [
    <?php
  $query = "select * from ingredients";
  $myQuery = mysqli_query($connection,$query);
  while($row = mysqli_fetch_assoc($myQuery)){
?>
  {name: '<?php echo $row['ingName'] ?>', unit:'<?php echo $row['ingUnit'] ?>'},
  <?php }?>
  {name: '',unit:''}
];

  const searchInput = document.querySelector('#ingredientName');
  const suggestionsPanel = document.querySelector('.suggestions');
  const invisiblePanel = document.querySelector('.invi');
  searchInput.addEventListener('keyup', function() {
    const input = searchInput.value;
    suggestionsPanel.innerHTML = '';
    invisiblePanel.innerHTML = '';
    const suggestions = name.filter(function(ingName) {
      return ingName.name.toLowerCase().startsWith(input);
    });
    suggestions.forEach(function(suggested) {
      const div = document.createElement('div');
      const div2 = document.createElement('div');
      div.className = "suggest";
      div2.className = "invisible";
      div.innerHTML = suggested.name;
      div2.innerHTML = suggested.unit;
      suggestionsPanel.appendChild(div);
      invisiblePanel.appendChild(div2);
    });
    if (input === '') {
      suggestionsPanel.innerHTML = '';  
      invisiblePanel.innerHTML = '';  
      document.getElementById('yunit').innerHTML = '';
    }   
    let suggest = document.getElementsByClassName('suggest');
    let units = document.getElementsByClassName('invisible');
    for(let i = 0; i< suggest.length; i++){
      suggest[i].onclick = function(){
        document.getElementById('ingredientName').value = suggest[i].innerHTML;
        document.getElementById('yunit').innerHTML = units[i].innerHTML+'/s';
        suggestionsPanel.innerHTML = '';
        invisiblePanel.innerHTML = '';  
      }
       document.getElementById('yunit').innerHTML = units[i].innerHTML+'/s';
    }
    searchInput.addEventListener('focus',clearInput,true);
    function clearInput(){
        searchInput.value = '';
    }
  });
</script>
