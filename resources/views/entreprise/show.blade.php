@extends('layouts.template.app')

@section('title')
Informations de Netforce
@endsection

@section('content')
<div class="container-fluid">
    <form action="{{ route('entreprise.edit', ['entreprise'=>$entreprise->id]) }}" method="put" id="formUpdate" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" value="{{$entreprise->name ?? ''}}" readonly class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="forme_juridique">Forme juridique</label>
                    <input type="text" value="{{$entreprise->forme_juridique ?? ''}}" readonly class="form-control"/>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <label for="ifu">Activite</label>
                <input type="text" name="activite" id="activite" value="{{$entreprise->ifu ?? ''}}" readonly class="form-control">
            </div>
        <div class="col-6">
            <label for="rccm">Rccm</label>
            <input type="text" value="{{$entreprise->rccm ?? ''}}" readonly class="form-control">
        </div>
        </div>
        
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="telephone">Téléphone </label>
                    <input type="text"  value="{{$entreprise->telephone ?? ''}}" readonly class="form-control" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="adresse">Adresse </label>
                    <input type="text" id="adresse1" name="adresse" value="{{$entreprise->adresse ?? ''}}" readonly class="form-control" />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <label for="ifu">IFU</label>
                <input type="text" name="ifu" id="ifu" value="{{$entreprise->ifu ?? ''}}" readonly class="form-control">
            </div>
        <div class="col-6">
            <label for="rccm">RCCM</label>
            <input type="text" name="rccm" id="rccm" value="{{$entreprise->rccm ?? ''}}" readonly class="form-control">
        </div>
        </div>
        
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="email">email </label>
                    <input type="email" id="email" name="email" value="{{$entreprise->email ?? ''}}" readonly class="form-control" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="adrewebsse">Web </label>
                    <input type="text" id="web" name="banque" value="{{$entreprise->banque ?? ''}}" readonly class="form-control" />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <label for="ifu">Banque</label>
                <input type="text" name="banque" id="banque" value="{{$entreprise->banque ?? ''}}" readonly class="form-control">
            </div>
        <div class="col-6">
            <label for="compte">Compte</label>
            <input type="text" name="compte" id="compte" value="{{$entreprise->compte ?? ''}}" class="form-control">
        </div>
        </div>
        <br>
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="logo"><strong>Logo</strong> </label> <br>
                    @php
                    $image = explode('public/', $entreprise->logo);
                    @endphp
                    <img src="{{ asset('storage/'.$image[1]) }}" width="auto" height="200px"/>
                </div>
            </div>
            <br>
            <div class="col-6">
                <div class="form-group">
                    <label for="signature"><strong>Signature</strong> </label> <br>
                    @php
                    $image = explode('public/', $entreprise->signature);
                    @endphp
                    <img src="{{ asset('storage/'.$image[1]) }}" width="auto" height="200px"/>
                </div>
            </div>
        </div>
        <br>
        <div class="form-row">
            <div class="col-12">
                <div class="form-group">
                    <label for="entete"><strong>Entête</strong></label> <br>
                    @php
                    $image = explode('public/', $entreprise->entete);
                    @endphp
                    <img src="{{ asset('storage/'.$image[1]) }}" width="auto" height="230px"/>
                </div>
            </div>   
            <br>
            <div class="col-12">
                <div class="form-group">
                    <label for="pieddepage"><strong>Pied de page</strong></label> <br>
                    @php
                    $image = explode('public/', $entreprise->pieddepage);
                    @endphp
                    <img src="{{ asset('storage/'.$image[1]) }}" width="auto" height="105px"/>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="fax">Fax </label>
                    <input type="text" id="fax" name="fax" value="{{$entreprise->fax ?? ''}}" readonly class="form-control" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="rib">RIB </label>
                    <input type="text" id="rib" name="rib" value="{{$entreprise->rib ?? ''}}" readonly class="form-control" />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="bic">BIC </label>
                    <input type="text" id="bic" name="bic" value="{{$entreprise->bic ?? ''}}" readonly class="form-control" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="tva">TVA </label>
                    <input type="text" id="tva" name="tva" value="{{$entreprise->tva ?? ''}}" readonly class="form-control" />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="pays">Pays </label>
                    <select class="form-control">
                        <option value="" disabled >Pays</option>
                        <option value="Burkina Faso" selected>Burkina Faso </option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="ville">Ville </label>
                    <select class="form-control">
                        <option value="Ouagadougou" selected>Ouagadougou</option>
                        <option value="Bobo dioulasso">Bobo dioulasso</option>
                        <option value="Koudougou">Koudougou</option>
                        <option value="Dedougou">Dedougou</option>
                        <option value="Kaya">Kaya</option>
                        <option value="Tenkodogo">Tenkodogo</option>
                        <option value="Ouahigouya">Ouahigouya</option>
                        <option value="Manga">Manga</option>
                        <option value="Gaoua">Gaoua</option>
                        <option value="Banfora">Banfora</option>
                        <option value="Fada N'Gourma">Fada N'Gourma</option>
                        <option value="Ziniaré">Ziniaré</option>
                        <option value="Dori">Dori</option>
                    </select>
                </div>
            </div>
        </div>
        @can('create', 'App\Models\Entreprise')
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Modifier</button>
        </div>
        @endcan
    </form>
</div>

@endsection