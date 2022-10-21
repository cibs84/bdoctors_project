<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;
use Braintree_Transaction;
use App\Bundle;
use Carbon\Carbon;


class PaymentsController extends Controller
{
    public function paymentForm(Request $request) {
        $aCustomerId = null;

// viene istanziato il gateway di braintree per generare il client token, che ci servirà per chiedere il payment method nonce
// e quindi aprire la transazione
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'jn3yqkw6f2xzfsbm',
            'publicKey' => 'wggkn9jxrnqgv3pn',
            'privateKey' => '4df29101f7ae6162150c8658bd345f5e'
        ]);
        // Creo il client token
        $client_token = $gateway->clientToken()->generate([
            "customerId" => $aCustomerId
        ]);

        // creo l'array di dati da passare alla view necessari per far generare il form di braintree di pagamento
        $data = [
            'user' => $request->user(),
            'client_token' => $client_token,
            'bundle' => $request['bundle'],
            'device_data' => $request['device_data']
        ];

        return view('admin.payment.process', $data);
    }

    public function process(Request $request) {
        //istanzio nuovamente il gateway di braintree
    $gateway = new Gateway([
        'environment' => 'sandbox',
        'merchantId' => 'jn3yqkw6f2xzfsbm',
        'publicKey' => 'wggkn9jxrnqgv3pn',
        'privateKey' => '4df29101f7ae6162150c8658bd345f5e'
    ]);
    //mi prendo i dati necessari a creare la row nella tabella user_bundle
    $user = $request->user();
    
    // mi prendo le informazioni del bundle selezionato dall'utente dal DB
    $bundle = Bundle::findOrFail($request['bundle']);
    // questa riga serve per simualare un pagamento fallito, che braintree restituisce nel caso di una somma tra 2000 e 2999
    // quindi imposta un "amount" tra quei valori nel caso si selezioni il primo bundle
    // QUINDI IL PRIMO BUNDLE RESTITUIRà SEMPRE PAGAMENTO FALLITO AL PRIMO TENTATIVO
    // CARD NUMBER DA USARE FORNITA DA BRAINTREE: 4500600000000061
    $price = '';
    if($request['bundle'] == 1 && $request['payments_number'] == 1) {
        $price = "2879.99";
    } else {
        $price = $bundle->price;
    }

    // genero la transazione di vendita passando tutti i dati fondamentali: somma, payment nonce generato prima, device data generato prima
    $result = $gateway->transaction()->sale([
        'amount' => $price,
        'paymentMethodNonce' => $request['data']['nonce'],
        'deviceData' => $request['device_data'],
        'options' => [
          'submitForSettlement' => True
        ]
      ]);
      //nel caso la chiamata a braintree restituisca success, aggiungo il bundle creato all'utente loggato
      if ($result->success) {
        // prendo l'id del bundle selezionato dall'utente
            $id_bundle = $bundle->id;
            // creo la data di questo momento per la colonna created_at      
            $created_date = Carbon::now();
            // imposto la data di scadenza del bundle appena creato come data attuale + giorni dela durata del bundle
            $expired_date = Carbon::parse($created_date)->addDays($bundle->duration);
            // creo l'array necessario alla funzione di sync per creare la riga nel DB
            $new_user_bundle = [$id_bundle => ['created_date' => $created_date, 'expired_date' => $expired_date]];
            // creo la riga nel DB
            $user->bundles()->sync($new_user_bundle);
      }
      // rimando al Front-End la risposta di braintree
        return response()->json($result);
    }
}
