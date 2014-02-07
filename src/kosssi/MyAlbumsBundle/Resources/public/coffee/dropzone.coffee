Dropzone.options.myDropzone =
    success: (file, response) ->
        console.log response.image
        return file.previewElement.classList.add "dz-success";
