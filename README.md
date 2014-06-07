MyAlbums
========

| Service       | Badge         |
| ------------- |:-------------:|
| Travis | [![Build Status](https://travis-ci.org/chlorius/MyAlbums.svg?branch=master)](https://travis-ci.org/chlorius/MyAlbums) |
| Coveralls | [![Coverage Status](https://coveralls.io/repos/chlorius/MyAlbums/badge.png?branch=master)](https://coveralls.io/r/chlorius/MyAlbums?branch=master) |
| Scrutinizer | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chlorius/MyAlbums/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chlorius/MyAlbums/?branch=master) |
| VersionEye (PHP) | [![Dependency Status](https://www.versioneye.com/user/projects/538fc3c146c4733233000016/badge.svg?style=flat)](https://www.versioneye.com/user/projects/538fc3c146c4733233000016) |
| VersionEye (Node) | [![Dependency Status](https://www.versioneye.com/user/projects/538fc58146c47388ee000019/badge.svg)](https://www.versioneye.com/user/projects/538fc58146c47388ee000019) |
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

## Installation

```
git clone git@github.com:chlorius/MyAlbums.git
cd MyAlbums
cp app/config/parameters.yml.dist app/config/parameters.yml
composer install
app/console doctrine:database:create
app/console doctrine:schema:create
app/console assets:install --symlink
npm start
```

## Réinitialiser

```
app/console doctrine:database:drop --force
app/console doctrine:database:create
app/console doctrine:schema:create
```

## Commande Grunt

- grunt : pour compiler automatiquement les fichiers LESS et COFFEE
- grunt server : il y a le watch sur l'ensemble des fichiers générés et le serveur PHP de lancé
- grunt live : il y a le livereload en plus de 'grunt server'
