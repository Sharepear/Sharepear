class ImagesLoader
    @container
    @masonry

    constructor: (selectorList, @masonry) ->
        @container = document.querySelector selectorList
        @load()

    load: ->
        _this = this
        imgLoad = imagesLoaded @container
        imgLoad.on 'progress', (instance, image) ->
            if image.isLoaded
                element = image.img.parentNode
                _this.masonry.addElement element
            return
        return this
