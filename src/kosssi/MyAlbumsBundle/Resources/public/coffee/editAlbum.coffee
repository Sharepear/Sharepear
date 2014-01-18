class EditAlbum
    container: ''
    title:     ''
    element:   []

    constructor: (container) ->
        @container = $(container)
        @element = @container.find('input')

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
                @container.find('h1').html html # j'affiche cette réponse
                @container.removeClass('change')

editAlbum = new EditAlbum(".edit-album")
