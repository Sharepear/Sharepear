class Album
    container: ''
    selector:  ''
    elements:  []
    pictures:  []
    sizes:     []
    createImage: false
    masonry:   {}

    constructor: (@container, @selector, @sizes, @createImage, @masonry) ->
        @elements = $(@container).find @selector
        @screenSizeChange()
        $(window).resize =>
            @screenSizeChange()
        @masonry.init()
        @screenSizeChange()

    screenSizeChange: ->
        sizeName = @getSizeName $(@elements).first()
        @setSize(element, sizeName) for element in @elements
        @masonry.deactivate().active()
        return this

    setSize: (element, sizeName) ->
        element = $ element
        url = element.data sizeName
        picture = element.find 'img'
        if picture.length == 0
            element.append $('<img src="' + url + '" alt="" />')
        else
            picture.first().attr 'src', url
        return this

    getSizeName: (element) ->
        width = element.width()
        height = element.height()
        maxSize = Math.min width, height

        sizeName = ''
        for size in @sizes
            sizeName = size.name  if size.value > maxSize and sizeName == ''

        return sizeName

    addElement: (element) ->
        @elements = $(@container).find @selector
        sizeName = @getSizeName $ element
        @setSize element, sizeName
        return this
