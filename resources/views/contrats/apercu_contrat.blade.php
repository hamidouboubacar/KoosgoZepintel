<!DOCTYPE html>

<html>
    <head>
    </head>
    <body>
        @if($contrat->avec_entete)
            @php
            $image = explode('public/', $entreprise->entete);
         @endphp
       <img src="{{ public_path('storage/'.$image[1]) }}" width="100%" height="150px"/>
        @else
            <hr />
        @endif
        <div style="padding-left: 90px; padding-right: 90px;">
            {!! $content !!}
            <br>
            <div style="margin-bottom: 50px">Date d'activation le {{ $date_contrat }}</div>
            <div style="margin-bottom: 50px">Fait à Ouagadougou, le {{ $date_jour }}</div>
            @if($contrat->avec_signature)
                <div>
                    <span style="margin-right: 350px">Le fournisseur</span>
                    <span>Le Client</span>
                </div>

                <div>
                    @php
                    $imageSignature = explode('public/', $entreprise->signature);
                    @endphp
                    <img src="{{ public_path('storage/'.$imageSignature[1]) }}" style="width: 100px">
                </div>
            @else
                <div>
                    <span style="margin-right: 350px">Le fournisseur</span>
                    <span>Le Client</span>
                </div>

                <div>
                </div>
            @endif
        </div>
        <script>
            // window.print();
        </script>
    </body>
</html>