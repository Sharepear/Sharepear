$(".show-sign-in").click (e) ->
  e.preventDefault();
  e.stopPropagation()
  $(".login").toggleClass('open')
  if ($(".login").hasClass('open'))
    $("#username").focus()
