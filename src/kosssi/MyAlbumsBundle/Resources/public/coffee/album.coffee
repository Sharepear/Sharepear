class Album
    container: ''
    selector:  ''
    pictures:  []
    sizes:     []

    constructor: (@container, @selector, @sizes) ->
        @pictures = $(@container).find(@selector)
        @screenSizeChange()
        $(window).resize =>
            @screenSizeChange()

    screenSizeChange: ->
        width = $(@pictures).first().width()
        height = $(@pictures).first().height()
        maxSize = Math.min width, height

        typeAffichage == ''
        if maxSize == height
            typeAffichage = 'portrait'
        else
            typeAffichage = 'paysage'

        sizeName = ''
        for size in @sizes
            sizeName = size.name  if size.value > maxSize and sizeName == ''

        @setSize(picture, sizeName) for picture in @pictures

    setSize: (picture, sizeName) ->
        picture = $(picture)
        picture.css "background-image", "url(" + picture.data(sizeName) + ")"

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
])
