Dropzone.options.myDropzone =
  success: (file, response) ->
    $('.list-btn .visually-hidden').removeClass 'visually-hidden'
    return file.previewElement.classList.add "dz-success"