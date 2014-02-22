class Album
    container: ''
    selector:  ''
    elements:  []
    pictures:  []
    sizes:     []
    createImage: false

    constructor: (@container, @selector, @sizes, @createImage) ->
        @elements = $(@container).find @selector
        @screenSizeChange()
        $(window).resize =>
            @screenSizeChange()

    screenSizeChange: ->
        sizeName = @getSizeName $(@elements).first()
        @setSize(element, sizeName) for element in @elements
        if myMasonry
            myMasonry.deactivate()
            myMasonry.active()

    setSize: (element, sizeName) ->
        element = $ element
        url = element.data sizeName
        picture = element.find 'img'
        if picture.length == 0
            element.append $('<img src="' + url + '" alt="" />')
        else
            picture.first().attr 'src', url

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

album = new Album(".album", "> li", filters, true)

$(".remove-album a").click (e) ->
    e.preventDefault();
    $(".remove-album button").click()
