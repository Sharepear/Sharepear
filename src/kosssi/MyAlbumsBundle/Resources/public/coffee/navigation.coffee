class Navigation
    arrow:
        left: 37
        up: 38
        right: 39
        down: 40
        space: 32
    isPlay: false
    timeout: 3000
    container: ''
    selector: ''
    pictures: []
    current: ''

    constructor: (@container, @selector, @timeout, autoplay) ->
        @pictures = $(@container).find(@selector)
        @current = $(@pictures[0])
        @current.addClass('current');
        if autoplay
            @play
        #$(window).keydown (event) =>
        #    @keyDown event

    keyDown: (event) ->
        keyCode = event.keyCode or event.which
        switch keyCode
            when @arrow.right
                @nextPicture()
            when @arrow.left
                @prevPicture()
            when @arrow.down
                event.preventDefault()
                @nextPicture()
            when @arrow.up
                event.preventDefault()
                @prevPicture()
            when @arrow.space
                event.preventDefault()
                if @isPlay
                    @stop()
                else
                    @play()

    nextPicture: ->
        nextPicture = @current.next @selector
        if nextPicture.length == 1
            @current.hide()
            @current = nextPicture
            @current.show()

    prevPicture: ->
        prevPicture = @current.prev @selector
        if prevPicture.length == 1
            @current.hide()
            @current = prevPicture
            @current.show()

    play: ->
        if @isPlay
            @nextPicture()
        else
            @isPlay = true
        @playTimeout = setTimeout( =>
            @play()
        , @timeout)

    stop: ->
        @isPlay = false
        clearTimeout @playTimeout

# navigation = new Navigation(".album", "li", 3000, false)
