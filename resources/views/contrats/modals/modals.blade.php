<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter {{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contrats.store') }}" method="post" id="create-form">
                    @csrf
                    @include('contrats.modals.edit')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
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
                <h5 class="modal-title">Modifier {{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contrats.update', 0) }}" method="post" id="formUpdate">
                    @csrf
                    @method("PUT")
                    <!-- @include('packages.modals.edit') -->
                    <div id="formContent">Content</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suppimer {{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contrats.destroy', 0) }}" method="post" id="formDelete">
                    @csrf
                    @method("DELETE")
                    <p>Êtes-vous sûr de vouloir supprimer?</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NON</button>
                        <button type="submit" class="btn btn-danger">OUI</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imprimerContratModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imprimer {{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contrats.createWordDocx', 0) }}" method="post" id="formImpression">
                    @csrf
                    <div class="form-group mt-3">
                        <label for="">Type de fichier</label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="typeFichier" id="" value="word" checked>
                            <label class="form-check-label" for="">WORD</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="typeFichier" id="" value="pdf">
                            <label class="form-check-label" for="">PDF</label>
                        </div>
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="">Signature</label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="signature" id="" value="avec" checked>
                            <label class="form-check-label" for="">Avec signature</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="signature" id="" value="sans">
                            <label class="form-check-label" for="">Sans signature</label>
                        </div>
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="">Entête</label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="entete" id="" value="avec" checked>
                            <label class="form-check-label" for="">Avec entête</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="entete" id="" value="sans">
                            <label class="form-check-label" for="">Sans entête</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button id="impression-modal-dismiss" type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button id="impression-submit" type="submit" class="btn btn-primary">Imprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

