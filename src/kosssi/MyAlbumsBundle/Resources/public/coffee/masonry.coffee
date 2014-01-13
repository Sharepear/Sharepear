$(document).ready ->
    container = $('#album');
    if container.length > 0
        imagesLoaded container, ->
            $("#loader").remove()
            $('#album').show()
            albumMasonry = new Masonry("#album")
            albumMasonry.bindResize()
    else
        $(".show-upload").click()
