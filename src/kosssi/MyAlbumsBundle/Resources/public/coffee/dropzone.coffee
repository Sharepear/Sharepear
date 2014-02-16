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
