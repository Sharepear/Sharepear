Dropzone.options.myDropzone =
    success: (file, response) ->
        $.ajax
            url: '/image/' + response.image
            success: (html) ->
                $('#albumList').append html
                album.addElement $ '#albumList > li'
                myMasonry.init()
        return file.previewElement.classList.add "dz-success";
