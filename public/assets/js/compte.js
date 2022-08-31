var editableTable = new BSTable("table2", {
    advanced: {
        columnLabel: 'Actions',
        buttonHTML: `<div class="btn-group pull-right">
        <button id="bEdit" type="button" class="btn btn-sm btn-default">
          <span class="fa fa-edit" > </span>
        </button>
        <button id="bDel" type="button" class="btn btn-sm btn-default">
          <span class="fa fa-trash" > </span>
        </button>
        <button id="bAcep" type="button" class="btn btn-sm btn-default" style="display:none;">
          <span class="fa fa-check-circle" > </span>
        </button>
        <button id="bCanc" type="button" class="btn btn-sm btn-default" style="display:none;">
          <span class="fa fa-times-circle" > </span>
        </button>
      </div>`
    },
    onEdit:function(e){
        enregistrement_des_donnees(e[0]);
    },
});
editableTable.refresh();


function enregistrement_des_donnees(e){
    var childrs = e.children;
    $("#nom").val(childrs[1].innerText)
    $("#code").val(childrs[2].innerText)
}


function recup(elt) {
    for (var i = 0; i <= elt.lenght; i++) {
        if (elt[i].innerText != null || elt[i].innerText != '') {
            return true;
        }
    }
    return false;
}




var eltButtun = document.getElementById("ajouter_client");
var eltType = document.getElementById('type_id');
eltType.addEventListener("change", function (e) {
    if (e.target.value == 3) {
        eltButtun.style.visibility = "visible";
    }
});
eltButtun.addEventListener("click", ajgroupe)

function ajgroupe() {
    var div_client = document.getElementById('div_client');
    div_client.style.visibility = "visible";
}
