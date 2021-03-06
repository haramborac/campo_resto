<?php include 'header.php'; ?>
<style>
    <?php include 'CSS/cook.css';?>
</style>
<script>
  <?php include 'JS/cook.js'?>
</script>
<script>
  document.addEventListener('DOMContentLoaded',function (){
    enableCookBtn();
    disableAdd();
    enableAdd();
    enableCashier();
    sumIng();
  });
</script>
<section class="campoCook" id="campoCook">
    <div class="campoCookContent">
        <div class="cookDetails cookAddIngredient" id="ckAddIngredient">
          <h1>ADD INGREDIENTS HERE</h1>
          <div class="addIngredient">
            <div class="errorMessage  addIngredientEr">
              <?php 
                if(isset($_GET['stock'])){
                  echo "<p style='position:absolute; color: red; font-style: italic;'>No More Stock</p>";
                }
              ?>
              <?php addIngredient() ?>
            </div>
            <h3>Add Ingredients</h3>
            <form action="" method="post">
              <div class="addContent">
                  <div style="width: 45%;"><input type="text" id="ingName" name="ingredient" placeholder="Ingredient" autocomplete="off"></div>
                  <div style="width: 27%;"><input type="number" id="ingQuantity" name="quantity" placeholder="Qnty" autocomplete="off"> <p id="yunit"></p></div>
                  <div style="width: 25%;"><button type="submit" id="addIngredientBtn" name="addIngredient" disabled>Add</button></div>
              </div>
            </form>
            <div class="suggestions">
              </div>
            <div class="invi" style ="display:none">
              </div>
            <div class="ingAddedList">
              <h3>Ingredient List</h3>
              <form action="" id="ingredientListForm" method="post">
                <table >
                  <thead>
                    <tr>
                    </tr>
                  </thead>
                  <tbody id="ingredientListTable">
                    <?php 
                      $show_ingredients_used = mysqli_query($connection, "SELECT * FROM ingredients_used WHERE status = 'added' ");
                      while($list = mysqli_fetch_assoc($show_ingredients_used)){
                        $i = 0;
                        $ingredient_used = $list['ingredient_used'];
                        $lQuantity = $list['quantity'];
                        $show_unit = mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$ingredient_used' ");
                        while($unit = mysqli_fetch_assoc($show_unit)){
                          $ingUnit = $unit['ingUnit'];
                          $costperunit_query = mysqli_query($connection, "SELECT * FROM ingredients WHERE ingName = '$ingredient_used'");
                          while($costperunit = mysqli_fetch_assoc($costperunit_query)){
                            $cost_per_unit = $costperunit['ingCostperUnit']*$list['quantity'];
                            if($lQuantity==1){
                              $ingList = "<td width='20%'> $lQuantity $ingUnit<input type='hidden' name='ingListQuantity[]' value='$lQuantity $ingUnit'></td>";
                            }else{
                              $ingList = "<td width='20%'> $lQuantity $ingUnit"."s<input type='hidden' name='ingListQuantity[]' value='$lQuantity $ingUnit'></td>";
                            }
                    ?>
                    <tr>
                      
                      <td width="30%"><?php echo $ingredient_used ?><input type="hidden" name="ingListName[]" value="<?php echo $ingredient_used ?>"></td>
                      <?php echo $ingList ?>
                      <td width="30%">??? <?php echo number_format($cost_per_unit,2)?><input type="hidden" name="ingListCost[]" value="<?php echo $cost_per_unit?>"></td>
                      <td id="tdCost" style="display: none"><?php echo $cost_per_unit ?><input type="hidden" name="ingListUnit[]" value="<?php echo $ingUnit?>"></td>
                      <td width="10%">
                        <a href="Functions.php?add=<?php echo $ingredient_used ?>"><button type="button"><i class="fas fa-plus"></i></button></a>
                      </td>
                      <td width="10%">
                        <a href="Functions.php?subtract=<?php echo $ingredient_used ?>"><button type="button"><i class="fas fa-minus"></i></button></a>
                      </td>
                    </tr>
                    <?php }}} ?>  
                  </tbody>
                </table>
              </form>
            </div>
            <div class="addIngSummary">
              <div>
                <p>Total Ingredients</p>
                <?php 
                  $total_ingredients_used = mysqli_query($connection, "SELECT COUNT(ingredient_used) AS ingredientsUsed FROM ingredients_used WHERE status = 'added' ");
                  if(mysqli_num_rows($total_ingredients_used)>0){
                    while($total_ing = mysqli_fetch_assoc($total_ingredients_used)){
                      $total_ingredients = $total_ing['ingredientsUsed'];
                    }
                  }else{
                    $total_ingredients = 0;
                  }
                ?>
                <h2><?php echo $total_ingredients ?> Kinds</h2>
              </div>
              <div>
                <p>Ingredient Total Amount</p>
                <h2 id="ita"></h2>
              </div>
            </div>
            <div class="addSumBtn">
              <button id="openAddedhis" onclick="openAddedhis()">HISTORY</button>
              <button type="submit" id="cookIngredientsBtn" name="cookIngredients" form="ingredientListForm">COOK</button>
            </div>
            <?php cookList() ?>
          </div>
        </div>
        <div class="cookDetails cookAddHistory" id="ckAddHistory" style="display: none;">
          <span onclick="closeCKHis()"><i class="fa fa-times"></i></span>
          <h1>HISTORY</h1>
          <p>Here you can see all the ingredients added on the last meal/s the chef was created or cooked.</p>
          <div class="ingredientHistory">
            <table>
              <thead>
                <tr>
                  <th width="30%">Ingredient</th>
                  <th width="15%">Qnty</th>
                  <th width="25%">Cost</th>
                  <th width="30%">Date Used</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $show_ingredient_history = mysqli_query($connection, "SELECT * FROM ingredients_used WHERE status IN ('cooked', 'used') ");
                  while($inghistory = mysqli_fetch_assoc($show_ingredient_history)){
                ?>
                <tr>
                  <td width="30%"><?php echo $inghistory['ingredient_used'] ?></td>
                  <td width="15%"><?php echo $inghistory['quantity'].$inghistory['unit'] ?></td>
                  <td width="25%">???<?php echo number_format($inghistory['cost'], 2) ?></td>
                  <td width="30%"><?php echo date('F d, Y', strtotime($inghistory['date_added']))?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="cookDetails cookFoodDetails">
            <h1>LET'S COOK!!</h1>
            <div class="currentIngCook">
              <div class="invOrderedIng">
                <h3>Current Ingredients</h3>
                <p>Use current Ingredients before requesting new set of Ingredients</p>
                <h4>Ingredients Summary</h4>
                <div class="ingSummaryCook" id="ingSummaryCook">
                  <?php 
                    $show_current_ingredients = mysqli_query($connection,"SELECT * FROM ingredients_used WHERE status = 'cooked' ");
                    while($curIng = mysqli_fetch_assoc($show_current_ingredients)){
                  ?>
                  <p><?php echo $curIng['ingredient_used'].' - '. $curIng['quantity'].$curIng['unit'] ?>/s</p>
                  <?php } ?>
                  <!-- <p>Salt Papi - 2Kgs</p>
                  <p>Salt Papi - 2Kgs</p>
                  <p>Salt Papi - 2Kgs</p>
                  <p>Salt Papi - 2Kgs</p> -->
                </div>
                <div class="invCurrentCost">
                  <p>Total Ingredients Base Cost (TIBC)</p>
                  <?php 
                    $ingredients_sum = mysqli_query($connection, "SELECT SUM(cost) AS ingredientsBaseCost FROM ingredients_used WHERE status = 'cooked' ");
                    if(mysqli_num_rows($ingredients_sum)>0){
                      while($ing_cost = mysqli_fetch_assoc($ingredients_sum)){
                        $ingredient_cost = $ing_cost['ingredientsBaseCost'];
                      }
                    }else{
                      $ingredient_cost = 0;
                    } 
                  ?>
                  <h4>??? <?php echo number_format($ingredient_cost, 2) ?></h4>
                </div>
              </div>
              <div class="orderIngCook">
                <h3>Cook Meal</h3>
                <p>In this area you can add multiple meal as long as ingredients will fit and used in the meals added. </p>
                <h4>Add Meal</h4>
                <div class="addMealDetail">
                  <?php cookMeal() ?>
                  <form action="" method="post">
                    <div class="mealDetails">
                      <div>
                        <label for="nameMeal">Name of Meal</label>
                        <input type="text" id="nameMeal" name="nameMeal">
                      </div>
                      <div>
                        <label for="servingMeal">Servings</label>
                        <input type="number" id="servingMeal" name="servingMeal">
                        <label for="bcostMeal">Base Cost</label>
                        <span>???</span><input type="number" id="bcostMeal" name="bcostMeal">
                      </div>
                      <button type="submit" id="cookMealBtn" name="cookMeal">Cook Meal</button>
                    </div>
                  </form>
                  <div class="menuMeals">
                    <form action="" id="cookMealForm" method="post">
                      <table>
                        <thead>
                          <tr>
                            <th width="30%">Meal</th>
                            <th width="30%">Serving</th>
                            <th width="40%">Base Cost</th>
                          </tr>
                        </thead>
                        <tbody id="cmFormBody">
                          <?php 
                            $show_cooked_meals = mysqli_query($connection, "SELECT * FROM meals WHERE status = 'cooked' ");
                            while($meal = mysqli_fetch_assoc($show_cooked_meals)){
                          ?>
                          <tr>
                            <td width="30%"><?php echo $meal['name'] ?><input type="hidden" name="cookMealName[]" value="<?php echo $meal['name'] ?>"></td>
                            <td width="30%"><?php echo $meal['serving'] ?><input type="hidden" name="cookMealServing[]" value="<?php echo $meal['serving'] ?>"></td>
                            <td width="40%">??? <?php echo number_format($meal['base_cost'], 2) ?><input type="hidden" name="cookMealCost[]" value=" <?php echo $meal['base_cost'] ?>"></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </form>
                  </div>
                  <div class="summaryTotalMeal">
                    <div>
                      <p>Total Meal Cooked</p>
                      <?php
                        $countcookedmeals = mysqli_query($connection, "SELECT COUNT(name) AS cookedMeals FROM meals WHERE status = 'cooked' ");
                        if(mysqli_num_rows($countcookedmeals)>0){
                          while($cooked = mysqli_fetch_assoc($countcookedmeals)){
                            $total_meals_cooked = $cooked['cookedMeals'];
                          }
                        }else{
                          $total_meals_cooked = 0;
                        }
                      ?>
                      <h4><?php echo $total_meals_cooked ?> Meal</h4>
                    </div>
                    <div>
                      <p>Total Meal Base Cost (TMBC)</p>
                      <?php 
                        $total_meal_cost = mysqli_query($connection, "SELECT SUM(base_cost) AS mealTotalBaseCost FROM meals WHERE status = 'cooked'");
                        if(mysqli_num_rows($total_meal_cost)>0){
                          while($meal_cost = mysqli_fetch_assoc($total_meal_cost)){
                            $cooked_meal_cost = $meal_cost['mealTotalBaseCost'];
                          }
                        }else{
                          $cooked_meal_cost = 0;
                        } 
                      ?>
                      <h4>??? <?php echo number_format($cooked_meal_cost, 2) ?></h4>
                    </div>
                  </div>
                  <div class="summaryServe">
                    <span>
                      <p>TIBC - TMBC</p>
                      <p>Total Cost of Unused Ingredients</p>
                      <h3>= ???<?php echo  number_format($ingredient_cost - $cooked_meal_cost,2)?></h3>
                    </span>
                    <button type="submit" id="addMealBtn" name="AddMeal" form="cookMealForm" disabled>Add Meal</button>
                  </div>
                  <?php addMeal() ?>
                </div>
              </div>
            </div>
        </div>
        <div class="cookDetails cookServeToCustomer">
          <h1>SERVE HERE</h1>
          <div class="servingContainer">
            <h3>Available Meals</h3>
            <p>Here you can view what is the available meal prepared.</p>
          </div>
          <form action="" method="post">
            <div class="mealServeContent">
              <table>
                <thead>
                  <tr>
                    <th width="40%">Meal</th>
                    <th width="20%">Serving</th>
                    <th width="40%">Base Cost/Serving</th>
                  </tr>
                </thead>
                <tbody id="serveBody">
                  <?php 
                    $show_serving_meals = mysqli_query($connection, "SELECT * FROM meals where status = 'available'");
                    while($serving = mysqli_fetch_assoc($show_serving_meals)){
                      $servingS = 0;
                      $sum = $serving['base_cost'];
                      $servingS = $servingS + $sum;
                  ?>
                  <tr>
                    <td width="40%"><?php echo $serving['name'] ?><input type="hidden" name="availMealName[]" value="<?php echo $serving['name'] ?>"></td>
                    <td width="20%"><?php echo $serving['serving'] ?><input type="hidden" name="availMealServing[]" value="<?php echo $serving['serving'] ?>"></td>
                    <td width="40%">??? <?php echo number_format($serving['base_cost'], 2) ?><input type="hidden" name="availMealCost[]" value="<?php echo $serving['base_cost'] ?>"></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table> 
              <div class="serveMIDiff">
                <span>
                  <p>Total Meals</p>
                  <?php 
                    $show_serving_meals = mysqli_query($connection, "SELECT COUNT(name) AS tCount FROM meals where status = 'available'");
                    if(mysqli_num_rows($show_serving_meals)>0){
                      while($serving = mysqli_fetch_assoc($show_serving_meals)){
                        $count = $serving['tCount'];
                      }
                    }else{
                        $count = 0;
                    }
                  ?>
                  <h1><?php echo $count ?></h1>
                </span>
                <span>
                  <p>Meal Base Cost</p>
                  <?php 
                    $show_serving_cost = mysqli_query($connection, "SELECT SUM(base_cost) AS tSum FROM meals where status = 'available'");
                    if(mysqli_num_rows($show_serving_cost)>0){
                      while($serving = mysqli_fetch_assoc($show_serving_cost)){
                        $sum2 = $serving['tSum'];
                      }
                    }else{
                        $sum2 = 0;
                    }
                  ?>
                  <h1>??? <?php echo number_format($sum2,2)?></h1>
                </span>
              </div>
              <div class="serveToCashier">
                <button type="submit" name="serveMeal" id="serveMeal">To Cashier</button>
              </div>
            </div>
            <?php serveMeal() ?>
          </form>
        </div> 
    </div>
</section>

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

  const searchInput = document.querySelector('#ingName');
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
        document.getElementById('ingName').value = suggest[i].innerHTML;
        document.getElementById('yunit').innerHTML = units[i].innerHTML+'/s';
        suggestionsPanel.innerHTML = '';
        invisiblePanel.innerHTML = '';  
      }
       document.getElementById('yunit').innerHTML = units[i].innerHTML+'/s';
    }
  });
  // searchInput.addEventListener('focus',clearInput,true);
  // function clearInput(){
  //     searchInput.value = '';
  // }
  // searchInput.addEventListener('blur',clearSuggestion,true);
  //   function clearSuggestion(){
  //       suggestionsPanel.innerHTML = '';  
  //       invisiblePanel.innerHTML = '';  
  //   }
    document.getElementById('addIngredientBtn').addEventListener('click',enableCookBtn);
    document.getElementById('ingName').addEventListener('change',enableAddBtn);
    document.getElementById('ingQuantity').addEventListener('change',enableAddBtn);
    document.getElementById('ingQuantity').addEventListener('keyup',enableAddBtn);
    document.getElementById('nameMeal').addEventListener('keyup',disableAdd);
    document.getElementById('servingMeal').addEventListener('keyup',disableAdd);
    document.getElementById('bcostMeal').addEventListener('keyup',disableAdd);
    // document.getElementById('cookMealBtn').addEventListener('click',enableAdd);


</script>
