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

    update: ->
        @elements = $ @selector
        for element in @elements
            @updateSize element

    desactivate: ->
        for element in @elements
            element.removeAttribute 'style'
            $(element).data 'actual-size', ''
        @update()


imageResponsive = new ImageResponsive(".current", [
    name: "xs"
    value: 300
,
    name: "s"
    value: 480
,
    name: "m"
    value: 768
,
    name: "l"
    value: 992
,
    name: "xl"
    value: 1382
,
    name: "xxl"
    value: 1600
])
