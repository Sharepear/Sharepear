class ImageRotate
    selector: ''
    elements: {}

    constructor: (@selector) ->
        @elements = $ @selector
        @bindClick()

    rotate: ($element) ->
        parent = $element.parents('[data-orientation]')
        $img = $(parent.find('img'))

        if typeof $img.data('src') == 'undefined'
            $img.data 'src', $img.attr('src')

        $.ajax
            url: $element.attr("href")
            success: (html) =>
                $li = $img.parents('ul').parents('li');
                $li.remove('picture')
                $li.append(html);
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
            _this.rotate $(this)
        return this

#imageRotateRight = new ImageRotate '.imageRotateRight'
#imageRotateLeft  = new ImageRotate '.imageRotateLeft'
