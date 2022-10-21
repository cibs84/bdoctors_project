@extends('layouts.dashboard')

@section('content')
    <h1>Ciao {{ $user->name }}, questa è la tua lista dei Messaggi Ricevuti</h1>

    {{-- Stampa tutte le recensioni --}}
    @foreach ($messages as $message)
        <ul>
            <li><strong>Message ID:</strong> {{ $message->id }}</li>
            <li><strong>Autore:</strong> {{ $message->author }}</li>
            <li><strong>Data invio:</strong> {{ $message->created_at }}</li>
            <li><strong>Email:</strong> {{ $message->email }}</li>
            <li><strong>Messaggio:</strong> {{ $message->content }}</li>
            <!-- Delete Button -->
            <button  class="btn btn-danger my-3" type="button" data-target="#deleteModal{{ $message->id }}" data-toggle="modal">Elimina</button>
        </ul>

        <hr>

        <!-- Modale conferma eliminazione profilo user -->
        <div class="modal" tabindex="-1" role="dialog" id="deleteModal{{ $message->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Conferma eliminazaione</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confermi di voler eliminare il messaggio?</p>
                </div>
                <div class="modal-footer">
                    {{-- Button NO --}}
                    <button class="btn btn-primary" type="button" data-dismiss="modal">NO</button>

                    {{-- Button SI --}}
                    <form class="form-btn-elimina" action="{{ route('admin.messages.destroy', ['message' => $message->id]) }}" method="post">
                    {{-- <form class="form-btn-elimina" action="{{ route('admin.messages.destroy', ['message' => 4]) }}" method="post"> --}}
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="SI" class="btn btn-danger">
                    </form>
                </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Pagination --}}
    <div>
        {{ $messages->links() }}
    </div>
@endsection