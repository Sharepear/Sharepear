Dropzone.options.myDropzone =
    # Prevents Dropzone from uploading dropped files immediately
    autoProcessQueue: false
    init: ->
        submitButton = document.querySelector("#submit-all")
        myDropzone = this # closure
        submitButton.addEventListener "click", ->
            myDropzone.processQueue() # Tell Dropzone to process all queued files.

        # You might want to show the submit button only when
        # files are dropped here:
        @on "addedfile", ->
            # Show submit button here and/or inform user to click it.
