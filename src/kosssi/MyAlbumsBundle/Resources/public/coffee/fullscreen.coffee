class ImageFullscreen
    selector: ''
    containers: {}
    elements: {}

    constructor: (containers, @selector) ->
        @containers = $ containers
        for element in @containers
            @addFullscreen element

    addFullscreen: (element) ->
        element = $ element
        btn = element.find @selector
        btn.click (e) =>
            e.preventDefault()
            $.ajax
                url: $(btn).attr("href")
                success: (html) =>
                    element.addClass "fullscreen"
                    content = $ "#fullscreenContent"
                    content.html(html).show()
                    imageResponsive.update()
                    content.find('.show').removeClass('show')
                    content.find(".removeFullscreen").click (e) ->
                        e.preventDefault()
                        content.hide().html ""
                    return
        return

imageFullscreen = new ImageFullscreen("#albumList > li", ".imageFullscreen")
