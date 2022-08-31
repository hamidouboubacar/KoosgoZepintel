<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="text-align: center"><h1>NETFORCE-GROUP</h1> </div>
                  <div class="card-body">
                      @php
                          $code
                      @endphp
                   @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                           {{ __('A fresh mail has been sent to your email address.') }}
                       </div>
                   @endif
                   <strong>OBJET : {{$data['objet'] ?? ''}}</strong>
                   <p>   {!! $data['contenu'] ?? '' !!}</p>
                    
                     <br>
                     <br>

                   <a href="{{ route('telecharger.document', ['document'=>$data['document_id']]) }}" target="_blank"> Cliquer ici pour télécharger le document</a>
                  
               </div>
           </div>
       </div>
   </div>
</div>
