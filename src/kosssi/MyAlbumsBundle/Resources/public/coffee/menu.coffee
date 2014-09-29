$(".show-menu").click (e) ->
  e.preventDefault();
  e.stopPropagation()
  $(".menu").toggleClass("show")
