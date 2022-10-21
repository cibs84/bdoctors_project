@extends('layouts.dashboard')

@section('content')
    <h1>Ciao {{ $user->name }}, questa è la tua lista delle tue Recensioni</h1>

    {{-- Stampa tutte le recensioni --}}
    @foreach ($reviews as $review)
        <ul>
            <li><strong>Review ID:</strong> {{ $review->id }}</li>
            <li><strong>Autore:</strong> {{ $review->author }}</li>
            <li><strong>Data pubblicazione:</strong> {{ $review->created_at }}</li>
            <li><strong>Voto:</strong> {{ $review->vote }}</li>
            <li><strong>Recensione:</strong> {{ $review->content }}</li>
            <!-- Delete Button -->
            <button  class="btn btn-danger my-3" type="button" data-target="#deleteModal{{$review->id}}" data-toggle="modal">Elimina</button>
        </ul>

        <hr>


        <!-- Modale conferma eliminazione profilo user -->
        <div class=" modal" tabindex="-1" role="dialog" id="deleteModal{{$review->id}}">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Conferma eliminazaione</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confermi di voler eliminare la recensione?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">NO</button>
                    <form class="form-btn-elimina" action="{{ route('admin.reviews.destroy', ['review' => $review->id]) }}" method="post">
                    {{-- <form class="form-btn-elimina" action="{{ route('admin.reviews.destroy', ['review' => 4]) }}" method="post"> --}}
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
        {{ $reviews->links() }}
    </div>
@endsection