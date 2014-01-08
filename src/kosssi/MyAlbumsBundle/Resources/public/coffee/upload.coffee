$(".show-upload").click (e) ->
    e.preventDefault();
    $(".show-upload span").toggle()
    $(".upload").toggle "show"
