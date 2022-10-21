@extends('layouts.dashboard')

@section('content')
    {{-- BRAINTREE --}}
    {{-- <script src="https://js.braintreegateway.com/web/dropin/1.33.4/js/dropin.js"></script>

    <div id="dropin-container"></div>
    <button id="submit-button" class="button button--small button--green">Acquista</button> --}}

    {{-- ----------------------- END - BRAINTREE ----------------------------- --}}

    <!-- MODAL SUCCESSO DEL PAGAMENTO -->
    {{-- @if()
        <div class="modal fade" id="modalSuccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Acquista il pacchetto promozionale</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Vuoi acquistare questo pacchetto promozionale?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button type="button" class="btn btn-primary">SI</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
        
    @else
    <!-- MODAL PAGAMNETO NON RIUSCIUTO-->
    <div class="modal fade" id="modalFail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Acquista il pacchetto promozionale</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Vuoi acquistare questo pacchetto promozionale?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                    <button type="button" class="btn btn-primary">SI</button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Titolo --}}
    <h1>Pacchetti Promozionali</h1>

    <div><strong>Acquista un piano di sponsorizzazione</strong></div>
    
    {{-- FORM BUNDLES RADIOS --}}
    <form action="{{ route('payment.form') }}" method="post">
        @csrf
        {{-- Radio-check-inputs --}}
        @foreach ($bundles as $bundle)
            <div class="form-check mt-4">
                <input class="form-check-input" type="radio" name="bundle" id="bundle-{{ $bundle->code }}" value="{{ $bundle->id }}">
                <label class="form-check-label" for="bundle-{{ $bundle->code }}">
                    <div>
                        <span class="text-uppercase font-weight-bold">{{ $bundle->name }}</span>: 
                        per{{ $bundle->price }} € di sponsorizzazione
                    </div>
                </label>
            </div>
        @endforeach
        
        {{-- Input invisibile per passare al controller la var deviceData ottenuta tramite script Braintree --}}
        <input type="hidden" name="device_data" id="device-data" value="">

        {{-- Submit --}}
        <button  type="submit" class="btn btn-primary mt-4">
            Acquista
        </button>

    </form>

    {{-- Script Braintree --}}
    <script type="text/javascript">
        let divTest = document.getElementById('device-data');
        var button = document.querySelector('#submit-button');

// viene creato il deviceData che serve per la transazione finale con braintree, viene assegnato all'input nascosto che poi verrà
// passato come parametro nella POST del form, si poteva generare anche direttamente nella view del form di pagamento
        braintree.dataCollector.create({
            client: clientInstance
            }, function (err, dataCollectorInstance) {
            if (err) {
                return;
            }
            var deviceData = dataCollectorInstance.deviceData;
            divTest.value = deviceData;
        });
    </script>
@endsection
