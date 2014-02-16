class ImageFullscreen
    selector: ''
    container: ''
    containers: {}
    elements: {}

    constructor: (container, containers, @selector) ->
        @container = $ container
        @containers = $ containers
        for element in @containers
            @addFullscreen element
        $(window).resize =>
            imageResponsive.update()

    addFullscreen: (element) ->
        element = $ element
        @open element

    open: (element) ->
        btn = element.find @selector
        btn.one 'click', (e) =>
            e.preventDefault()
            e.stopPropagation()
            @show element
            @close element

    close: (element) ->
        element.one 'click', (e) =>
            @hide element
            @open element

    show: (element) ->
        myMasonry.deactivate()
        @container.addClass 'fullscreen'
        element.addClass 'current'
        imageResponsive.update()

    hide: (element) ->
        @container.removeClass 'fullscreen'
        element.removeClass 'current'
        imageResponsive.desactivate()
        myMasonry.active()


imageFullscreen = new ImageFullscreen "#albumShow", ".album > li", "img"
