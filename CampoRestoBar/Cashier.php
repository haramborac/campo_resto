<?php include 'header.php'; ?>
<script>
    <?php include 'JS/cashier.js';?>
</script>
<style>
    <?php include 'CSS/cashier.css';?>
</style>
<section>
    <div class="cashierContent">
        <div class="welcome">
            <h1>Orders Available  </h1>
        </div>
        <div class="cashierContainer">
            <!-- <div class="tabsForCash mealAvailable">
                <h3>Available Meals & Beverages</h3>

                <div class="servedMeal">

                </div>
            </div> -->
            <div id="tabOrder" class="tabsForCash orderMeal">
                <h1></h1>
                <div class="searchMeal">
                    <span><i class="fas fa-search"></i></span><input type="text" id="searchAvMeal" name="searchAvMeal" placeholder="Search Meal..." onkeyup= "searchFilter();">
                </div>
                <div class="sOverflow">
                    <div class="grid-container">
                        <?php 
                                $show_serving_meals = mysqli_query($connection, "SELECT * FROM meals WHERE status = 'serving' ORDER BY name ASC ");
                                while($serve = mysqli_fetch_assoc($show_serving_meals)){
                            ?>
                                <div class="grid-item">                
                                    <div id="addName"><?php echo $serve['name'] ?></div>
                                    <!-- <div id="addServing"><?php echo $serve['serving'] ?></div> -->
                                    <div id="addCost">₱<?php echo number_format($serve['base_cost'],2) ?></div>
                                    <div id="addButton"><button>Add to Cart</button></div>
                                </div>    
                            <?php } ?>
                    </div>
                </div>
            </div>
            <div class="tabsForCash mealReserved">
                <div class="toCheckout">
                    HEHE
                </div>
            </div>
        </div>
    </div>
</section>
<script>

</script>
<script>
   onload = function () {
        const name = [
    <?php
        $query = "select * from meals";
        $myQuery = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($myQuery)){
        ?>
        {name: '<?php echo $row['name'] ?>', serving:'<?php echo $row['serving'] ?>', cost:'<?php echo $row['base_cost']?>'},
        <?php }?>
        {name: '',serving:'',cost:''}
        ]

        console.log(name.length);

        // EXTRACT VALUE FOR HTML HEADER. 
        // ('Book ID', 'Book Name', 'Category' and 'Price')
        var col = [];
        for (var i = 0; i < name.length; i++) {
            for (var key in name[i]) {
                if (col.indexOf(key) === -1) {
                    col.push(key);
                }
            }
        }

        // CREATE DYNAMIC TABLE.
        var table = document.getElementById("table");

        // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

        var tr = table.insertRow(-1);                   // TABLE ROW.

        for (var i = 0; i < col.length; i++) {
            var th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML = col[i];
            tr.appendChild(th);
        }

        // ADD JSON DATA TO THE TABLE AS ROWS.
        for (var i = 0; i < name.length; i++) {

            tr = table.insertRow(-1);

            for (var j = 0; j < col.length; j++) {
                var tabCell = tr.insertCell(-1);
                tabCell.innerHTML = name[i][col[j]];
                
            }
        }

        for(var i = 0; i<  col.length; i++){
            
            var btn = document.createElement("button");
            btn.textContent = "Add to Cart";
            table.appendChild(btn);
        }
    }
</script>