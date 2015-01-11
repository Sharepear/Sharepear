class Ajax
  constructor: ->
    _this = this
    $('body').on 'click', 'a.ajax', (e) ->
      e.preventDefault()
      e.stopPropagation()
      _this.open this.href
    $('.ajaxFullScreen .close').click (e) ->
      e.preventDefault()
      e.stopPropagation()
      $(".ajaxFullScreen").hide()
    if $(".ajaxContainer").html() != ''
      $(".ajaxFullScreen").show()
  open: (url) ->
    $.get url, (data) ->
      $(".ajaxContainer").html data
      $('.close:visible .fa-times').click()
      $(".ajaxFullScreen").show()

ajax = new Ajax
