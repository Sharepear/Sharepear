$(".show-upload").click (e) ->
    e.preventDefault();
    if ($(".show-upload .fa-minus").is(":visible") && $(".upload .dz-preview").length > 0)
        window.location.reload()
    else
        $(".show-upload span").toggle()
        $(".upload").toggle "show"
