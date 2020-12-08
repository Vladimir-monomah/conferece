/*
 * var jsParams = array(
 *    DeleteTopicMsg => '...',
 *    RevertMsg => '...',
 *    TopicsCount => 
 *    );
 * 
 */

/*  Копирует с актуальными значениями полей ввода
    Copies with actual values of input fields */
function copyDiv($divFrom, $divTo) {
    $divTo.html($divFrom.html());
    $divFrom.find("input").each(function(idx) {
        $divTo.find("input").eq(idx).val($(this).val());
    });
    $divFrom.find("textarea").each(function(idx) {
        $divTo.find("textarea").eq(idx).val($(this).val());
    });
}

function hideTopic(a) {
    var $a = $(a);
    var id = $a.parent().parent().attr('id').substring(3);
    var $div = $('#div' + id);
    if (id.indexOf('EmptyId') >= 0) {
        $div.remove();
    } else {
        var $hidden = $("<div id='hidden" + id + "' />");
        var $state = $('#state' + id);
        $state.val('deleted');
        copyDiv($div, $hidden);
        $div.css('text-align', 'center');
        $div.html('<span class="deleteObjectNote">' + jsParams['DeleteTopicMsg'] + ",</span> <a class='action' href='javascript:void(0)' onclick='showTopic(\"" + id + "\");' >" + jsParams['RevertMsg'] + "</a><br /><br />");
        $div.append($hidden);
        $hidden.hide();
    }
    return false;
}

function showTopic(id) {
    var $div = $('#div' + id);
    var $hidden = $('#hidden' + id);
    var $state = $('#state' + id);
    $state.val('updated');
    copyDiv($hidden, $div);
    return false;
}

var maxEmptyId = -1;
function getMaxEmptyId() {
    if (maxEmptyId == -1) {
        maxEmptyId = jsParams['TopicsCount'];
    }
    return maxEmptyId;
}

function createTopic() {
    var $emptyDiv = $('#divEmptyId');
    var $newDiv = $emptyDiv.clone(true);
    $newDiv.css('display', 'block');
    $newDiv.removeClass('hidden');
    $emptyDiv.before($newDiv);

    $newDiv.attr('id', 'divEmptyId' + getMaxEmptyId());
    var $elems = $newDiv.find("[name*='$num']");
    $elems.each(function(index) {
        var name = $(this).attr('name');
        name = name.replace("$num", getMaxEmptyId());
        $(this).attr('name', name);
    });
    $newDiv.find("[name$='[id]']").val('');
    maxEmptyId++;
    return false;
}

function moveUpTopic(a) {
    var $a = $(a);
    var id = $a.parent().parent().attr('id').substring(3);
    var $div = $('#div' + id);
    var $prevDiv = $div.prev();
    var prevId = $prevDiv.attr('id');
    if (prevId.indexOf('div') == 0) {
        $div.detach();
        $div.insertBefore($prevDiv);
    }
}

