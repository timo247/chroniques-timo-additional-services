@extends('template')

@section('contenu')
    <BR>
    <div class="col-sm-offset-3 col-sm-6">
        <div class="panel panel-info">
            <div class="panel-heading">Ajout d'un podcast</div>
            <div class="panel-body">
                <form method="POST" action="{{ route('podcasts.store') }}" accept-charset="UTF-8">
                    @csrf
                    <div class="form-group {!! $errors->has('podcast_id') ? 'has-error' : '' !!}">
                        <select cname="podcast_id">
                            @foreach ($possiblePodcastIds as $podcastId)
                                <option value="{{ $podcastId }}">{{ $podcastId }}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('podcast_id', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="form-group {!! $errors->has('no') ? 'has-error' : '' !!}">
                        <input class="form-control" placeholder="No" name="no" type="text">
                        {!! $errors->first('no', '<small class="help-block">:message</small>') !!}
                    </div>
                    <input class="btn btn-info pull-right" type="submit" value="Envoyer">

                    <div class="form-group {!! $errors->has('contenu') ? 'has-error' : '' !!}">
                        <textarea class="form-control" placeholder="Contenu" name="contenu" cols="50" rows="10"></textarea>
                        {!! $errors->first('contenu', '<small class="help-block">:message</small>') !!}
                    </div>
                    <input class="btn btn-info pull-right" type="submit" value="Envoyer">
                </form>
            </div>
        </div>
        <a href="javascript:history.back()" class="btn btn-primary"><span
                class="glyphicon glyphicon-circle-arrow-left"></span>Retour</a>
    </div>
@endsection
