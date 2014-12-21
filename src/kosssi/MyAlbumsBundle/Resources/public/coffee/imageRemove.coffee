class ImageRemove
    selector: ''
    elements: {}

    constructor: (@selector) ->
        @elements = $ @selector;
        @bindClick()

    remove: ($element) ->
        $.ajax
            url: $element.attr("href")
            success: (html) =>
                if html == 'ok'
                    $element.parents('ul').parents('li').remove()
        return this

    addElement: ->
        @elements = $ @selector;
        @bindClick()
        return this

    bindClick: ->
        _this = this
        @elements.on 'click', (e) ->
            e.preventDefault()
            e.stopPropagation()
            _this.remove $(this)
            return false
        return this

imageRemove = new ImageRemove '.imageRemove'
