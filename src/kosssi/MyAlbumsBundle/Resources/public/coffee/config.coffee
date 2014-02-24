myMasonry = {}
album = {}
editAlbum = {}
imageResponsive = {}
imageFullscreen = {}
orientation = {}

$(document).ready ->
    myMasonry       = new MyMasonry '#albumList', '#albumShow'
    album           = new Album ".album", "> li", filters, true, myMasonry
    editAlbum       = new EditAlbum "form[name=album_name]"
    imageResponsive = new ImageResponsive ".current", filters
    imageFullscreen = new ImageFullscreen "#albumShow", ".album > li", "img", myMasonry, imageResponsive
    orientation     = new Orientation
    # navigation      = new Navigation ".album", "li", 3000, false

    $(".remove-album a").click (e) ->
        e.preventDefault();
        $(".remove-album button").click()

    $(".show-upload").click (e) ->
        e.preventDefault();
        $(".show-upload span").toggle()
        $(".upload").toggle "show"

    Dropzone.options.myDropzone =
        success: (file, response) ->
            $.ajax
                url: '/image/' + response.image
                success: (html) ->
                    $('#albumList').append html
                    element = $('#albumList > li').last()
                    album.addElement element
                    imageFullscreen.addFullscreen element
                    myMasonry.init()
            return file.previewElement.classList.add "dz-success";

