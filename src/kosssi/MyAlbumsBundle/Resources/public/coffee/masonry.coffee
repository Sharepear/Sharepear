albumMasonry = new Masonry("#album")
albumMasonry.bindResize()

$(document).ready ->
    albumMasonry.resize()
