$("ul.links a[data-icon]").click (e) ->
  e.preventDefault()
  e.stopPropagation()
  _this = this
  $("ul.links a[data-icon].show").each ->
    if _this != this
      $(this).click()
  $(this).toggleClass("show")
  if $(this).hasClass("show")
    $(this).find("i").removeClass($(this).data('icon')).addClass('fa-times')
  else
    $(this).find("i").removeClass('fa-times').addClass($(this).data('icon'))
