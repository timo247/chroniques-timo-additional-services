@extends('template')

@section('contenu')
    <BR>
    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel panel-info">
            <div class="panel-heading">Ajout d'un podcast</div>
            <div class="panel-body">
                <form method="POST" action="{{ route('podcasts.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {!! $errors->has('podcast_id') ? 'has-error' : '' !!}">
                        <label>Saison du podcast</label>
                        <select name="podcast_id">
                            @foreach ($possiblePodcasts as $podcast)
                                <option value="{{ $podcast['id'] }}">{{ $podcast['title'] }}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('podcast_id', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="form-group {!! $errors->has('no') ? 'has-error' : '' !!}">
                        <input class="form-control" placeholder="No" name="no" type="number" placeholder="Numéro">
                        {!! $errors->first('no', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="form-group {!! $errors->has('title') ? 'has-error' : '' !!}">
                        <input class="form-control" placeholder="Titre" name="title" type="text">
                        {!! $errors->first('title', '<small class="help-block">:message</small>') !!}
                    </div>

                    <div class="form-group {!! $errors->has('characters') ? 'has-error' : '' !!}">
                        <label>Characters</label><br>
                        @foreach ($possibleCharacters as $char)
                            <input type='checkbox' name="characters[]" value='{{ $char['name'] }}'>
                            <label for='{{ $char['name'] }}'> {{ $char['name'] }} </label>
                        @endforeach
                    </div>

                    <div class="form-group {!! $errors->has('tags') ? 'has-error' : '' !!}">
                        <label>Themes</label><br>
                        @foreach ($possibleThemes as $theme)
                            <input type='checkbox' name="tags[]" value='{{ $theme['value'] }}'>
                            <label for='{{ $char['name'] }}'> {{ $theme['value'] }} </label>
                        @endforeach
                        {!! $errors->first('tags', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="form-group {!! $errors->has('tags') ? 'has-error' : '' !!}">
                        <input class="form-control" name="audio-file" type="file" accept="audio/*"
                            enctype="multipart/form-data">
                        {!! $errors->first('audio-file', '<small class="help-block">:message</small>') !!}
                    </div>
                    <input class="btn btn-info pull-right" type="submit" value="Envoyer">
                </form>
            </div>
        </div>
        <a href="javascript:history.back()" class="btn btn-primary"><span
                class="glyphicon glyphicon-circle-arrow-left"></span>Retour</a>
    </div>
@endsection
