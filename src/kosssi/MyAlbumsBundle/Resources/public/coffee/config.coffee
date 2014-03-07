myMasonry = {}
album = {}
editAlbum = {}
imageResponsive = {}
imageFullscreen = {}
orientation = {}
imageRemove = {}
imageRotateRight = {}
imageRotateLeft = {}
imagesLoader = {}

$(document).ready ->
    myMasonry        = new MyMasonry '#albumShow'
    album            = new Album ".album", "> li", filters
    editAlbum        = new EditAlbum "form[name=album_name]"
    imageResponsive  = new ImageResponsive ".current", filters
    imageFullscreen  = new ImageFullscreen "#albumShow", ".album > li", "img", myMasonry, imageResponsive
    orientation      = new Orientation
    imageRemove      = new ImageRemove '.imageRemove', myMasonry
    imageRotateRight = new ImageRotate '.imageRotateRight', myMasonry
    imageRotateLeft  = new ImageRotate '.imageRotateLeft', myMasonry
    imagesLoader     = new ImagesLoader '#albumList', myMasonry
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
                    myMasonry.addElement element[0]
                    imageFullscreen.addFullscreen element
            return file.previewElement.classList.add "dz-success";

