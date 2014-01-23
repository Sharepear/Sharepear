$(document).ready ->
    container = $('#album');
    containerShow = $("#albumShow")
    containerShow.masonry()
    if container.length > 0
        imgLoad = imagesLoaded container
        imgLoad.on 'progress', (instance, image) ->
            if image.isLoaded
                element = $(image.img).parent()
                containerShow.append element
                containerShow.masonry 'appended', element
                containerShow.masonry()
                return
        return
    else
        $(".show-upload").click()
