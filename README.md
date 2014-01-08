MyAlbums
========

Status : WIP

Board : https://waffle.io/chlorius/MyAlbums

# Developpement

## Librairies utilisées

Au niveau javascript :
- jQuery : http://www.jquery.com
- DropzoneJS : http://www.dropzonejs.com
- Masonry : http://masonry.desandro.com

Au niveau PHP :
- OneupUploaderBundle : https://github.com/1up-lab/OneupUploaderBundle
- LiipImagineBundle : https://github.com/liip/LiipImagineBundle

Design :
- http://tympanus.net/codrops/2012/11/06/gamma-gallery-a-responsive-image-gallery-experiment/
- http://tympanus.net/codrops/2013/07/02/loading-effects-for-grid-items-with-css-animations/
- http://tympanus.net/codrops/2012/06/18/3d-thumbnail-hover-effects/
- http://tympanus.net/codrops/2013/04/19/responsive-multi-level-menu/
- http://tympanus.net/codrops/2013/08/13/multi-level-push-menu/

## Installation

```
git clone git@github.com:chlorius/MyAlbums.git
cd MyAlbums
cp app/config/parameter.yml.dist app/config/parameter.yml
composer install
npm install
bower install
app/console doctrine:database:create
app/console doctrine:schema:create
app/console assets:install --symlink
grunt init
```

## Réinitialiser

```
app/console doctrine:database:drop --force
app/console doctrine:database:create
app/console doctrine:schema:create
```

## Commande Grunt

- grunt init : pour initialiser l'ensemble des taches
- grunt watch : pour compiler automatiquement les fichiers LESS et COFFEE en dev
