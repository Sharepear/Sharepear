class ImageRotate
    selector: ''
    elements: {}
    masonry:  {}

    constructor: (@selector, @masonry) ->
        _this = this
        @elements = $(@selector);

        @elements.on 'click', (e) ->
            e.preventDefault()
            _this.rotate $(this)
        return

    rotate: ($element) ->
        _this = this
        parent = $element.parents('[data-orientation]')
        parent.resize ->
            _this.masonry.update()

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
