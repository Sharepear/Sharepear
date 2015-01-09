initPhotoSwipeFromDOM = (gallerySelector) ->

  # parse slide data (url, title, size ...) from DOM elements
  # (children of gallerySelector)
  parseThumbnailElements = (el) ->
    thumbElements = el.childNodes
    numNodes = thumbElements.length
    items = []
    figureEl = undefined
    linkEl = undefined
    size = undefined
    item = undefined
    i = 0

    while i < numNodes
      figureEl = thumbElements[i] # <figure> element

      # include only element nodes
      if figureEl.nodeType isnt 1
        i++
        continue
      linkEl = figureEl.children[0] # <a> element
      size = linkEl.getAttribute("data-size").split("x")

      # create slide object
      item =
        src: linkEl.getAttribute("href")
        w: parseInt(size[0], 10)
        h: parseInt(size[1], 10)


      # <figcaption> content
      item.title = figureEl.children[1].innerHTML  if figureEl.children.length > 1

      # <img> thumbnail element, retrieving thumbnail url
      item.msrc = linkEl.children[0].getAttribute("src")  if linkEl.children.length > 0
      item.el = figureEl # save link to element for getThumbBoundsFn
      items.push item
      i++
    items


  # find nearest parent element
  closest = closest = (el, fn) ->
    el and ((if fn(el) then el else closest(el.parentNode, fn)))


  # triggers when user clicks on thumbnail
  onThumbnailsClick = (e) ->
    e = e or window.event
    (if e.preventDefault then e.preventDefault() else e.returnValue = false)
    eTarget = e.target or e.srcElement

    # find root element of slide
    clickedListItem = closest(eTarget, (el) ->
      el.tagName and el.tagName.toUpperCase() is "FIGURE"
    )
    return  unless clickedListItem

    # find index of clicked item by looping through all child nodes
    # alternatively, you may define index via data- attribute
    clickedGallery = clickedListItem.parentNode
    childNodes = clickedListItem.parentNode.childNodes
    numChildNodes = childNodes.length
    nodeIndex = 0
    index = undefined
    i = 0

    while i < numChildNodes
      if childNodes[i].nodeType isnt 1
        i++
        continue
      if childNodes[i] is clickedListItem
        index = nodeIndex
        break
      nodeIndex++
      i++

    # open PhotoSwipe if valid index found
    openPhotoSwipe index, clickedGallery  if index >= 0
    false


  # parse picture index and gallery index from URL (#&pid=1&gid=2)
  photoswipeParseHash = ->
    hash = window.location.hash.substring(1)
    params = {}
    return params  if hash.length < 5
    vars = hash.split("&")
    i = 0

    while i < vars.length
      unless vars[i]
        i++
        continue
      pair = vars[i].split("=")
      if pair.length < 2
        i++
        continue
      params[pair[0]] = pair[1]
      i++
    params.gid = parseInt(params.gid, 10)  if params.gid
    return params  unless params.hasOwnProperty("pid")
    params.pid = parseInt(params.pid, 10)
    params

  openPhotoSwipe = (index, galleryElement, disableAnimation) ->
    pswpElement = document.querySelectorAll(".pswp")[0]
    gallery = undefined
    options = undefined
    items = undefined
    items = parseThumbnailElements(galleryElement)

    # define options (if needed)
    options =
      index: index

    # define gallery index (for URL)
      galleryUID: galleryElement.getAttribute("data-pswp-uid")
      getThumbBoundsFn: (index) ->

        # See Options -> getThumbBoundsFn section of documentation for more info
        thumbnail = items[index].el.getElementsByTagName("img")[0] # find thumbnail
        pageYScroll = window.pageYOffset or document.documentElement.scrollTop
        rect = thumbnail.getBoundingClientRect()
        x: rect.left
        y: rect.top + pageYScroll
        w: rect.width

    options.showAnimationDuration = 0  if disableAnimation


    # Pass data to PhotoSwipe and initialize it
    gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options)
    gallery.init()
    return


  # loop through all gallery elements and bind events
  galleryElements = document.querySelectorAll(gallerySelector)
  i = 0
  l = galleryElements.length

  while i < l
    galleryElements[i].setAttribute "data-pswp-uid", i + 1
    galleryElements[i].onclick = onThumbnailsClick
    i++

  # Parse URL and open gallery if it contains #&pid=3&gid=1
  hashData = photoswipeParseHash()
  openPhotoSwipe hashData.pid - 1, galleryElements[hashData.gid - 1], true  if hashData.pid > 0 and hashData.gid > 0
  return


# execute above function
initPhotoSwipeFromDOM ".pictures.show"