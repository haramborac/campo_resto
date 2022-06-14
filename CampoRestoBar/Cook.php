<?php include 'header.php'; ?>
<style>
    <?php include 'CSS/cook.css';?>
</style>

<section class="campoCook" id="campoCook">
    <div class="campoCookContent">
        <div class="cookDetails cookAddIngredient">
            <h1>ADD INGREDIENTS HERE</h1>
            <div class="addIngredient">
                <h3>Add Ingredients</h3>
                <div class="addContent">
                    <div style="width: 45%;"><input type="text" id="ingName" placeholder="Ingredient" autocomplete="off"></div>
                    <div style="width: 27%;"><input type="number" id="ingQuantity" placeholder="Qnty" autocomplete="off"> <p id="yunit"></p></div>
                    <div style="width: 25%;"><button id="addIngredientBtn">Add</button></div>
                </div>
                <div class="suggestions">
                  </div>
                <div class="invi" style ="display:none">
                  </div>
                <div class="ingAddedList">
                    <h3>Ingredient List</h3>
                    <table>
                        <thead>
                            <tr>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="30%">Salt Papi</td>
                                <td width="20%">2 Kgs</td>
                                <td width="30%">₱ 10.00/Kgs</td>
                                <td width="10%">
                                    <button><i class="fas fa-plus"></i></button>
                                </td>
                                <td width="10%">
                                    <button><i class="fas fa-minus"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                    <button>HISTORY</button>
                    <button>COOK</button>
                </div>
            </div>
        </div>
        <div class="cookDetails cookFoodDetails">
            <h1>LET'S COOK!!</h1>
            <div class="currentIngCook">
              <div class="invOrderedIng">
                <h3>Current Ingredients</h3>
                <p>Use current Ingredients before requesting new set of Ingredients</p>
                <h4>Ingredients Summary</h4>
                <div class="ingSummaryCook">
                  <p>Salt Papi - 2Kgs</p>
                  <p>Salt Papi - 2Kgs</p>
                  <p>Salt Papi - 2Kgs</p>
                  <p>Salt Papi - 2Kgs</p>
                  <p>Salt Papi - 2Kgs</p>
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
                  <form action="">
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
                      <button>Cook Meal</button>
                    </div>
                  </form>
                  <div class="menuMeals">
                    <table>
                      <thead>
                        <tr>
                          <th width="30%">Meal</th>
                          <th width="30%">Serving</th>
                          <th width="40%">Base Cost</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td width="30%">Dinuguan</td>
                          <td width="30%">10</td>
                          <td width="40%">₱ 1000.00</td>
                        </tr>
                      </tbody>
                    </table>
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
                    <button>Add Meal</button>
                  </div>
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
                  <tr>
                    <td width="40%">Dinuguan</td>
                    <td width="20%">10</td>
                    <td width="40%">₱ 100.00</td>
                  </tr>
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
        console.log(suggest[i].innerHTML);
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
</script>
