class ImageRemove
    selector: ''
    elements: {}
    masonry:  {}

    constructor: (@selector, @masonry) ->
        _this = this
        @elements = $(@selector);

        @elements.on 'click', (e) ->
            e.preventDefault()
            _this.remove $(this)
        return

    remove: ($element) ->
        $.ajax
            url: $element.attr("href")
            success: (html) =>
                if html == 'ok'
                    @masonry.removeElement $element.parents('[data-orientation]')
                    @masonry.update()
        return this
