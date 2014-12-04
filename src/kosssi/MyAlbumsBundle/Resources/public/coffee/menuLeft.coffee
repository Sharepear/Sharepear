$('.btn-menu-item').click (e)->
  e.preventDefault()
  e.stopPropagation()
  $(this).parent().find('.menu-item').toggleClass('show').find('input').focus();

$('.menu-item input').focusout ->
  $(this).parents('.menu-item').removeClass('show')

$('.menu-item form').submit (e)->
  e.preventDefault()
  e.stopPropagation()
  document.location.href = $(this).data('url').replace('__SEARCH__', $(this).find('input').val());
