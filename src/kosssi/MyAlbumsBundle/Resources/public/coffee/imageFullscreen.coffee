class ImageFullscreen
    container:       ''
    nextBtn:         {}
    previewBtn:      {}
    imageResponsive: {}
    element:         {}

    constructor: (container, selector) ->
        @container = document.querySelector container
        @nextBtn = document.querySelector '.show-next-picture'
        @previewBtn = document.querySelector '.show-before-picture'

        [].forEach.call document.querySelectorAll(selector), (element) =>
            @addElement element
            return

        @nextBtn.addEventListener 'click', (e) =>
            e.preventDefault()
            e.stopPropagation()
            @next()

        @previewBtn.addEventListener 'click', (e) =>
            e.preventDefault()
            e.stopPropagation()
            @preview()

        @container.addEventListener 'click', =>
            @hide()

    show: (@element) ->
        @container.innerHTML = element.outerHTML
        @container.querySelector('li').removeAttribute 'style'
        @imageResponsive = new ImageResponsive '#fullscreenContent > li', filters
        @container.className = 'fullscreen'
        if @element.nextSibling is null
            $(@nextBtn).parent().hide()
        else
            $(@nextBtn).parent().show()
        if @element.previousSibling is null
            $(@previewBtn).parent().hide()
        else
            $(@previewBtn).parent().show()
        return this

    hide: () ->
        @container.className = '';
        @container.innerHTML = ''
        $('.links').toggleClass('visually-hidden')
        return this

    next: () ->
        @show @element.nextSibling

    preview: () ->
        @show @element.previousSibling

    addElement: (element) ->
        element.addEventListener 'click', =>
            @show element
            $('.links').toggleClass('visually-hidden')
        , false
        return this
