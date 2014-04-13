class ShowAlbum
    constructor: (selector) ->
        [].forEach.call document.querySelectorAll(selector), (element) =>
            @addElement element
            return

    addElement: (element) ->
        element.addEventListener 'click', (e) =>
            e.stopPropagation()
        , false
        return this
