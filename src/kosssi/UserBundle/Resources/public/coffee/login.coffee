$("#btn_login").click ->
  $(this).parent().toggleClass('open')
  if ($(this).parent().hasClass('open'))
    $("#username").focus()
