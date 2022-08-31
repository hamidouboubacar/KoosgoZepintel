<div class="modal fade" id="sendMailPaiement" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paiement client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sendMailPaiment') }}">
                    @csrf
                    @method("PUT")
                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email">E-mail du client</label>
                                <input type="email" id="email2" name="email" readonly class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="cc">Cc:</label>
                                <input type="text" id="emailcc" name="emailcc" class="form-control"/>
                                <span><b>Séparés les mails par un virgule " , "</b></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email">Objet</label>
                                <input type="text" id="objet" name="objet" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col">
                            <label for="contenu">Message</label>
                            <textarea name="contenu" id="contenu2" class="input-reset contenu form-control @error('contenu')
                                is-invalid
                            @enderror">{{ isset($item->contenu) ? $item->contenu : old('contenu') }}</textarea>
                        </div>
                    </div>

                    <input type="hidden" id="document_id2" name="document_id">
                    <input type="hidden" id="paiement_id" name="paiement_id">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>