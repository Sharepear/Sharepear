class Album
    container: ''
    selector:  ''
    elements:  []
    pictures:  []
    sizes:     []
    createImage: false

    constructor: (@container, @selector, @sizes, @createImage) ->
        @elements = $(@container).find(@selector)
        @screenSizeChange()
        $(window).resize =>
            @screenSizeChange()

    screenSizeChange: ->
        width = $(@elements).first().width()
        height = $(@elements).first().height()
        maxSize = Math.min width, height

        sizeName = ''
        for size in @sizes
            sizeName = size.name  if size.value > maxSize and sizeName == ''

        @setSize(element, sizeName) for element in @elements

    setSize: (element, sizeName) ->
        element = $(element)
        url = element.data(sizeName)
        picture = element.find('img')
        if picture.length == 0
            element.append($('<img src="' + url + '" alt="" />'))
        else
            picture.first().attr('src', url);

album = new Album(".album", "> li", [
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
], true)

$(".remove-album a").click (e) ->
    e.preventDefault();
    $(".remove-album button").click()
