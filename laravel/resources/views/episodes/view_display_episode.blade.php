@extends('template')

@section('content')
    @if (isset($info))
        <div class='row alert alert-info'> {{ $info }}</div>
    @endif
    <article class="row bg-primary">
        <div class="col-md-12">
            <header>
                <h1> {{ $episode->title }}</h1>
                <div class="pull-right">
                    @foreach ($episode->tags as $tag)
                        <span>{{ $tag->name }}</span>
                    @endforeach
                </div>
            </header>
            <hr>
            <section>
                <p>{{ $episode->description }}</p>
                {{-- @if (Auth::check() and Auth::user()->admin)
                        <form method="POST" action="{{ route('episodes.destroy', [$episode->id]) }}" accept-charset="UTF-8">
                            @csrf
                            @method('DELETE')
                            <input class="btn btn-danger btn-xs" onclick="return confirm('Vraiment supprimer cet episode ?')"
                                type="submit" value="Supprimer cet episode">
                        </form>
                    @endif --}}
                <p>{{ $episode->spotify_uri }}</p>
                <em class="pull-right">
                    <span class="gliphicon glyphicon-pencil"></span>
                    Created at {!! $episode->created_at->format('d-m-Y') !!}
                </em>
            </section>
            </hr>
        </div>
    </article>
    <br>
@endsection
