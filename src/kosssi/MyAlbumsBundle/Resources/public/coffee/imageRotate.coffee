class ImageRotate
    selector: ''
    elements: {}
    masonry:  {}

    constructor: (@selector, @masonry) ->
        @elements = $(@selector);
        @bindClick()

    rotate: ($element) ->
        _this = this
        parent = $element.parents('[data-orientation]')
        $img = $(parent.find('img'))

        if typeof $img.data('src') == 'undefined'
            $img.data 'src', $img.attr('src')

        $.ajax
            url: $element.attr("href")
            success: (html) =>
                if html == 'ok'
                    $img.load ->
                        _this.masonry.update()
                    $img.attr 'src', $img.data('src') + '?' + new Date().getTime();
        return this

    addElement: ->
        @elements = $ @selector;
        @bindClick()
        return this

    bindClick: ->
        _this = this
        @elements.on 'click', (e) ->
            e.preventDefault()
            console.log 'test'
            _this.rotate $(this)
        return this
