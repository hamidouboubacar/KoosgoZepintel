@extends('layouts.template.app')

@section('title')
Paiement Facture
@endsection

@section('content')
    <div class="container-fluid">

        <div class="modal-body">
            <form action="{{ route('paiement.store') }}" method="post" id="createPaiment">
                @csrf
                <div class="form-row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="numero">Facture</label>
                            <input type="text"  name="numero" id="numero" value="{{$document->numero}}" readonly class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <input type="text"  name="client_id" id="client_name" value="{{$document->client->name}}" readonly class="form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="montant_payer">Montant</label>
                            <input type="text" id="montant_payer" name="montant_payer" value="{{number_format($document->montantttc,0,'.',' ')}} F" readonly class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="date_paiement">Date de paiment</label>
                            <input type="date"  name="date_paiement" id="date_paiement" value="{{$date}}" class="input-reset form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="montant_payer">Montant de paiment</label>
                            <input type="number" min="0" id="montant_payer_value" name="montant_payer" class="form-control" required/>
                            <span id="montant_payer_message" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Mode de paiment</label>
                            <select class="form-control" name="mode_paiement" placeholder="Choisir le mode de paiement" id="mode_paiement"
                                           required>
                                        <option></option>
                                        <option value="Espèce">Espèce</option>
                                        <option value="Chèque">Chèque</option>
                                        <option value="Virement">Virement</option>
                                        <option value="Orange Money">Orange Money</option>
                                        <option value="Mobile cash">Mobile cash</option>
                                        
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="reste_a_payer">Reste à payer</label>
                            <input type="text" id="reste_a_payer" name="reste_a_payer" value="{{number_format($document->reste_a_payer,0,'.',' ')}} F" readonly class="form-control"/>
                            <input hidden type="number" id="reste_a_payer_value" value="{{$document->reste_a_payer}}" disabled class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button id="btn-enregistrer" type="submit" class="btn btn-primary">Enregistrer</button>
                </div>

                <input type="hidden" name="document_id" id="document_id" value="{{$document->id}}" class="form-control" edi required>
            </form>
        </div>
</div>


@endsection

@push('js_files')
    <script src="{{ asset('assets/js/app/paiement.js') }}"></script>

@endpush