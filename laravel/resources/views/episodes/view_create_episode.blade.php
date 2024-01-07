@extends('template')

@section('content')
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
                    <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                        <input class="form-control" placeholder="Description" name="description" type="text">
                        {!! $errors->first('description', '<small class="help-block">:message</small>') !!}
                    </div>

                    <div class="form-group {!! $errors->has('characters') ? 'has-error' : '' !!}">
                        <label>Characters</label><br>
                        @foreach ($possibleCharacters as $char)
                            <input type='checkbox' name="characters[]" value='{{ $char['id'] }}'>
                            <label for='{{ $char['name'] }}'> {{ $char['name'] }} </label>
                        @endforeach
                    </div>

                    {{-- <div class="form-group {!! $errors->has('tags') ? 'has-error' : '' !!}">
                        <label>Themes</label><br>
                        @foreach ($possibleThemes as $theme)
                            <input type='checkbox' name="tags[]" value='{{ $theme['value'] }}'>
                            <label for='{{ $char['name'] }}'> {{ $theme['value'] }} </label>
                        @endforeach
                        {!! $errors->first('tags', '<small class="help-block">:message</small>') !!}
                    </div> --}}
                    <div class="form-group tags-inputs hidden"></div>
                    <div class="form-group {!! $errors->has('tags') ? 'has-error' : '' !!}">
                        <input class="form-control" name="audio-file" type="file" accept="audio/*"
                            enctype="multipart/form-data">
                        {!! $errors->first('audio-file', '<small class="help-block">:message</small>') !!}
                    </div>
                    <input class="btn btn-info pull-right" type="submit" value="Envoyer">
                </form>
                <div class="container">
                    <form id="addTagForm" action="/nada" method="POST">
                        <div class="row position-relative">
                            <div class="col col col-10 col-sm-8 col-md-4 position-absolute bottom-0 start-0">
                                <div class="suggestionsWrapper ">
                                    <ul id="tagSuggestions" class="list-group"></ul>
                                </div>
                            </div>
                            <!-- <div class="col col-10 col-sm-8 col-md-4 position-absolute bottom-0 start-0 ">
                                                                                            <div id="tagSuggestionsBottomBorder" class="suggestionsBorder d-*-none border"></div>
                                                                                        </div> -->
                        </div>
                        <div class="row">
                            <div class="col col-10 col-sm-8 col-md-4">
                                <label>Tags</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-10 col-sm-8 col-md-4">
                                <input type="text" id="tagInput" placeholder="Ajouter des tags">
                                <input id="addTagBtn" type="submit" value="Ajouter" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-10 col-sm-8 col-md-4">
                                <div id="selectedTags" class="flex-wrap">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <a href="javascript:history.back()" class="btn btn-primary"><span
                class="glyphicon glyphicon-circle-arrow-left"></span>Retour</a>
    </div>
    <script>
        /* Gérer l'ajout de tags par enter et ajouter un bouton pour ajouter les tags*/
        let fetchedTags = {!! json_encode($possibleThemes) !!};
        console.log('fetchedTags', fetchedTags)
        const existingTags = ['Justice',
            'Gloire',
            'Pouvoir',
            'Gouvernance',
            'Argent',
            'Amour',
            'Ordre',
            'Nature',
            'Éloquence',
            'Joie',
            'Colère',
            'Équilibre',
            'Sagesse',
            'Technologie',
            'Échec',
            'Sociabilité',
            'Générosité',
            'Courage',
            'Avarice',
            'Stress',
            'Travail',
            'Réussite',
            'Oisiveté',
            'Repos',
            'Intelligence',
            'Ignorance',
            'Simplicité',
            'Pureté',
            'Vulgarité'
        ];

        document.addEventListener("DOMContentLoaded", (event) => {
            const tagInput = document.getElementById('tagInput');
            const tagSuggestions = document.getElementById('tagSuggestions');
            const selectedTags = document.getElementById('selectedTags');
            const addTagBtn = document.getElementById('addTagBtn');
            const addTagForm = document.getElementById('addTagForm');
            const suggestionsWrapper = document.querySelector('.suggestionsWrapper');

            addTagForm.addEventListener('submit', e => {
                e.preventDefault();
                let tag = tagInput.value;
                if (tagInput.value != '') {
                    addTag(tag);
                }
                manageScrollableElementBorder(suggestionsWrapper);
            });
            addTagBtn.addEventListener('click', e => {
                e.preventDefault();
                let tag = tagInput.value;
                if (tagInput.value != '') {
                    addTag(tag);
                }
                manageScrollableElementBorder(suggestionsWrapper);
            });
            tagInput.addEventListener('input', e => {
                deleteChildren('#tagSuggestions');
                if (e.target.value != '') {
                    let matchingTags = existingTags.filter(str => str.includes(e.target.value));
                    let selectedTags = document.querySelectorAll('#selectedTags span.selected-tag');
                    for (selectedTag of selectedTags) {
                        if (matchingTags.includes(selectedTag.textContent)) {
                            matchingTags.splice(matchingTags.indexOf(selectedTag.textContent), 1);
                        }
                    }
                    displayPossibleTags(matchingTags);
                    manageScrollableElementBorder(suggestionsWrapper);
                }
            });
            suggestionsWrapper.addEventListener('scroll', e => {
                manageScrollableElementBorder(e.target);
            });
        });

        function deleteChildren(selector) {
            const node = document.querySelector(selector);
            while (node.firstChild) {
                node.removeChild(node.lastChild);
            }
        }

        function displayPossibleTags(matchingTags) {
            console.log('input')
            matchingTags.forEach((tag) => {
                const tagsList = document.querySelector('#tagSuggestions');
                const tagNode = createDomElement({
                    type: 'li',
                    classList: ['list-group-item'],
                    textContent: tag
                });
                tagsList.appendChild(tagNode);
                tagNode.addEventListener('click', (e) => addTag(e.target.textContent));
                tagNode.addEventListener('mouseover', e => {
                    e.target.classList.toggle('active')
                });
                tagNode.addEventListener('mouseleave', e => {
                    e.target.classList.toggle('active')
                })
            });
        }

        function addTag(tag) {
            const tagsList = document.querySelector('#selectedTags');
            const tagEl = createDomElement({
                type: 'button',
                classList: ['btn', 'btn-secondary', 'me-2', 'mt-2', 'd-flex']
            });
            const tagSpan = createDomElement({
                type: 'span',
                classList: ['selected-tag'],
                textContent: tag
            });
            const deleteBtn = createDomElement({
                type: 'span',
                classList: ['material-icons', 'ml-2'],
                textContent: 'close'
            });
            deleteBtn.addEventListener('click', (e) => {
                e.target.parentNode.parentNode.removeChild(e.target.parentNode)
                removeInputFromMainForm(tag)
            });
            tagsList.appendChild(tagEl);
            tagEl.appendChild(tagSpan);
            tagEl.appendChild(deleteBtn);
            deleteChildren('#tagSuggestions');
            document.querySelector('#tagInput').value = '';
            addTagInputToMainForm(tag);
        }

        function createDomElement(params) {
            const el = document.createElement(params.type);
            if (params.classList) {
                params.classList.forEach((className) => {
                    el.classList.add(className);
                });
            }
            if (params.textContent) {
                el.textContent = params.textContent;
            }
            return el;
        }

        //Add top border or bottom border to scrollable element when top and bot borders are not displayed
        function manageScrollableElementBorder(el) {
            console.log(el.scrollTop, el.scrollHeight, el.scrollHeight - el.offsetHeight)
            el.classList.remove('border-top');
            el.classList.remove('border-bottom');

            if (el.scrollTop < el.scrollHeight - el.offsetHeight + 1 && el.scrollHeight > 0 && el.scrollHeight - el
                .offsetHeight > 0) {
                el.classList.add('border-bottom');
            }
            if (el.scrollTop > 0) {
                el.classList.add('border-top');
            }
        }

        function addTagInputToMainForm(tag) {
            const inputsGroup = document.querySelector('.tags-inputs')
            const input = document.createElement('input')
            input.setAttribute('type', 'checkbox')
            input.classList.add(`input-${tag}`)
            input.setAttribute('value', tag)
            inputsGroup.appendChild(input)
        }

        function removeInputFromMainForm(tag) {
            const input = document.querySelector(`.input-${tag}`)
            input.parentNode.removeChild(input)
        }
    </script>

    <style>
        .suggestionsWrapper {
            max-height: 20vh;
            overflow-y: auto;
            border-radius: 5px;
        }

        .ml-2 {
            margin-left: 4px;
        }
    </style>
@endsection
