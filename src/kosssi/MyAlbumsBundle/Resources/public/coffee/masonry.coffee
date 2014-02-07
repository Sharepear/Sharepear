class MyMasonry
    @container
    @containerShow

    constructor: (selectorList, selectorShow) ->
        @container = $ selectorList
        @containerShow = $ selectorShow
        @containerShow.masonry()
        if @container.length > 0
            imgLoad = imagesLoaded @container
            imgLoad.on 'progress', (instance, image) =>
                if image.isLoaded
                    element = $(image.img).parent()
                    @addElement element
                    return
            return
        else
            $(".show-upload").click()

    addElement: (element) ->
        @containerShow.append element
        @containerShow.masonry 'appended', element
        @containerShow.masonry()

myMasonry = new MyMasonry('#albumList', '#albumShow')
