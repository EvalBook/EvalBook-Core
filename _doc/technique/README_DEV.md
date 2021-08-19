# Readme destiné aux contributeurs

Vous souhaitez contribuer à Evalbook ? Super ! Mais il y a quelques règles à suivre, voyons ça ensemble.

## Généralités.
* Webpack est utilisé pour packer les sources js, css, sass, etc...
* Yarn est utlisé comme gestionnaire de dépendences, n'utilisez surtout pas npm pour Evalbook.
* Pour bien démarrer, un coups de *composer install* ainsi qu'un *yarn install*
* Des scripts sont à votre disposition dans la section Webpack qui va bien :-)

## Base de données
Il est important de **ne pas toucher au fichier .env** se situant à la racine du projet, ce fichier est destiné à être utilisé en production. 

Si vous avez besoin de spécifier vos accès à MySQL, MariaDb ou encore PstgreSQL, alors créez un fichier **.env.local** et ajoutez le aux fichiers exclus de git (.gitignore)