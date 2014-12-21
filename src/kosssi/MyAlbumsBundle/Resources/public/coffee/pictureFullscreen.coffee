class PictureFullscreen
  container:       ''
  links:           {}
  nextBtn:         {}
  previewBtn:      {}
  nextBtn:         {}
  previewBtn:      {}
  imageResponsive: {}
  element:         {}

  constructor: (container, selector) ->
    @container = document.querySelector container
    @links = document.querySelector '.links-fullscreen'
    @nextBtn = document.querySelector '.show-next-picture'
    @previewBtn = document.querySelector '.show-before-picture'

    [].forEach.call document.querySelectorAll(container + ' ' + selector), (element) =>
      @addElement element
      return

    @nextBtn.addEventListener 'click', (e) =>
      e.preventDefault()
      e.stopPropagation()
      @next()

    @previewBtn.addEventListener 'click', (e) =>
      e.preventDefault()
      e.stopPropagation()
      @preview()

  show: (element) ->
    $(@links).removeClass 'visually-hidden'
    element.className = 'full'
    $('body').css 'overflow', 'hidden'
    return this

  hide: (element) ->
    $(@links).addClass 'visually-hidden'
    element.className = ''
    $('body').css 'overflow', 'auto'
    return this

  toggle: (@element) ->
    if element.className == 'full'
      @hide element
    else
      @show element

  addElement: (element) ->
    element.addEventListener 'click', =>
      @toggle element
      return false
    , false
    return this

  next: () ->
    elementRemove = @element
    @element = $(@element).parents('li').next('li').children('picture')[0]
    @show @element
    $(elementRemove).removeClass 'full'

  preview: () ->
    elementRemove = @element
    @element = $(@element).parents('li').prev('li').children('picture')[0]
    @show @element
    $(elementRemove).removeClass 'full'

pictureFullscreen = new PictureFullscreen '.pictures.show', 'picture'
pictureFullscreen2 = new PictureFullscreen '.pictures.edit', 'picture'
