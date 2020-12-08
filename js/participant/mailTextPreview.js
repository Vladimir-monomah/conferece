/*
 * var jsParams2 = array(
 *    PreferredLanguage => ,
 *    StatusNew => ,
 *    StatusApproved => ,
 *    StatusDiscarded =>      
 *    );
 */

function showHideDiv(divId, link) {
    var $div = $('#' + divId);
    var display = $div.css('display');
    if (display == 'block') {
        $div.css('display', 'none');
    } else {
        $div.css('display', 'block');
    };   
};

var initialStatus = 0;
$(function() {
    var prefLocale = jsParams2['PreferredLanguage'];
    var $textarea = $("textarea[name=\"Participant[status_reason]["+ prefLocale + "]\"]");
    var val = $textarea.val();
    if (val.length) {
        val = val.replace(/(?:\r\n|\r|\n)/g, '<br>');
        val += '<br /><br />';
    }
    $('#mail-status-reason-id').html(val);
    $textarea.change(function() {
        var val = $textarea.val();
        if (val.length) {
            val = val.replace(/(?:\r\n|\r|\n)/g, '<br>');
            val += '<br /><br />';
        }
        $('#mail-status-reason-id').html(val);      
    });
    
    
    var statuses = [];
    statuses[2] = jsParams2['StatusNew'];
    statuses[1] = jsParams2['StatusApproved'];
    statuses[0] = jsParams2['StatusDiscarded'];
    var checkedStatus = $("input[name=\"Participant[status]\"]:checked");
    var val = parseInt(checkedStatus.val());
    initialStatus = val;
    $('#mail-status-id').text(statuses[val]); 
    
    $("input[name=\"Participant[status]\"]").each(function(index) {
        var $this = $(this);
        $this.change(function() {
            if ($this.prop('checked')){
                var val = parseInt($this.val());
                $('#mail-status-id').text(statuses[val]); 
                if (initialStatus == val){
                    $('#show-mail-preview-id').css('display', 'none');
                    $('#mail-preview-div-id').css('display', 'none');
                } else {
                    $('#show-mail-preview-id').css('display', 'inline');
                }
            }
        }); 
    });   
});