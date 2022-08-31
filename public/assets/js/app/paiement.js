$('#date_paiement').flatpickr({
    defaultDate: 'today'
});

function montantPayerChange(e) {
    var montant_payer = Number.parseInt($("#montant_payer_value").val())
    var reste_a_payer_value = Number.parseInt($("#reste_a_payer_value").val())
    if(montant_payer > reste_a_payer_value) {
        $("#montant_payer_message").text("Le montant à payer ne doit pas être supérieur au reste à payer")
        $("#btn-enregistrer").attr("disabled", true)
    } else {
        $("#montant_payer_message").text("")
        $("#btn-enregistrer").attr("disabled", false)
    }
}

$("#montant_payer_value").keyup(e => montantPayerChange(e))
$("#montant_payer_value").change(e => montantPayerChange(e))