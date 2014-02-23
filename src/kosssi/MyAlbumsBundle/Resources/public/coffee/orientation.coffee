class Orientation
    portrait:    'portrait'
    landscape:   'landscape'
    orientation: ''
    element:     {}

    constructor: (element = 'body') ->
        @element = $ element
        @setOrientation()

        # Listen for resize changes
        window.addEventListener "resize", (=>
            @setOrientation()
            return
        ), false

    setOrientation: ->
        orientation = if window.innerHeight > window.innerWidth then @portrait else @landscape

        if @orientation != orientation
            if @isPortrait orientation
                @orientation = @portrait
                @element.removeClass @landscape
            else
                @orientation = @landscape
                @element.removeClass @portrait

            @element.addClass @orientation
        return this

    isLandscape: (orientation = @orientation) ->
        return orientation == @landscape

    isPortrait: (orientation = @orientation) ->
        return orientation == @portrait
