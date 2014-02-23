class ImageResponsive
    selector: ''
    elements: {}
    sizes:    []

    constructor: (@selector, @sizes) ->
        @update()

        $(window).resize =>
            @update()

    getSizeName: (element) ->
        maxSize = element.width()
        sizeName = ''
        for size in @sizes
            if size.value > maxSize and sizeName == ''
                sizeName = size.name
        if sizeName == ''
            return @sizes[@sizes.length - 1].name
        else
            return sizeName

    updateSize: (element) ->
        element = $ element
        sizeName = @getSizeName element
        if sizeName != element.data 'actual-size'
            url = element.data sizeName
            element.css 'background-image', 'url(' + url + ')'
            element.data 'actual-size', sizeName
        return this

    update: ->
        @elements = $ @selector
        for element in @elements
            @updateSize element
        return this

    desactivate: ->
        for element in @elements
            element.removeAttribute 'style'
            $(element).data 'actual-size', ''
        @update()
        return this
