@extends('layouts.dashboard')

@section('content')
    {{-- Messages for created/updated user --}}
    {{-- @if ( $user_created )
        <div class="alert alert-success" role="alert">
            user inserito con successo!
        </div>
    @elseif ( $user_updated )
        <div class="alert alert-success" role="alert">
            user modificato con successo!
        </div>
    @endif --}}
    
    {{-- Title --}}
    <h1>Ciao {{ $user->name }}</h1>

    {{-- Profile Picture --}}
    @if ($user->photo)
        <img class="profile-picture" src="{{ $user->photo }}">
    @else
        <img class="profile-picture" src="https://media.istockphoto.com/vectors/default-profile-picture-avatar-photo-placeholder-vector-illustration-vector-id1223671392?k=20&m=1223671392&s=612x612&w=0&h=lGpj2vWAI3WUT1JeJWm1PRoHT3V15_1pdcTn2szdwQ0=">
    @endif

    {{-- Meta Data --}}
    <div class="meta-data my-4">
        <h5><strong>Nome e cognome:</strong> {{ $user->name }}</h5>
        <h5><strong>E-mail:</strong> {{ $user->email }}</h5>
        <h5><strong>Indirizzo:</strong> {{ $user->address }}</h5>
        <h5><strong>Telefono:</strong> {{ $user->phone_number }}</h5>
        <h5>
            <strong>Specializzazioni:</strong> 
            @if ($user->specializations->isNotEmpty()) 
                @foreach ($user->specializations as $specialization)
                    {{ $specialization->name }}{{$loop->last ? '' : ', '}}
                @endforeach
            @else
                Nessuna
            @endif
        </h5>
        {{-- Service --}}
        <h5><strong>Prestazioni:</strong></h5>
        @if ($user->service)
            <p class="user-content">{{ $user->service }}</p>
        @else
            <p class="user-content">Nessuna</p>
        @endif

        <h5><strong>Profilo creato il:</strong> {{ $user->created_at->format('l, j F Y') }}</h5>
        <h5><strong>Profilo aggiornato il:</strong> {{ $user->created_at->format('l, j F Y') }}</h5>
        {{-- <h5><strong>Profilo aggiornato il:</strong> {{ $user->updated_at->format('l, j F Y')}} - {{ $how_long_ago_updated }}</h5> --}}
        {{-- <h5><strong>Profilo aggiornato il:</strong> {{ $user->updated_at->format('l, j F Y')}} - {{ $how_long_ago_updated }}</h5> --}}
    </div>

    {{-- Curriculum --}}
    @if($user->curriculum) 
        <h5><strong>Curriculum</strong></h5>
        <p class="user-content">{{ $user->curriculum }}</p>
        @else 
        <h5><strong>Curriculum</strong> non caricato</h5>
    @endif

    {{-- Button Submit --}}
    <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" class="btn btn-primary">Modifica profilo</a>
@endsection