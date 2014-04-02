class ImageRemove
    selector: ''
    elements: {}
    masonry:  {}

    constructor: (@selector, @masonry) ->
        @elements = $ @selector;
        @bindClick()

    remove: ($element) ->
        $.ajax
            url: $element.attr("href")
            success: (html) =>
                if html == 'ok'
                    @masonry.removeElement $element.parents('[data-orientation]')
                    @masonry.update()
        return this

    addElement: ->
        @elements = $ @selector;
        @bindClick()
        return this

    bindClick: ->
        _this = this
        @elements.on 'click', (e) ->
            e.preventDefault()
            _this.remove $(this)
        return this
