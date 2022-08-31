
<div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Identification du client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('client.store') }}" method="post" id="create-client-form">
                    @csrf
                    @include('client.forms.form')
                    <div class="modal-footer">
                        <button id="btn-close-client" type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button id="btn-add-client" type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editType" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('client.update', ['client' => 1]) }}" method="post" id="formUpdate">
                    @csrf
                    @method("PUT")
                    @include('client.forms.edit_form')

                    <div id="numero-box"></div>
                    
                    <hr>
                    <h5 class="text-uppercase mt-0 mb-3 bg-light">Ajouter un numero de paiement</h5>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="date">Numero de paiement</label>
                                <input id="numero_paiement_ajout" type="text" name="numero_paiement_ajout" placeholder="+226 xx xx xx" class="form-control"/>
                                <input type="hidden" id="numero-add-url" name="numero-add-url" value="{{ route('numero_paiement.add') }}"/>
                                <input type="hidden" id="client_id" name="client_id" />
                            </div>
                        </div>
                    </div>

                    <a href="#" id="btn-ajouter-numero-paiement" class="btn btn-success">Ajouter</a>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="numero-liste-url" name="numero-liste-url" value="{{ route('numero_paiement.liste') }}" />
<input type="hidden" id="numero-change-url" name="numero-change-url" value="{{ route('numero_paiement.change') }}" />
<input type="hidden" id="numero-delete-url" name="numero-delete-url" value="{{ route('numero_paiement.delete') }}" />
