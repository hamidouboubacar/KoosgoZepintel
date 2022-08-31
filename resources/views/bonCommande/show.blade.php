
@extends('layouts.template.app')

@section('title')
Affichage du bon de commande
@endsection

@section('content')

<div id="example1">



</div>


@endsection



@push('js_files')
    <script>PDFObject.embed("/storage/bcc/{{ $bonCommande->fichier }}", "#example1");</script>
@endpush
