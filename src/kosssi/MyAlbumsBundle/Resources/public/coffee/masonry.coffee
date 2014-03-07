class MyMasonry
    @container
    @masonry

    constructor: (selectorShow) ->
        @container = document.querySelector selectorShow
        @masonry = new Masonry(@container, {
            containerStyle: null,
            gutter: 0,
        });
        @update()
        $(window).resize =>
            @update()

    addElement: (element) ->
        @container.appendChild element
        @masonry.appended element
        @update()
        return this

    removeElement: (element) ->
        @masonry.remove element
        return this

    update: ->
        @masonry.layout()
        return this
