# Project Management

## Administration de l'application

### Récupération des données spotify

Faire un script qui retrouve la liste des épisodes URIs
Inclure ces URIs dans le fichier de seeding csv

### Triage des podcasts

Tenter à partir du fichier sanbox/sanbox/csv-tosql-scripts/episodes.csv + sandbox/sandbox/csv-tosql-scripts/episodes-seeder.csv de recréer la DB dans son état précédent
Noter les épisodes réécoutés dans un fichier excel

### Nommage des fichiers

Un script bash qui copie les fichiers audios et les renomme selon la convention utilisée par Episodescontroller

### Backups

Tester le redéploiement de la DB à partir d'un backup automatique fait par Infomaniak

### Déploiement

Le fichier de seeding csv et transformé en requête SQL
La requête SQL est exécutée dans PHP myAdmin
Les fichiers audios sont renommés et téléversés directement dans le dossier en ftp
Si les smokes tests passent et que tout est bien déployé, faire un backup de la DB et l'enregistré en local et sur le Drive
Modifier la valeur de la variable domain dans le fichier config/session.php ( https://laravel.com/docs/10.x/sanctum#spa-configuration https://www.youtube.com/watch?v=ajUST-jUMeg)
Mettre à jour la doc de l'API

### Affectation des personnages par épisodes (utiles pour l'éventuelle phase II de l'animation)

Faire un script qui retrouve que personnage est adns quel épisode (ex à partir de la description)
Génère ensuite une SQL query qui pourra être exécutée après la query qui enregistre tous les épisodes

## Backend

### Vue update

1. Rendre visibles sans click tous les tags de l'épisode directement
2. Comprendre pouruqoi je peux pas updater d'episode
3. Tester /pdate handelPodcastIdChange
4. Rendre accessible la vue edit de puis show et depuis la liste de tous les episode

### Vue show

1. Ajouter la fonctionnalité de prévusalisation et écoute spotify pour chaque épisode (à partir des données de l'épisode, construire un iframe à l'aide de l'api spotify)

## Front End

### Next steps

1. Finir la partie animation
2. Développement de l'UI

### Animation

#### Outils d'animation

##### type videos marketing

canva
https://www.animaker.fr/
https://www.powtoon.com/
https://lumen5.com/

##### type code

https://codepen.io/
https://jsfiddle.net/
https://svgartista.net/

#### logiciels

https://www.adobe.com/products/animate.html
https://lottiefiles.com/
https://www.adobe.com/products/aftereffects.html

#### Fonctionment

Le backgorund est animé à l'aide d'un canva
Le dessin du background est composé de différents groupe (ex: groupe nuage1, grouipe nuage 2, groupe arbre)
Chaque groupe qui doit être anuimé est redessiné à chaque animationframe.

#### Next steps

Chercher un moyen de pouvoir utiliser des frames:

1. Les frames ont une largeur proportionnelle à la largeur de la fenêtre du navigateur. La hauteur du frame est proportionnelle pour que le frame ait les mêmes proportions que le frame figma. Le frame occuppe une position de (0:0) dans la fenêtre. La géométrie des éléments est calculée en fonction du frame, et non du ctx.canvas.width.

#### Animations additionnelles (Phase II)

Selon le personnege de l'épisode, l'animal apparait dans l'animation eu début. Il s'arrête et fait son idle. Avant la fin, il repart.
gaider arrive de gauche à droite, Bob de droite à gauche, Maepatou arrive d'en haut et MAkamba sort de l'arbre.

### Développement de l?UI

Optimiser la fonctionnalité de recherche de thèmes à l'aide de la barre de recherche en y ajoutant des suggestions
Adapter la fonctionnalité de génération dynamique de playlist
Intégrer l'animation

## Idéees pour la suite

-   Faire des séries d'épisodes préméditées par personnage et par thématique
-   Faire des tests UX sur l'interface

# Podcast Management App API Endpoints

NB: All endpoints described start with "/api/"

# _About the doc_

The doc systematically provide infos for routes following that order:

## /route url

### REQUEST METHOD

-   Data to send to the api
-   Action made by the api
-   Data returned by the api

# _Authentication_

## /register

### POST

-   {string username, string email, string password}
-   Registers user
-   return [token, user credentials]

### GET

-   nil
-   register view
-   register view data

## /login

### GET

-   nil
-   login view
-   login view data

### POST

-   {string email, string password}
-   authenticate user
-   [token, user credentials]

## /logout

### POST

-   {token}
-   logout user
-   [username + deconnected]

# _Podcast Management_

## /podcasts{id}

### GET

-   podcast_id
-   return podcast view
-   podcast data

### PUT

-   podcast_id
-   update podcast
-   podcast data

### DELETE

-   podcast_id
-   delete podcast
-   podcast data

## /podcasts

### GET

-   nil
-   Display all podcasts
-   [all podcasts]

### POST

-   {string title}
-   create podcast
-   podcast data

## /podcasts/create

-   GET
-   Podcast creation view
-   {msg: rdy to create podcast}

## /episodes{id}

### GET

-   episode_id
-   return episode view
-   episode data (with tags, comments and characters)

### PUT

-   episode_id
-   update episode
-   podcast data

### DELETE

-   episode_id
-   delete episode
-   podcast data

## /episodes

### POST

-   {int podcast_id, int no, string title, string description}
-   create podcast episode
-   episode data

## /episodes/create

-   GET
-   Episode creation view
-   {existing_podcasts, existing_characters, existing_tags}

## /podcast{id}/episodes

### GET

-   {int podcast_id}
-   display all podcast epidosdes
-   podcast episodes data

# _Tags Management_

Tags are used to categorize podcasts

## /tags{id}

### GET

-   tag_id
-   return tag view (all affiliated episodes)
-   tag data

### PUT

-   tag_id
-   update tag
-   tag data

### DELETE

-   tag_id
-   delete tag
-   tag data

# _Characters Management_

## /character{id}

### GET

-   character_id
-   return character view (all affiliated episodes)
-   character data

### PUT

-   character_id
-   update character
-   character data

### DELETE

-   character_id
-   delete character
-   character data

## /character

### POST

-   {string name}
-   create character
-   character data

# _Comments Management_

## /commentaires{id}

### GET

-   id
-   display one comment
-   one comment

## PUT

-   id
-   update comment
-   updated_comment

## DELETE

-   id
-   delete comment
-   comment_data

## /commentaires

### POST

-   {user_id, episode_id, value}
-   create a comment
-   created_comment

## /user{id}/commentaires

### GET

-   user_id
-   get all user comments
-   all user comments
