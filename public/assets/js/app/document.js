function numStr(a, b) {
    a = '' + a;
    b = b || ' ';
    var c = '',
        d = 0;
    while (a.match(/^0[0-9]/)) {
        a = a.substr(1);
    }
    for (var i = a.length-1; i >= 0; i--) {
        c = (d != 0 && d % 3 == 0) ? a[i] + b + c : a[i] + c;
        d++;
    }
    return c;
}

function calMontantHt() {
    let packages = $('.packages-checkbox:checked')
    var id, qt, montant
    var total = 0
    $.each(packages, (k, v) => {
        id = v.value
        qt = Number.parseInt($('#qt-package-'+id).val()) || 0
        montant = Number.parseInt($('#mt-package-'+id).val())
        total += qt * montant
    })

    $.each($('.produit-id'), (k, v) => {
        id = v.value
        qt = $('#qt-produit-'+id).val() || 0
        montant = $('#mt-produit-'+id).val()
        total += qt * montant
    })

    if($('#frais_installation_checkbox').is(':checked')) {
        frais_installation = $('#frais_installation').val()
        if(frais_installation != undefined && frais_installation != null && frais_installation != "")
            total += Number.parseInt(frais_installation)
    }
    
    $('#montantht').val(numStr(total))

    if($('#tva-checkbox').is(':checked')) {
        $('#tva').val('')
        $('#montantttc').val(numStr(total))
      
    } else {
         // let tva = $('#tva').val()
         let montanttva = total * 18 / 100
         $('#tva').val(numStr(montanttva))
         total += montanttva
         $('#montantttc').val(numStr(total))
    }
}

function packageQtUpdate(e) {
    let id = e.currentTarget.id.split('-')[2]
    let qt = e.currentTarget.value
    let montant = $('#mt-package-'+id).val()
    $('#mttotal-package-'+id).html(numStr(qt * montant) + ' FCFA')
    calMontantHt()
    let document_package_id = $('#id-package-'+id).val()
    // ajaxUpadatePackage(document_package_id, qt, montant)
}

function packageMtUpdate(e) {
    let id = e.currentTarget.id.split('-')[2]
    let qt = $('#qt-package-'+id).val()
    let montant = $('#mt-package-'+id).val()
    $('#mttotal-package-'+id).html(numStr(qt * montant) + ' FCFA')
    calMontantHt()
    let document_package_id = $('#id-package-'+id).val()
    // ajaxUpadatePackage(document_package_id, qt, montant)
}

function ajaxUpadatePackage(id, quantite, prix_unitaire) {
    $.post($("#url_update_document_pacakge").val(), {
        id: id,
        quantite: quantite,
        prix_unitaire: prix_unitaire
    });
}

$('.qt-packages').keyup(e => {
    packageQtUpdate(e)
})
$('.qt-packages').change(e => {
    packageQtUpdate(e)
})

$('.mt-packages').keyup(e => {
    packageMtUpdate(e)
})
$('.mt-packages').change(e => {
    packageMtUpdate(e)
})

$('#tva-checkbox').click((e) => calMontantHt())
$('.packages-checkbox').click((e) => {
    let _id = e.currentTarget.id
    let id = _id.split('-')[1]
    qt = $('#qt-package-'+id).val() || 0
    if($('#'+_id).is(":checked")) {
        if(qt == 0) {
            qt = 1
            $('#qt-package-'+id).val(1)
        }
        
        let montant = $('#mt-package-'+id).val()
        $('#mttotal-package-'+id).html(numStr(qt * montant) + ' FCFA')
    }
    
    calMontantHt()
})
$('#tva').keyup(() => calMontantHt())
$('#frais_installation_checkbox').click(e => {
    if($('#frais_installation_checkbox').is(':checked')) {
        $('#frais_installation').attr('disabled', false)
        frais_installation = $('#frais_installation').val()
            if(frais_installation == null || frais_installation == undefined || frais_installation == "") {
                $('#frais_installation').val(100000)
            }
    } else {
        $('#frais_installation').attr('disabled', true)
    }

    calMontantHt()
})

// $('#date, #periode').flatpickr({
//     defaultDate: 'today',
// });

$('#date').flatpickr({
    defaultDate: 'today'
});
        
$("#dataTablePackage").DataTable({
    ordering:true,
    searching:false,
    paging:false,
    language:{
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
    },
})

var i = 1;

