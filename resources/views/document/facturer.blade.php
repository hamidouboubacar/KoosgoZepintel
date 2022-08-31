@extends('layouts.template.app')

@section('title')
Facturation d'un {{ $document_type }}
@endsection
@section('content')


<div class="container-fluid">
    <form action="{{ route('document.facturation', $item) }}" method="post">
        @csrf
        @method("PUT")
        
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Références</h5>
            
            <input type="hidden" name="type" id="type" value="Facture">
        
            @if(isset($client) && !empty($client))
            <div class="form-row" id="data-devis" data-devis="{{ App\Models\Document::where('type', 'Devis')->count() + 1 }}"
            data-client-devis="{{ App\Models\Document::where('type', 'Facture')->where('client_id', $document->client_id)->count() + 1 }}">
            @else
            <div class="form-row" id="data-devis"   data-client-facture="{{ App\Models\Document::where('type', 'Facture')->where('client_id', $document->client_id)->count() + 1 }}">
            @endif
                <div class="col">
                    <div class="form-group">
                        <label for="name">N° *</label>
                        <input type="text"  name="numero" id="numero" class="form-control @error('numero')
                            is-invalid
                        @enderror"  required>
                        @if($errors->has('numero'))
                            <div class="error">{{ $errors->first('numero') }}</div>
                        @endif
                    </div>
                </div>
                
                <div class="col">
                    <div class="form-group">
                        <label for="email">Ref. Document</label>
                        <input type="text" id="reference" name="reference" class="form-control @error('reference')
                            is-invalid
                        @enderror" value="{{ isset($item->numero) ? $item->numero : old('reference') }}" />
                    </div>
                </div>
                
                <div class="col">
                    <div class="form-group">
                        <label for="email">Objet</label>
                        <input type="text" id="objet" name="objet" class="form-control @error('objet')
                            is-invalid
                        @enderror" value="{{ isset($item->objet) ? $item->objet : old('objet') }}"/>
                    </div>
                </div>
                
            </div>
            
            @if(isset($client) && $client != null)
                <input type="hidden" name="client_id" value="{{ $client->id }}" />
            @else
            <input type="hidden" name="client_id" value="{{ $document->client_id }}" />
            <input type="hidden" name="client_name" id="client_name" value="{{ $document->client->name }}" />
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <select name="client_id" class="form-control @error('client_id')
                                is-invalid
                            @enderror" @if(isset($item->client_id)) disabled @endif required id="">
                                <option class="input-reset" value="" selected="">---------</option>
                                @foreach($clients as $cl)
                                    <option  value='{{$cl->id}}'
                                    @if(isset($item->client_id) && $item->client_id == $cl->id) 
                                        selected 
                                    @endif>{{$cl->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="form-row">
                <div class="col">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" class="input-reset form-control @error('date')
                                is-invalid
                            @enderror flatpickr-input" value="{{ isset($item->date) ? $item->date : old('date') }}"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="date">Période</label>
                <select name="periode" class="form-control" placeholder="" id="periode" required>
                    <option></option>
                    
                    <option @if(isset($item->periode) && $item->periode == "1") 
                        selected 
                    @endif value="1">
                        Janvier
                    </option>
                    
                    <option @if(isset($item->periode) && $item->periode == "2") 
                        selected 
                    @endif value="2">
                    Février 
                    </option>
                    
                    <option @if(isset($item->periode) && $item->periode == "3") 
                        selected 
                    @endif value="3">
                        Mars
                    </option>
                    
                    <option @if(isset($item->periode) && $item->periode == "4") 
                        selected 
                    @endif value="4">
                        Avril
                    </option>
                    
                    <option @if(isset($item->periode) && $item->periode == "5") 
                        selected 
                    @endif value="5">
                        Mai
                    </option>
                    
                    <option @if(isset($item->periode) && $item->periode == "6") 
                        selected 
                    @endif value="6">
                        Juin
                    </option>
                    
                    <option @if(isset($item->periode) && $item->periode == "7") 
                        selected 
                    @endif value="7">
                        Juillet
                    </option>
                    
                    <option @if(isset($item->periode) && $item->periode == "8") 
                        selected 
                    @endif value="8">
                        Août
                    </option>
                    
                    <option @if(isset($item->periode) && $item->periode == "9") 
                        selected 
                    @endif value="9">
                    Septembre
                    </option>
                    
                    <option @if(isset($item->periode) && $item->periode == "10") 
                        selected 
                    @endif value="10">
                       Octobre
                    </option>
                    
                    <option @if(isset($item->periode) && $item->periode == "11") 
                        selected 
                    @endif value="11">
                        Novembre
                    </option>
                    
                    <option @if(isset($item->periode) && $item->periode == "12") 
                        selected 
                    @endif value="12">
                        Décembre
                    </option>
                </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Packages</h5>
        
            <div class="form-row">
                <div class="col">
                    @include('document.forms.packages')
                </div>
            </div>
        </div>
        
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Montants</h5>
        
            @if(isset($item->tva))

            @if ($item->tva > 0)
            <div class="form-row mt-3 ml-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="tva-checkbox" name="tva-checkbox"
                    >
                    <label class="form-check-label" for="">Sans TVA (18%)</label>
                </div>
            </div>
            @else
            <div class="form-row mt-3 ml-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="tva-checkbox" name="tva-checkbox"
                    checked>
                    <label class="form-check-label" for="">Sans TVA (18%)</label>
                </div>
            </div>
            @endif
        
            @else
        
            <div class="form-row mt-3 ml-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="tva-checkbox" name="tva-checkbox">
                    <label class="form-check-label" for="">Sans TVA (18%)</label>
                </div>
            </div>
            
            @endif
            
            <div class="form-row mt-3">
                <div class="col-4">
                    <div class="form-group">
                        <label for="montantht">Total HT</label>
                        <input type="text" name="montantht" id="montantht" class="form-control @error('montantht')
                            is-invalid
                        @enderror" value="{{ isset($item->montantht) ? $item->montantht : old('montantht') }}">
                        @if ($errors->has('montantht'))
                            <span class="invalid feedback"role="alert">
                                <strong>{{ $errors->first('montantht') }}.</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="tva">TVA</label>
                        <input type="text" id="tva" name="tva" class="form-control" value="{{ isset($item->tva) ? $item->tva : old('tva') }}"/>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="montantttc">Total TTC</label>
                        <input type="text" id="montantttc" name="montantttc" class="form-control @error('montantttc')
                            is-invalid
                        @enderror" value="{{ isset($item->montantttc) ? $item->montantttc : old('montantttc') }}"/>
                        @if ($errors->has('montantttc'))
                            <span class="invalid feedback"role="alert">
                                <strong>{{ $errors->first('montantttc') }}.</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Autre Information</h5>
            <div class="form-row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="validite">Validité</label>
                        <input type="number"  name="validite" id="validite" min="0" class="form-control @error('validite')
                            is-invalid
                        @enderror" value="{{ isset($item->validite) ? $item->validite : old('validite') }}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="deali_de_livraison">Délai de livraison</label>
                        <input type="number" id="validite" name="deali_de_livraison" min="0" class="form-control @error('montantttc')
                            is-invalid
                        @enderror" value="{{ isset($item->validite) ? $item->validite : old('validite') }}"/>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="condition">Condition</label>
                        <select class="form-control" name="condition" placeholder="" id="condition">
                            <option>Choisir la condition</option>
                            
                            <option @if(isset($item->condition) && $item->condition == "R") 
                                selected 
                            @endif value="R">
                                A la réception
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "A la commande") 
                                selected 
                            @endif value="A la commande">
                                A la commande
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "Fin du mois") 
                                selected 
                            @endif value="Fin du mois">
                                Fin du mois
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "15 jours") 
                                selected 
                            @endif value="15 jours">
                                15 jours
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "20 jours") 
                                selected 
                            @endif value="20 jours">
                                20 jours
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "30 jours") 
                                selected 
                            @endif value="30 jours">
                                30 jours
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "45 jours") 
                                selected 
                            @endif value="45 jours">
                                45 jours
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "60 jours") 
                                selected 
                            @endif value="60 jours">
                                60 jours
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "90 jours") 
                                selected 
                            @endif value="90 jours">
                                90 jours
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "+30 jours fin de mois") 
                                selected 
                            @endif value="+30 jours fin de mois">
                                30 jours fin de mois
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "+45 jours fin de mois") 
                                selected 
                            @endif value="+45 jours fin de mois">
                                45 jours fin de mois
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "+60 jours fin de mois") 
                                selected 
                            @endif value="+60 jours fin de mois">
                                60 jours fin de mois
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "+11 jours fin de mois le 10") 
                                selected 
                            @endif value="+11 jours fin de mois le 10">
                                30 jours fin de mois le 10
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "+46 jours fin de mois le 10") 
                                selected 
                            @endif value="+46 jours fin de mois le 10">
                                45 jours fin de mois le 10
                            </option>
                            
                            <option @if(isset($item->condition) && $item->condition == "+61 jours fin de mois le 10") 
                                selected 
                            @endif value="+61 jours fin de mois le 10">
                                60 jours fin de mois le 10
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="summernote-basic">Commentaire</label>
                        <textarea class="form-control" id="summernote-basic" name="commentaire">
                            @if(isset($item->commentaire)) 
                                {{ $item->commentaire }}
                            @endif
                        </textarea>
                    </div>
                </div><!-- end col -->
            </div>
        </div>
        @if (Auth::user()->fonction->name == 'Commercial')
