function searchFilter() {  
    var input, filter, table, tr, td, i, txtValue, alert;
    input = document.getElementById("searchIng");
    filter = input.value.toUpperCase();

    table = document.getElementById("tableTitle");
    tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
                alert = 0;
            }
            }       
        }
}

function sorting(){
    let sorting = document.getElementById('sortIngBy');
        switch(sorting.value){
            case "quantity": sortQuantity();
                break;
            case "unit": sortUnit();
                break;
            case "price": sortPrice();
                break;
            case "status": sortStatus();
                break;
            case "date": sortDate();
                break;
            default: sortName();
                break;
        }
}
function sortName(){
    console.log('sort by name');
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("tableTitle");
    switching = true;
    while(switching){
        switching = false;
        rows = table.rows;
        for(i=1;i<(rows.length -1);i++){
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("td")[0];
            y = rows[i+1].getElementsByTagName("td")[0];
            if(x.innerHTML.toLowerCase()> y.innerHTML.toLowerCase()){
                shouldSwitch = true;
                break;
            }
        }
        if(shouldSwitch){
            rows[i].parentNode.insertBefore(rows[i+1],rows[i]);
            switching = true;
        }
    }
}
function sortUnit(){
    console.log('sort by unit');
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("tableTitle");
    switching = true;
    while(switching){
        switching = false;
        rows = table.rows;
        for(i=1;i<(rows.length -1);i++){
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("td")[2];
            y = rows[i+1].getElementsByTagName("td")[2];
            if(x.innerHTML.toLowerCase()> y.innerHTML.toLowerCase()){
                shouldSwitch = true;
                break;
            }
        }
        if(shouldSwitch){
            rows[i].parentNode.insertBefore(rows[i+1],rows[i]);
            switching = true;
        }
    }
}
function sortPrice(){
    console.log('sort by price');
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("tableTitle");
    switching = true;

    while(switching){

        switching = false;
        rows = table.rows;

        for(i=1;i<(rows.length -1);i++){
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("td")[2];
            y = rows[i+1].getElementsByTagName("td")[2];

            if(parseFloat(x.innerHTML.match(/\d+/))< parseFloat(y.innerHTML.match(/\d+/))){
                shouldSwitch = true;
                break;
            }
        }
        if(shouldSwitch){
            rows[i].parentNode.insertBefore(rows[i+1],rows[i]);
            switching = true;
        }
    }
}
function sortStatus(){
    console.log('sort by status');
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("tableTitle");
    switching = true;

    while(switching){

        switching = false;
        rows = table.rows;

        for(i=1;i<(rows.length -1);i++){
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("td")[1];
            y = rows[i+1].getElementsByTagName("td")[1];

            if(parseInt(x.innerHTML)> parseInt(y.innerHTML)){
                shouldSwitch = true;
                break;
            }
        }
        if(shouldSwitch){
            rows[i].parentNode.insertBefore(rows[i+1],rows[i]);
            switching = true;
        }
    }
}
function sortDate(){
    console.log('sort by date');
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("tableTitle");
    switching = true;

    while(switching){

        switching = false;
        rows = table.rows;

        for(i=1;i<(rows.length -1);i++){
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("td")[7];
            y = rows[i+1].getElementsByTagName("td")[7];

            if(Date.parse(x.innerHTML)<Date.parse(y.innerHTML)){
                shouldSwitch = true;
                break;
            }
        }
        if(shouldSwitch){
            rows[i].parentNode.insertBefore(rows[i+1],rows[i]);
            switching = true;
        }
    }
}

function enableAdd(){
    let name = document.getElementById('ingNameNew').value;
    let quantity = document.getElementById('ingNewQuan').value;
    let price = document.getElementById('ingNewPrice').value;

        if(name.length>0&&quantity>0&&price>0){
            document.getElementById('addIngSubmit').removeAttribute('disabled');
         }
        else{
            document.getElementById('addIngSubmit').setAttribute('disabled',true);
        }
}
function enableRestock(){
    let quantity = document.getElementById('resVol').value;
    let price = document.getElementById('resPrice').value;
        if(quantity>0&&price>0){
            document.getElementById('restockIngSubmit').removeAttribute('disabled');
        }else{
            document.getElementById('restockIngSubmit').setAttribute('disabled',true);
        }
}

