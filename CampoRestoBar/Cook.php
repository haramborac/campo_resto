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
       
});
</script>
<section class="campoCook" id="campoCook">
    <div class="campoCookContent">
        <div class="cookDetails cookAddIngredient" ><!-- style="display: none;" --> 
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
                      $show_ingredients_used = mysqli_query($connection, "SELECT * FROM ingredients_used");
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
                              $ingList = "<td width='20%'> $lQuantity $ingUnit/s<input type='hidden' name='ingListQuantity[]' value='$lQuantity $ingUnit'></td>";
                            }
                    ?>
                    <tr>
                      <td width="30%"><?php echo $ingredient_used ?><input type="hidden" name="ingListName[]" value="<?php echo $ingredient_used ?>"></td>
                      <?php echo $ingList ?>
                      <td width="30%">₱ <?php echo number_format($cost_per_unit,2).$unit['ingUnit']?><input type="hidden" name="ingListCost[]" value="<?php echo $cost_per_unit.$unit['ingUnit']?>"></td>
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
                <h2>100 Kinds</h2>
              </div>
              <div>
                <p>Ingredient Total Amount</p>
                <h2>₱ 10000.00</h2>
              </div>
            </div>
            <div class="addSumBtn">
              <button id="openAddedhis" onclick="openAddedhis()">HISTORY</button>
              <button type="submit" id="cookIngredientsBtn" name="cookIngredients" form="ingredientListForm">COOK</button>
            </div>
            <?php cookList() ?>
          </div>
        </div>
        <!-- <div class="cookDetails cookAddHistory">
          <h1>HISTORY</h1>
        </div> -->
        <div class="cookDetails cookFoodDetails">
            <h1>LET'S COOK!!</h1>
            <div class="currentIngCook">
              <div class="invOrderedIng">
                <h3>Current Ingredients</h3>
                <p>Use current Ingredients before requesting new set of Ingredients</p>
                <h4>Ingredients Summary</h4>
                <div class="ingSummaryCook" id="ingSummaryCook">
                  <?php 
                    $show_current_ingredients = mysqli_query($connection, "SELECT * FROM current_ingredients");
                    while($curIng = mysqli_fetch_assoc($show_current_ingredients)){
                  ?>
                  <p><?php echo $curIng['name'].' - '. $curIng['quantity'] ?>/s</p>
                  <?php } ?>
                  <!-- <p>Salt Papi - 2Kgs</p>
                  <p>Salt Papi - 2Kgs</p>
                  <p>Salt Papi - 2Kgs</p>
                  <p>Salt Papi - 2Kgs</p> -->
                </div>
                <div class="invCurrentCost">
                  <p>Total Ingredients Base Cost</p>
                  <h4>₱ 10000.00</h4>
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
                        <span>₱</span><input type="number" id="bcostMeal" name="bcostMeal">
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
                            $show_cooked_meals = mysqli_query($connection, "SELECT * FROM cooked_meals");
                            while($meal = mysqli_fetch_assoc($show_cooked_meals)){
                          ?>
                          <tr>
                            <td width="30%"><?php echo $meal['name'] ?><input type="hidden" name="cookMealName[]" value="<?php echo $meal['name'] ?>"></td>
                            <td width="30%"><?php echo $meal['serving'] ?><input type="hidden" name="cookMealServing[]" value="<?php echo $meal['serving'] ?>"></td>
                            <td width="40%">₱ <?php echo $meal['base_cost'] ?><input type="hidden" name="cookMealCost[]" value=" <?php echo $meal['base_cost'] ?>"></td><!-- numberformat -->
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </form>
                  </div>
                  <div class="summaryTotalMeal">
                    <div>
                      <p>Total Meal Cooked</p>
                      <h4>1 Meal</h4>
                    </div>
                    <div>
                      <p>Total Meal Base Cost</p>
                      <h4>₱ 1000.00</h4>
                    </div>
                  </div>
                  <div class="summaryServe">
                    <button type="submit" id="addMealBtn" name="AddMeal" form="cookMealForm" disabled>Add Meal</button>
                  </div>
                  <?php 
                    if(isset($_POST['AddMeal'])){
                      $cookMealName = $_POST['cookMealName'];
                      $cookMealServing = $_POST['cookMealServing'];
                      $cookMealCost = $_POST['cookMealCost'];

                      if(empty($cookMealName)||empty($cookMealName)||empty($cookMealName)){
                        echo "asd";
                      }else{
                        foreach($cookMealName as $key => $n ) {
                          $addMeal = "INSERT INTO served_meals (name, serving, base_cost) VALUES ('$n', $cookMealServing[$key], $cookMealCost[$key] )";
                          mysqli_query($connection, $addMeal);
                          mysqli_query($connection, " DELETE FROM cooked_meals WHERE name = '$n' ");
                          header('location:Cook.php');
                       }
                      }
                    }
                  ?>
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
            <div class="mealServeContent">
              <table>
                <thead>
                  <tr>
                    <th width="40%">Meal</th>
                    <th width="20%">Serving</th>
                    <th width="40%">Base Cost/Serving</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $show_serving_meals = mysqli_query($connection, "SELECT * FROM served_meals");
                    while($serving = mysqli_fetch_assoc($show_serving_meals)){
                  ?>
                  <tr>
                    <td width="40%"><?php echo $serving['name'] ?></td>
                    <td width="20%"><?php echo $serving['serving'] ?></td>
                    <td width="40%">₱ <?php echo $serving['base_cost'] ?></td><!-- numberformat -->
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
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
