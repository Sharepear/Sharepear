class ImageShare
    constructor: (selector) ->
        [].forEach.call document.querySelectorAll(selector), (element) =>
            @addElement element
            return

    addElement: (element) ->
        element.addEventListener 'click', (e) =>
            e.stopPropagation()
            e.preventDefault()
            $.ajax
                url: e.target.parentElement.href
                success: (html) =>
                    e.target.parentElement.innerHTML = html
        , false
        return this