<div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Suivi par:</h5>
    <div class="form-row">
        <div class="col-4">
            <div class="form-group">
                <label for="user_id">Commercial</label>
                <select name="user_id" class="form-control" required>
                <option class="input-reset" value="{{Auth::user()->id}}" selected>{{Auth::user()->name}}</option>
            </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="suivi_par">Autre personne</label>
                <input type="text" id="suivi_par" name="suivi_par"  class="form-control"/>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="contact_personne">Contact de la personne</label>
                <input type="number" id="contact_personne" name="contact_personne"  class="form-control"/>
            </div>
        </div>
    </div>
</div>

@else

<div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Suivi par:</h5>
    <div class="form-row">
        <div class="col-4">
            <div class="form-group">
                <label for="user_id">Commercial</label>
                <select name="user_id" class="form-control select2">
                <option class="input-reset" value="" selected="">---------</option>
                @foreach($users as $user)
                    <option value='{{$user->id}}'
                    @if(isset($item->user) && $item->user_id == $user->id) 
                        selected 
                    @endif>{{$user->name}}</option>
                @endforeach
            </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="suivi_par">Autre personne</label>
                <input type="text" id="suivi_par" name="suivi_par" value='{{$item->suivi_par ?? ''}}'  class="form-control"/>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="contact_personne">Contact de la personne</label>
                <input type="number" id="contact_personne" name="contact_personne" value='{{$item->contact_personne ?? ''}}' class="form-control"/>
            </div>
        </div>
    </div>
</div>

@endif

        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Enregistrer</button>
                    <a onclick="window.history.back()" href="#" type="button" class="btn w-sm btn-light waves-effect">Annuler</a>
                </div>
            </div> <!-- end col -->
        </div>
    </form>
</div>

@endsection

@push('js_files')
    <script>
        $('#summernote-basic').summernote();
    </script>
    <script src="{{ asset('assets/js/app/document.js') }}"></script>
@endpush
