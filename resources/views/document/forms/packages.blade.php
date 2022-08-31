<div class="form-row mt-3">
    <div class="col-12">
        <label for="objet">Packages</label>
        <!-- <input type="text" name="objet" id="objet" class="form-control"> -->
    </div>
</div>

@if(count($packages) > 0)
    <div class="card tableautable scroll p-2"> 
    <div class="col-md-12 mh-30" >
    <div class="content-panel mt">
    <div class="table-responsive">
    <table class="mt-3 mb-3 table table-sm" id="dataTablePackage">
        <thead>
            <tr>
            <th>#</th>
            <th scope="col">Désignation</th>
            <th scope="col">Quantité</th>
            <th scope="col">Montant</th>
            <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody id="tbody-package">
            @foreach($packages as $package)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input packages-checkbox" type="checkbox" value="{{$package->id}}" name="package-checkbox-{{$package->id}}" id="package-{{$package->id}}"
                            @if(isset($facture_packages) && in_array($package->id, $facture_packages)) checked @endif>
                            <input type="hidden" class="form-control qt-packages" id="id-package-{{$package->id}}" name="id-package-{{$package->id}}" value="{{ isset($facture_package_id) && isset($facture_package_id[$package->id]) ? $facture_package_id[$package->id] : '' }}">
                            <label class="form-check-label" for="customCheck1">&nbsp;</label>
                        </div>
                    </td>
                    <td>
                        <input class="form-control packages-nom" type="text" value="{{ isset($facture_package_nom) && isset($facture_package_nom[$package->id]) ? $facture_package_nom[$package->id] : $package->nom}}" name="package-nom-{{$package->id}}" id="package-nom-{{$package->id}}">
                    </td>
                    <td>
                        <input type="number" class="form-control qt-packages" id="qt-package-{{$package->id}}" name="qt-package-{{$package->id}}" value="{{ isset($facture_package_qt) && isset($facture_package_qt[$package->id]) ? $facture_package_qt[$package->id] : old('qt-package-$package->id') }}">
                        <!-- <input type="hidden" class="form-control qt-packages" id="mt-package-{{$package->id}}" value="{{$package->montant}}"> -->
                    </td>
                    <td id="prix-unitaire-package-{{$package->id}}"><input type="number" class="form-control mt-packages" id="mt-package-{{$package->id}}" name="mt-package-{{$package->id}}" value="{{isset($facture_package_mt) && isset($facture_package_mt[$package->id]) ? $facture_package_mt[$package->id] : $package->montant}}"><!--{{number_format($package->montant, 0, ',', ' ')}} FCFA--></td>
                    <td id="mttotal-package-{{$package->id}}">{{ isset($facture_package_qt) && isset($facture_package_qt[$package->id]) ? number_format($facture_package_qt[$package->id] * $facture_package_mt[$package->id], 0, ',', ' ') : 0}} FCFA</td>
                </tr>
            @endforeach    
        </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>
@else
    <p>Aucun packages trouvés</p>
@endif
<input type="hidden" id="url_update_document_pacakge" value="{{ route('document_package.update') }}">
<input type="hidden" id="document_id" value="{{ isset($item) && isset($item->id) ? $item->id : 0 }}">
