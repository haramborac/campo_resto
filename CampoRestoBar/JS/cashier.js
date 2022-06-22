function searchFilter() {  
    var input, filter, table, tr, td, i, txtValue, alert;
    input = document.getElementById("searchAvMeal");
    filter = input.value.toUpperCase();

    table = document.getElementById("tableAv");
    tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
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