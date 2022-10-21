@extends('layouts.dashboard')

@section('content')
<!-- meta necessario a simulare il csfr token di un form, necessario per far accettare a laravel la chiamata di post -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            {{-- container dove braintree andrà ad inserire il suo form --}}
            <div id="dropin-container"></div>
            <button id="submit-button" class="button button--small button--green">Acquista</button>

        </div>
    </div>
<!-- modale di successo di pagamento -->
        <div id="modale" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Pagamento riuscito!</h5>
                  
                </div>
                <div class="modal-body">
                  <p>Complimenti! Il pagamento è avvenuto con successo.</p>
                </div>
                <div class="modal-footer">
                  <button onclick="redirectToHome()" type="button" class="btn btn-primary">Conferma</button>
                </div>
              </div>
            </div>
        </div>
<!-- modale di pagamento fallito -->
        <div id="failModale" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Pagamento fallito!</h5>
                  
                </div>
                <div class="modal-body">
                  <p>Ricontrolla i campi e riprova!</p>
                </div>
                <div class="modal-footer">
                  <button data-dismiss="modal" type="button" class="btn btn-primary">Conferma</button>
                </div>
              </div>
            </div>
        </div>
</div>

 {{-- BRAINTREE SCRIPT --}}
    <script type="text/javascript">
    // assegno alle variabili js tutti i dati necessari passati precedente tramite view nel controller
        var button = document.querySelector('#submit-button');
        var modale = document.getElementById('modale');
        let client_token = "{{ $client_token }}";
        let device_data = "{{ $device_data }}"
        let bundle = "{{$bundle}}"
        let paymentsNumber = 1;

        // funzione per fare il redirect alla pagina profilo dell'utente, in caso di pagamento riuscito
        function redirectToHome() {
            window.location.href = "{{ route('admin.home') }}"
        }

        // richiedo il payment method nonce a braintree usando il client token generato precedentemente nel controller 
        // e poi passato alla view
        braintree.dropin.create({
            // il token e container servono per dire a braintree dove inserire il form della carta di pagamento
            authorization: client_token,
            container: '#dropin-container'
            }, function (err, instance) {
                // aggiungo un event listener per fare il catch del click del pulsante "purchase"
                button.addEventListener('click', function () {
                    // finalmente richiedo il metodo di pagamento
                    instance.requestPaymentMethod(function (err, payload) {
                    // nel payload sarà presente il nostro methodPaymentNonce necessario a concludere la transazione
                    // passo il tutto tramite una chiamata POST in ajax al nostro Back-End
                    $.ajax({
                        url: '{{ route('payment.process') }}',
                        type: 'post',
                        data: {
                            data: payload,
                            device_data: device_data,
                            bundle: bundle,
                            client_token: client_token,
                            // payments number per simulare un pagamento fallito seguito da un pagamento avvenuto con successo
                            payments_number: paymentsNumber
                        },
                        // trucco per fare una chiamata al Back-End laravel senza il form e quindi senza un CSFR token, necessario per laravel per accettare
                        // la chiamata in POST
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (data) {
                            paymentsNumber++;
                            // in base a cosa risposta braintree e quindi il nostro BE, mostro la modale di success o fail
                            if(data.success) {
                                $('#modale').modal('show')
                            } else {
                                $('#failModale').modal('show')
                            }
                        }
                    });
                });
            });
        });
    </script>
@endsection