function enableAddBtn(){
    
    let enableAdd = document.getElementById('addIngredientBtn');
    let lenName = document.getElementById('ingName').value;
    let lenQuantity = document.getElementById('ingQuantity').value;
        if(lenName.length>0 && lenQuantity>0){
            enableAdd.disabled = false;
        }else{
            enableAdd.disabled = true;
        }
}
function enableCookBtn(){
    let enableCook = document.getElementById('cookIngredientsBtn');
    let table = document.getElementById('ingredientListTable');
        if(table.rows.length>0){
            enableCook.disabled = false;
        }else{
            enableCook.disabled = true;
        }
}
function disableAdd(){
    let disableAdd = document.getElementById('ingSummaryCook');
    let table = disableAdd.getElementsByTagName('p');
    let lenName = document.getElementById('ingName');
    let lenQuantity = document.getElementById('ingQuantity');
    let nameMeal = document.getElementById('nameMeal');
    let servingMeal = document.getElementById('servingMeal');
    let bcostMeal = document.getElementById('bcostMeal');
    let cookMeal = document.getElementById('cookMealBtn');

    if(table.length>0){
        lenName.disabled = true;
        lenQuantity.disabled = true;
        nameMeal.disabled = false;
        servingMeal.disabled = false;
        bcostMeal.disabled = false;

        if(nameMeal.value.length>0 && servingMeal.value>0 && bcostMeal.value>0){
            cookMeal.disabled = false;
        }else{
            cookMeal.disabled = true;
        }
    }else{
        lenName.disabled = false;
        lenQuantity.disabled = false;
        nameMeal.disabled = true;
        servingMeal.disabled = true;
        bcostMeal.disabled = true;
        cookMeal.disabled = true;
    }
}
function enableAdd(){
    let table = document.querySelector('#cmFormBody');
    let button = document.getElementById('addMealBtn');
        if(table.rows.length>0){
            button.disabled = false;
        }else{
            button.disabled = true;
        }
}

function sumIng(){

    let table, tr, td, textValue, intValue, sum = 0;
        table = document.getElementById('ingredientListTable');
        tr = table.getElementsByTagName('tr');

        for(let i = 0; i< tr.length; i++){
            td = tr[i].getElementsByTagName('td')[3];
                if(td){
                    textValue = td.textContent || td.innerHTML;
                    intValue = parseFloat(textValue);
                    sum += intValue;
                }
        }
        document.getElementById('ita').innerHTML = sum.toLocaleString('en-US',{style: 'currency', currency:'PHP'})
}

function openAddedhis() {
    var addedHisModal    = document.getElementById("ckAddHistory");
    var addedIngModal    = document.getElementById("ckAddIngredient");
    
    if(addedHisModal.style.display = "none"){
        addedHisModal.style.display = "block";
        addedIngModal.style.display = "none";
    }
}
function closeCKHis() {
    var addedHisModal    = document.getElementById("ckAddHistory");
    var addedIngModal    = document.getElementById("ckAddIngredient");
    
    if(addedHisModal.style.display = "block"){
        addedHisModal.style.display = "none";
        addedIngModal.style.display = "block";
    }
}