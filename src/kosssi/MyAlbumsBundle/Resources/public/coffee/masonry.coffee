container = document.querySelector('#album');
imagesLoaded container, ->
    albumMasonry = new Masonry("#album")
    albumMasonry.bindResize()
