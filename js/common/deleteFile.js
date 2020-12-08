/*
 * var jsParams = array(
 *    DeleteFileMsg => '...'
 *    );
 * 
 */
function deleteFile(baseId, a) {
    var $a = $(a);
    var $msg = $("<span class='deleteObjectNote'>" + jsParams['DeleteFileMsg'] + "</span>");
    var $img = $('#' + baseId + '_img');
    if ($img.length > 0) {
        $a.parent().html($msg);
        $img.remove();
    }
    var $id = $('#' + baseId + '_id');
    if ($id.length > 0) {
        $id.remove();
    }
    var $temp_name = $('#' + baseId + '_temp_name');
    if ($temp_name.length > 0) {
        $temp_name.remove();
    }
    var $link = $('#' + baseId + '_link');
    if ($link.length > 0) {
        $link.before($msg);
        $link.remove();
    }
    $a.remove();
    return true;
}

function ShowNextContentFile() {
    var $div = $("div.hidden[name='content_files_div']").first();
    $div.removeClass('hidden');
}

function ShowNextAdditionalFile(i) {
    var $div = $("div.hidden[name='pf_field" + i + "_files_div']").first();
    $div.removeClass('hidden');
}

function ShowNextFile(attr) {
    var $div = $("div.hidden[name='" + attr + "_div']").first();
    $div.removeClass('hidden');
}

