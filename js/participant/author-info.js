function showAuthorInfo(id, link) {
    var $div = $('#author_info_' + id);
    $div.css('display', 'block');
    $div.next().remove();
    var $link = $(link);
    $link.remove();
}

