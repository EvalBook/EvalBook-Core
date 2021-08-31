# Readme destiné aux contributeurs

Vous souhaitez contribuer à Evalbook ? Super ! Mais il y a quelques règles à suivre, voyons ça ensemble.


## Généralités.
* Webpack est utilisé pour packer les sources js, css, sass, etc...
* Yarn est utlisé comme gestionnaire de dépendances, n'utilisez surtout pas npm pour Evalbook.
  Si vous ne disposez pas encore de yarn, vous pouvez l'installer facilement à l'aide du terminal et de npm en entrant la commande suivante:
```shell
$ npm install --global yarn

# Pou tester l'installation, utilisez la commande suivante
$ yarn --version
```

### Choix de la version de PHP.
La version choisie est la version **>= 8.0**, bien que certains gros hébergeurs ne supportent pas encore (à tort) PHP8.0,
nous avons fais le choix de la stabilité en choisissant un version supportée pour au moins les 4 prochaines années.
Si vous souhaitez connaître un hébergeur performant et supportant PHP8.0, contactez nous, nous serions ravis de vous aider !



## Base de données et configuration
Il est important de <span style="color:blue">**ne pas toucher au fichier .env**</span> se situant à la racine du projet, ce fichier est destiné à être utilisé en production.

Si vous avez besoin de spécifier vos accès à MySQL, MariaDb ou encore PostgreSQL, alors:
* Créez un fichier **.env.local**,
* Pour des raisons de sécurité évidentes, ajoutez le aux fichiers exclus de git (.gitignore),
* Copiez les informations reprises dans le fichier **.env**,
* Adaptez les diverses informations en fonction de vos paramètres locaux de développemet.

:warning: <span style="color:red">**N'oubliez pas d'insérer les informations de connexion à votre base de données AVANT d'aller plus loin !**</span>


## Installer les dépendances

Pour installer les dépendances, vous aurez le choix entre:
* Utiliser le script d'installation réalisé par nos soins (vous facilitera la vie)
* Utiliser la bonne vieille méthode manuelle


### <span style="color:blue">Méthode manuelle</span>

Dans la console - terminal

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


### <span style="color:blue">Méthode automatique avec notre script dev</span>:

Pour utiliser ce script, vous aurez besoin de disposer de yarn, mais si vous souhaitez contrinuer à EvalBook, vous devriez déjà l'avoir installé'
```shell
$ yarn evalbook-dev-install
```

Utilisez ce script si vous n'avez jamais importé EvalBook ou si vous utilisez une nouvelle branche. Vous devrez au préalable 
avoir entré les informations de connexion à la base de données dans le fichier .env.local

Pour information, voici ce que le script réalise poiur vous:
```json
{
  ...
  "bc": "php bin/console",
  "evalbook-dev-install": "composer install && yarn install && yarn bc d:d:c -n --if-not-exists && yarn bc d:m:m -n"
}
```

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
