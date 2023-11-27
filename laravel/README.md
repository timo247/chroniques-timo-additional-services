## Next steps

2. Ajouter une colonne spotify_uri aux épidodes: https://developer.spotify.com/documentation/embeds/tutorials/using-the-iframe-api

https://developer.spotify.com/documentation/web-api/concepts/spotify-uris-ids

7okkT503mfXa4QKgOOATvz

3. Tenter de lire un épisode à l'aide du iframe spotify (cf stratégie sur drive)

4. Retrouver la liste des épisodes URIs et seeder la base de données

5. Créer la vue d'administration permettant d'affilier des tags aux épisodes et de les prévisualiser (les lire) à l'aide d'Irame pour s'assurer de la véracité du lien.

6. Migrer la BDD vers MySQL

7. Déployer l'app, et remplir progressivement l'affiliation des thèmes dans la base de données à l'aide de l'interface

## Rappel au momment du déploiement

Modifier la valeur de la variable domain dans le fichier config/session.php
https://laravel.com/docs/10.x/sanctum#spa-configuration
https://www.youtube.com/watch?v=ajUST-jUMeg

## Idéees pour la suite

-   Faire des séries d'épisodes préméditées par personnage et par thématique

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
