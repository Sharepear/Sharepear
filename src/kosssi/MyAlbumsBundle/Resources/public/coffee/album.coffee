class Album
    container: ''
    selector:  ''
    pictures:  []
    sizes:     []
    createImage: false

    constructor: (@container, @selector, @sizes, @createImage) ->
        @pictures = $(@container).find(@selector)
        @screenSizeChange()
        $(window).resize =>
            @screenSizeChange()

    screenSizeChange: ->
        width = $(@pictures).first().width()
        height = $(@pictures).first().height()
        maxSize = Math.min width, height

        sizeName = ''
        for size in @sizes
            sizeName = size.name  if size.value > maxSize and sizeName == ''

        @setSize(picture, sizeName) for picture in @pictures

    setSize: (picture, sizeName) ->
        picture = $(picture)
        url = picture.data(sizeName)
        if @createImage
            picture.html($('<img src="' + url + '" alt="" />'))
        else
            picture.css "background-image", "url(" + url + ")"

album = new Album(".album", "li", [
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
