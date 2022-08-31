
<div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajout d'un bon de commande</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('bonCommande.store') }}" method="post" id="create-client-form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="numero">Numéro BC*</label>
                                <input type="text"  name="numero" id="numero" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="client_id">Client</label>
                                <select name="client_id" class="form-control @error('nom')
                                is-invalid
                            @enderror" required id="">
                                <option class="input-reset" value="" selected="">---------</option>
                                @foreach($clients as $client)
                                    <option value='{{$client->id}}'
                                    @if(isset($item->client_id) && $item->client_id == $client->id) 
                                        selected 
                                    @endif>{{$client->name}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-6">
                            <label for="reference">Référence</label>
                            <input type="text" name="reference" class="input-reset form-control id="reference" class="form-control">
                        </div>
                    <div class="col-6">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="input-reset form-control class="form-control">
                    </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="echeance">Echéance </label>
                                <input type="date" id="echeance" name="echeance" class="form-control" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="fichier">Importer BC </label>
                                <input type="file" id="fichier" name="fichier" class="form-control" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

