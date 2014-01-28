class ImageFullscreen
    selector: ''
    elements: {}

    constructor: (@selector) ->
        @elements = $ @selector
        for element in @elements
            @addFullscreen element

    addFullscreen: (element) ->
        element = $ element
        element.click (e) ->
            e.preventDefault()
            $.ajax
                url: $(this).attr("href") # le nom du fichier indiqué dans le formulaire
                success: (html) => # je récupère la réponse du fichier PHP
                    content = $ "#fullscreenContent"
                    content.html(html).show()
                    imageResponsive.update()
                    content.find(".removeFullscreen").click (e) ->
                        e.preventDefault()
                        content.hide().html ""

imageFullscreen = new ImageFullscreen(".imageFullscreen")
