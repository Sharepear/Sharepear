container = document.querySelector('#album');
imagesLoaded container, ->
    $("#loader").remove()
    $('#album').show()
    albumMasonry = new Masonry("#album")
    albumMasonry.bindResize()
