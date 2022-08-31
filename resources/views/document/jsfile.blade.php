<script>
    var i = 1;
    console.log(i)
    $('#ajouter-produit').click(() => {
        $('#tbody-produit').append(`
            <tr id='ligne-${i}'>
                <td>
                    <a href="#${i}" id="supprimer-${i}" class="action-icon text-danger supprimer-ligne" title="Supprimer la ligne du produit" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-trash-can"></i></a>
                </td>
                <td>
                    <input type="text" class="form-control" id="objet-produit-${i}" name="objet-produit-${i}" value="">
                    <input hidden type="text" class="form-control produit-id" id="objet-produit-${i}" name="index-produit-${i}" value="${i}">
                </td>
                <td>
                    <input type="number" class="form-control qt-produit" id="qt-produit-${i}" name="qt-produit-${i}" value="1">
                </td>
                <td>
                    <input type="number" class="form-control qt-produit" id="mt-produit-${i}" name="mt-produit-${i}" value="">
                </td>
                <td>
                    <input id="mttotal-produit-${i}" type="number" class="form-control qt-packages" value="" disabled>
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
    
    $(() => {
        setTimeout(() => {
            updatePrixTotalProduit();
            supprimerLigne();
        }, 1500);
    });
</script>