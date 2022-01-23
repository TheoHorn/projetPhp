# My WishList
## Table des matières
1. [Information](#information)
2. [Technologies](#technologies)
3. [Installation](#installation)
4. [Fonctionnalités](#fonctionnalités)

## Information
***
MyWishList.app est une application en ligne pour créer, partager et gérer des listes de cadeaux.
L'application permet à un utilisateur de créer une liste de souhaits à l'occasion d'un événement
particulier (anniversaire, fin d'année, mariage, retraite …) et lui permet de diffuser cette liste de
souhaits à un ensemble de personnes concernées. Ces personnes peuvent alors consulter cette liste
et s'engager à offrir 1 élément de la liste. Cet élément est alors marqué comme réservé dans cette
liste.

## Technologies
***
Quelques technologies utilisées dans le projet :
* [Slim](https://www.slimframework.com/docs/v3/): Version 3.*
* [Composer](https://getcomposer.org/): Version 2.1.14

## Installation
### Local
***
Afin d'installer le projet MyWishList sur votre ordinateur personnel, il est nécessaaire de posséder 
un logiciel permettant de mettre en place un serveur Web local tel que [Xampp](https://www.apachefriends.org/fr/index.html).
Ensuite il vous faudra cloner ce projet dans le dossier __C:\xampp\htdocs__.
Une fois cela fait lancer __Xampp__ et démarer les modules __Apache__ et __MySQL__.
***
![Image text](https://i.imgur.com/XEbjRxJ.png)
***
Il vous faudra ensuite cliquer sur le bouton __Admin__ du module __MySQL__ et créer une nouvelle base de données que vous nomerez comme
bon vous semble.
Une fois cela fait, récuperer le jeu de données contenu dans le fichier __rendu.txt__, copier le et coller le texte dans l'onglet __SQL__ de votre nouvelle base
puis exécuter le.
Créer un nouvel utilisateur comme si dessous en complétant les champs nécessaires.
![Image text](https://i.imgur.com/JAL00KW.png)
***
Pour finir dans les fichiers du projet précédemment cloner, rendez-vous dans src/conf et créez un fichier __conf.ini dans lequel vous entrerez les informations suivantes :
```
driver = mysql
host = localhost
database = (nom de votre base précédemment créer)
username = (nom de l'utilisateur précédemment créer)
password = (mot de passe de l'utilisateur précédemment créer)
charset = utf8
collation = utf8_unicode_ci
```
## Fonctionnalités

Liste des fonctionnalités et de leur(s) créateur(s) :

- Afficher une liste de souhaits      : Remi / Théo (merge de 2 versions)
- Afficher un item d'une liste        : Remi / Théo (        ""         )
- Réserver un item                    : Remi
- Ajouter un message avec réservation : Remi
- Créer une liste                     : Jocelyn
- Modifier les infos générales liste  : Théo
- Ajouter des items                   : Théo / Louis
- Modifier/Supprimer un item          : Théo
- Images avec item                    : Théo
- Partager une liste                  : Théo
- Créer un compte                     : Maxime / Louis
- S'authentifier                      : Maxime
- Modifier son compte                 : Maxime
- Rendre une liste publique           : Maxime
- Afficher les listes publiques       : Maxime
- Joindre des listes à son compte     : Théo
- Liste des créateurs                 : Théo
