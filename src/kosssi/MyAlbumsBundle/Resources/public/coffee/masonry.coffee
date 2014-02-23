class MyMasonry
    @container
    @containerShow
    @msnry

    constructor: (selectorList, selectorShow) ->
        @container = document.querySelector selectorList
        @containerShow = document.querySelector selectorShow
        @init()

    init: ->
        @load()
        return this

    load: ->
        imgLoad = imagesLoaded @container
        imgLoad.on 'progress', (instance, image) =>
            if image.isLoaded
                element = image.img.parentNode
            @containerShow.appendChild element
        imgLoad.on 'always', (instance) =>
            @active()
        return this

    addElement: (element) ->
        @containerShow.appendChild element
        @msnry.appended element
        return this

    active: ->
        @msnry = new Masonry(@containerShow, {
            containerStyle: null,
            gutter: 0,
        });
        return this

    deactivate: ->
        if @msnry != undefined
            @msnry.destroy()
        return this
