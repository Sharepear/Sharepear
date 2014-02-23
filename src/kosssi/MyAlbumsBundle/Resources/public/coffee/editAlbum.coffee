class EditAlbum
    container: ''
    title:     {}
    element:   {}

    constructor: (container) ->
        @container = $(container)
        @element = @container.find('input[type=text]')
        @title = $('h1')

        @element.keyup =>
            @container.addClass('change')

        @element.change =>
            @inputChange()

        @container.submit (e) =>
            e.preventDefault()
            @inputChange()

    inputChange: ->
        $.ajax
            url: @container.attr("action") # le nom du fichier indiqué dans le formulaire
            type: @container.attr("method") # la méthode indiquée dans le formulaire (get ou post)
            data: @container.serialize() # je sérialise les données (voir plus loin), ici les $_POST
            success: (html) => # je récupère la réponse du fichier PHP
                @title.html html # j'affiche cette réponse
                @container.removeClass('change')
                document.title = html;
