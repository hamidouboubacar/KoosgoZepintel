@extends('layouts.template.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('contrats.store_contrat_content', $contrat) }}" method="post" id="formUpdate">
        @csrf
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Contenu</h5>
            
            <div class="form-group mt-3">
                <label for="">Signature</label> <br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="avec_signature" id="" value="1" @if($contrat->avec_signature) checked @endif>
                    <label class="form-check-label" for="">Avec signature</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="avec_signature" id="" value="0" @if(!$contrat->avec_signature) checked @endif>
                    <label class="form-check-label" for="">Sans signature</label>
                </div>
            </div>
            
            <div class="form-group mt-3">
                <label for="">Entête</label> <br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="avec_entete" id="" value="1" @if($contrat->avec_entete) checked @endif>
                    <label class="form-check-label" for="">Avec entête</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="avec_entete" id="" value="0" @if(!$contrat->avec_entete) checked @endif>
                    <label class="form-check-label" for="">Sans entête</label>
                </div>
            </div>

            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <a href="{{ route('contrats.index') }}" class="btn btn-dark mt-3 btn-sm">Aller à la liste de contrat<a>
                        <a href="{{ route('contrats.download', $contrat) }}" class="btn mt-3 btn-warning btn-sm"><i class="mdi mdi-download mr-1"></i> Télécharger</a> 
                        <button type="submit" class="btn mt-3 btn-primary btn-sm"><i class="mdi mdi-content-save-outline mr-1"></i> Enregistrer</button> 
                        
                        <textarea class="form-control" name="content" id="summernote-editmode">
                            @if(isset($contrat) && isset($contrat->content) && !empty($contrat->content))
                                {{ $contrat->content }}
                            @else
                                @include('contrats.edit_contrat')
                            @endif
                        </textarea>
                        <!-- <div id="summernote-edit">
                            <a href="#" class="btn mt-3 btn-primary btn-sm"><i class="mdi mdi-pencil mr-1"></i> Editer</a>
                        </div>
                        <div id="summernote-save" style="display: none;">
                            <a href="#" id="summernote-save" class="btn btn-success btn-sm mt-2"><i class="mdi mdi-content-save-outline mr-1"></i> Aperçu</a> 
                        </div> -->
                        
                        <a href="{{ route('contrats.index') }}" class="btn btn-dark mt-3 btn-sm">Aller à la liste de contrat<a>
                        <a href="{{ route('contrats.download', $contrat) }}" class="btn mt-3 btn-warning btn-sm"><i class="mdi mdi-download mr-1"></i> Télécharger</a> 
                        <button type="submit" class="btn mt-3 btn-primary btn-sm"><i class="mdi mdi-content-save-outline mr-1"></i> Enregistrer</button> 
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Enregistrer</button>
                    <a onclick="window.history.back()" href="#" type="button" class="btn w-sm btn-light waves-effect">Annuler</a>
                </div>
            </div> 
        </div> -->
    </form>
</div>

@endsection
@push('js_files')
    <!-- Init js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/libs/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-summernote.init.js') }}"></script>
    <script src="{{ asset('assets/libs/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-quilljs.init.js') }}"></script>
    <script src="{{ asset('assets/js/app/document.js') }}"></script>
    <script>
        $('#summernote-editmode').summernote();
    </script>
@endpush