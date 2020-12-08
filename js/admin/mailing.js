function showHideDiv(divId, link) {
    var $div = $('#' + divId);
    var display = $div.css('display');
    if (display == 'block') {
        $div.css('display', 'none');
    } else {
        $div.css('display', 'block');
    };   
}
