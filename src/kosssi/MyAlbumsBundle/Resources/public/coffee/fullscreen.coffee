class ImageFullscreen
    selector:        ''
    container:       ''
    containers:      {}
    elements:        {}
    masonry:         {}
    imageResponsive: {}

    constructor: (container, containers, @selector, @masonry, @imageResponsive) ->
        @container = $ container
        @containers = $ containers
        for element in @containers
            @addFullscreen element
        $(window).resize =>
            @imageResponsive.update()

    addFullscreen: (element) ->
        element = $ element
        @open element
        return this

    open: (element) ->
        btn = element.find @selector
        btn.one 'click', (e) =>
            e.preventDefault()
            e.stopPropagation()
            @show element
            @close element
        return this

    close: (element) ->
        element.one 'click', (e) =>
            @hide element
            @open element
        return this

    show: (element) ->
        @masonry.deactivate()
        @container.addClass 'fullscreen'
        element.addClass 'current'
        @imageResponsive.update()
        return this

    hide: (element) ->
        @container.removeClass 'fullscreen'
        element.removeClass 'current'
        @imageResponsive.desactivate()
        @masonry.active()
        return this