$('#ajouter-produit').click(() => {
    $('#tbody-produit').append(`
        <tr id='ligne-n${i}'>
            <td>
                <a href="#n${i}" id="supprimer-n${i}" class="action-icon text-danger supprimer-ligne" title="Supprimer la ligne du produit" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-trash-can"></i></a>
            </td>
            <td>
                <textarea type="text" class="form-control" id="objet-produit-n${i}" name="objet-produit-n${i}"></textarea>
                <input hidden type="text" class="form-control produit-id" id="objet-produit-n${i}" name="index-produit-n${i}" value="n${i}">
            </td>
            <td>
                <input type="number" class="form-control qt-produit" id="qt-produit-n${i}" name="qt-produit-n${i}" value="1">
            </td>
            <td>
                <input type="number" class="form-control qt-produit" id="mt-produit-n${i}" name="mt-produit-n${i}" value="">
            </td>
            <td>
                <input id="mttotal-produit-n${i}" type="number" class="form-control qt-packages" value="" disabled>
            </td>
        </tr>  
    `);

    i++;

    updatePrixTotalProduit();
    supprimerLigne();
});

function supprimerLigne() {
    $('.supprimer-ligne').click(e => {
        let id = e.currentTarget.id.split('-')[1];
        $('#ligne-'+id).remove();
        calMontantHt();
    })
}

function totalProduit(e) {
    let id = e.currentTarget.id.split('-')[2];
    let qt = Number.parseInt($('#qt-produit-'+id).val());
    let mt = Number.parseInt($('#mt-produit-'+id).val());
    $('#mttotal-produit-'+id).val(qt * mt);
}

function updatePrixTotalProduit() {
    console.log('click updatePrixTotalProduit')
    $('.qt-produit').change(e => {
        totalProduit(e);
        calMontantHt();
    })

    $('.qt-produit').keyup(e => {
        totalProduit(e);
        calMontantHt();
    })
}

$('#btn-add-client').click(e => {
    console.log('click')
    e.preventDefault()
    var $inputs = $('#create-client-form :input');

    var values = {};
    $inputs.each(function() {
        values[this.name] = $(this).val();
    });
    console.log(values)
    
    $("#btn-add-client").html(`
        <span class="spinner-grow spinner-grow-sm mr-1" role="status" aria-hidden="true"></span> 
        Enregistrement...                        
    `)
    $.post($("#client-add-url").val(), values)
        .done(data => {
            $("#btn-add-client").html('Enregistrer')
            $("#client_id").prepend(data.data)
            $("#btn-close-client").click()
            $.toast({
                text: `
                    <i class="mdi mdi-check-all mr-2"></i> Enregistrement effectué avec succès
                `,
                textColor: '#fff',
                bgColor: '#198754'
            })
            $("#option-client-vide").remove()
        })
        .fail(err => {
            $("#btn-add-client").html('Enregistrer')
            $.toast({
                text: `
                    <i class="mdi mdi-block-helper mr-2"></i> Echec de l'enregistrement
                `,
                textColor: '#fff',
                bgColor: '#dc3545'
            })
        })
})

$('#btn-add-package').click(e => {
    console.log('click')
    e.preventDefault()
    var $inputs = $('#create-form :input');

    var values = {};
    $inputs.each(function() {
        values[this.name] = $(this).val();
    });
    console.log(values)
    
    $("#btn-add-package").html(`
        <span class="spinner-grow spinner-grow-sm mr-1" role="status" aria-hidden="true"></span> 
        Enregistrement...                        
    `)
    $.post($("#package-add-url").val(), values)
        .done(data => {
            $("#btn-add-package").html('Enregistrer')
            $("#tbody-package").prepend(data.data)
            $("#btn-close-package").click()
            $.toast({
                text: `
                    <i class="mdi mdi-check-all mr-2"></i> Enregistrement effectué avec succès
                `,
                textColor: '#fff',
                bgColor: '#198754'
            })
            calMontantHt()
        })
        .fail(err => {
            $("#btn-add-package").html('Enregistrer')
            $.toast({
                text: `
                    <i class="mdi mdi-block-helper mr-2"></i> Echec de l'enregistrement
                `,
                textColor: '#fff',
                bgColor: '#dc3545'
            })
        })
})

$(() => {
    setTimeout(() => {
        updatePrixTotalProduit();
        supprimerLigne();
    }, 1500);
});


var client = document.getElementById('client_name').value
const nom_client = client.split(' ');
const code = document.getElementById('data-devis').getAttribute('data-devis')
const nombre_facture = document.getElementById('data-devis').getAttribute('data-client-facture')
console.log(nombre_facture)
var prefix="";
if(code<1000&&code<100&&code<10){prefix="000";}
if(code<1000&&code<100&&code>10){prefix="00";}
if(code<1000&&code>100&&code>10){prefix="0";}
var date = new Date();
var jour = date.getDate();
var mois = ("0" + (date.getMonth() + 1)).slice(-2);
var annee = date.getFullYear();
var year = annee.toString().substr(-2);
document.getElementById('numero').value='F'+prefix+nombre_facture+'/'+year+'/'+mois+'/'+jour+'/'+nom_client[0]+'/'+nombre_facture

// +annee+'/'+mois+'/'+jour+'/'+code;
