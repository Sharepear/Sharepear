MyAlbums
========

Status : WIP

# Developpement

## Librairies utilisées

Au niveau javascript :
- jQuery : http://www.jquery.com
- DropzoneJS : http://www.dropzonejs.com

Au niveau PHP :
- OneupUploaderBundle : https://github.com/1up-lab/OneupUploaderBundle
- LiipImagineBundle : https://github.com/liip/LiipImagineBundle

## Installation

```
git clone git@github.com:chlorius/MyAlbums.git
cd MyAlbums
composer install
npm install
bower install
app/console doctrine:database:create
app/console doctrine:schema:create
app/console assets:install --symlink
grunt deploy
```

## Réinitialiser

```
app/console doctrine:database:drop --force
app/console doctrine:database:create
app/console doctrine:schema:create
```

## Commande Grunt

- grunt watch : pour compiler automatiquement les fichiers LESS et COFFEE
