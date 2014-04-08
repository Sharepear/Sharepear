class ImageFullscreen
    container:       ''
    imageResponsive: {}

    constructor: (container, selector) ->
        @container = document.querySelector container

        [].forEach.call document.querySelectorAll(selector), (element) =>
            @addElement element
            return

        @container.addEventListener 'click', =>
            @hide()

    show: (element) ->
        @container.innerHTML = element.outerHTML
        @container.querySelector('li').removeAttribute 'style'
        @imageResponsive = new ImageResponsive '#fullscreenContent > li', filters
        @container.className = 'fullscreen';
        return this

    hide: () ->
        @container.className = '';
        @container.innerHTML = ''
        return this

    addElement: (element) ->
        element.addEventListener 'click', =>
            @show element
        , false
        return this
