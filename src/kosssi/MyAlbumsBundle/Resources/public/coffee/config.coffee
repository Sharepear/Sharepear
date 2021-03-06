album = {}
editAlbum = {}
imageFullscreen = {}
orientation = {}
imageRemove = {}
imageRotateRight = {}
imageRotateLeft = {}
imagesLoader = {}
showAlbum = {}

$(document).ready ->
    if document.querySelectorAll('#albumShow').length > 0
        album            = new Album ".album", "> li", filters
        editAlbum        = new EditAlbum "form[name=album_name]"
        orientation      = new Orientation

        imageRotateRight = new ImageRotate '.imageRotateRight', myMasonry
        imageRotateLeft  = new ImageRotate '.imageRotateLeft', myMasonry
        imagesLoader     = new ImagesLoader '#albumList', myMasonry
        showAlbum        = new ShowAlbum '.album .actions'
        imageShare       = new ImageShare '.share'
        # navigation      = new Navigation ".album", "li", 3000, false

        $(".remove-album a").click (e) ->
            e.preventDefault();
            e.stopPropagation()
            $(".remove-album button").click()

        Dropzone.options.myDropzone =
            success: (file, response) ->
                $.ajax
                    url: '/image/' + response.image
                    success: (html) ->
                        $('#albumList').append html
                        element = $('#albumList > li').last()
                        album.addElement element
                        myMasonry.addElement element[0]
                        imageRemove.addElement
                        imageRotateRight.addElement
                        imageRotateLeft.addElement
                        imageFullscreen.addElement element[0]
                        showAlbum.addElement element[0]
                        imageShare.addElement element[0]
                return file.previewElement.classList.add "dz-success"
