# Readme destiné aux contributeurs

Vous souhaitez contribuer à Evalbook ? Super ! Mais il y a quelques règles à suivre, voyons ça ensemble.


## Généralités.
* Webpack est utilisé pour packer les sources js, css, sass, etc...
* Yarn est utlisé comme gestionnaire de dépendances, n'utilisez surtout pas npm pour Evalbook.
* Pour bien démarrer, un coups de *composer install* ainsi qu'un *yarn install*
* Des scripts sont à votre disposition dans la section Webpack qui va bien :-)


## Base de données et configuration
Il est important de <span style="color:blue">**ne pas toucher au fichier .env**</span> se situant à la racine du projet, ce fichier est destiné à être utilisé en production.

Si vous avez besoin de spécifier vos accès à MySQL, MariaDb ou encore PostgreSQL, alors:
* Créez un fichier **.env.local**,
* Pour des raisons de sécurité évidentes, ajoutez le aux fichiers exclus de git (.gitignore),
* Copiez les informations reprises dans le fichier **.env**,
* Adaptez les diverses informations en fonction de vos paramètres locaux de développemet.

:warning: <span style="color:red">**N'oubliez pas d'insérer les informations de connexion à votre base de données AVANT d'aller plus loin !**</span>


## Installer les dépendances

Dans la console:

1. Installation des packages composer - Symfony
```shell
$ composer install
```

2. Installation des node modules.
```shell
$ yarn install
```

3. Si la base de données n'existe pas encore, il faudra la créer à l'aide de la commande:
```shell
$ php bin/console doctrine:database:create
```

4. Si le dossier **migrations** est vide ou si vous souhaitez être sûr de disposer de la dernière version de la migration:
```shell
$ php bin/console make:migration
```

5. Enfin, il faudra effectuer la migration de manière à ce que les tables soient 'installées' dans la base de données:
```shell
$ php bin/console doctrine:migrations:migrate
```

Un script que vous pourrez utiliser pour faire tout ca automatiquement sera fourni sous peu.



## Rouler le serveur en mode dev

Démarrez une console et entrez les commandes suivantes (mode dev)

1. Pour les assets:

```shell
$ yarn run dev
```

**OU**, pour 'recompiler' à chaque changement d'un asset:

```shell
$ yarn watch
```

2. Pour le serveur php

2. Installation des packages composer - Symfony
```shell
$ php -S localhost:8000 -t public/
```

**OU**, si vous disposez du binaire Symfony:

```shell
$ symfony serve
```
