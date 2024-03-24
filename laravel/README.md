## Next steps

Protéger l'api avec une api key

Regarder auprès d'infomaniak si des backups automatiques sont faits, et si non, planifier d'en faire chaque semaine
préparer un ecxel to sql permettant par la suite de seeder les épisodes à partir de fichiers excels (ou csv)
Noter les épisodes réécoutés dans un fichier excel
Une fois l'app prête, les données sont seedées à partir du fichier excel
Une fois l'app prête, les fichiers sont insérés en étant renommés

Trouver un brui mélodieux pur bob le tapir
Envoyer des requêtes en mentionnant plus de choses avec fetch depuis le front

Installer laravel cors fruitcake:
Your requirements could not be resolved to an installable set of packages.

Problem 1 - Root composer.json requires fruitcake/laravel-cors ^3.0 -> satisfiable by fruitcake/laravel-cors[v3.0.0, 3.0.x-dev]. - fruitcake/laravel-cors[v3.0.0, ..., 3.0.x-dev] require illuminate/support ^6|^7|^8|^9 -> found illuminate/support[v6.0.0, ..., 6.x-dev, v7.0.0, ..., 7.x-dev, v8.0.0, ..., 8.x-dev, v9.0.0-beta.1, ..., 9.x-dev] but these were not loaded, likely because it conflicts with another require.

You can also try re-running composer require with an explicit version constraint, e.g. "composer require fruitcake/laravel-cors:\*" to figure out if any version is installable, or "composer require fruitcake/laravel-cors:^2.1" if you know which you need.

Organiserles ests de remplacement de fichiers et création

ester la création et la modif d'épisode
Mirgrer sur Mysql
Tester une sauvegrde de la DB
Appeler le backend depuis le front

To do: update handelPodcastIdChange

Make the form for updating episodes

## Developper notes

A middleware was added to displaye requests on laravel.logs

## Ajouter à la vue de création des épisodes la fonctionnalité d'insertion dynamique de thèmes.

-> Mettre le form d'ajout de tag dans une div sans form et la monter
-> Vérifier les tags nouvellement créés

## Ajouter créer la vue update episode, et ajouter les liens permettant de s'y rendre depuis episode list et episode single display.

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

Mettre .env dans gitignore et tous les seeders comportant des données sensibles

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
