MyAlbums
========

| Service       | Badge         |
| ------------- |:-------------:|
| Travis | [![Build Status](https://travis-ci.org/chlorius/MyAlbums.svg?branch=master)](https://travis-ci.org/chlorius/MyAlbums) |
| Coveralls | [![Coverage Status](https://coveralls.io/repos/chlorius/MyAlbums/badge.png?branch=master)](https://coveralls.io/r/chlorius/MyAlbums?branch=master) |
| Scrutinizer (Quality score) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chlorius/MyAlbums/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chlorius/MyAlbums/?branch=master) |
| Scrutinizer (Coverage) | [![Code Coverage](https://scrutinizer-ci.com/g/chlorius/MyAlbums/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/chlorius/MyAlbums/?branch=master) |
| VersionEye (PHP) | [![Dependency Status](https://www.versioneye.com/user/projects/538fc3c146c4733233000016/badge.svg)](https://www.versioneye.com/user/projects/538fc3c146c4733233000016) |
| VersionEye (Gem) | [![Dependency Status](https://www.versioneye.com/user/projects/5398334d83add738da000036/badge.svg)](https://www.versioneye.com/user/projects/5398334d83add738da000036) |
| VersionEye (Node) |  [![Dependency Status](https://www.versioneye.com/user/projects/53ed31ec13bb067b970000a9/badge.svg)](https://www.versioneye.com/user/projects/53ed31ec13bb067b970000a9) |
| VersionEye (Bower) | [![Dependency Status](https://www.versioneye.com/user/projects/53a40e9f83add7e81a000031/badge.svg)](https://www.versioneye.com/user/projects/53a40e9f83add7e81a000031) |
| Insight | [![SensioLabsInsight](https://insight.sensiolabs.com/projects/b57f6541-c800-43dc-a563-3bc43aa9663b/big.png)](https://insight.sensiolabs.com/projects/b57f6541-c800-43dc-a563-3bc43aa9663b) |

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
- picture : http://unsplash.com/

## Installation

    git clone git@github.com:chlorius/MyAlbums.git
    cd MyAlbums
    cp app/config/parameters.yml.dist app/config/parameters.yml
    composer install
    app/console doctrine:database:create
    app/console doctrine:migration:migrate -n
    app/console assets:install --symlink
    npm install
    node_modules/.bin/grunt

## Réinitialiser

    app/console doctrine:database:drop --force
    app/console doctrine:database:create
    app/console doctrine:migration:migrate -n

## Commande Grunt

- grunt : pour compiler automatiquement les fichiers LESS et COFFEE
- grunt server : il y a le watch sur l'ensemble des fichiers générés et le serveur PHP de lancé
- grunt live : il y a le livereload en plus de 'grunt server'

## Déploiement

Le déploiement se fait depuis votre machine local.
Il faut avoir renseigné dans dans le fichier hosts (/etc/hosts) deux domain :

- sharepear.dev 10.0.0.177 : pour la vagrant
- sharepear.prod ?.?.?.? : pour votre production

    bundle install
    bundle exec cap vagrant deploy
    bundle exec cap prod deploy
