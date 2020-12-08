/*
 * var jsParams = array(
 *    HtmlUrl => '...',
 *    ExportUrls => '...',
 *    ParamsSign => '', //? или &(для секции)
 *    ConfUrn => '...',
 *    MinsMsg => ,
 *    SecsMsg => ,
 *    DownloadFileMsg => '...',
 *    FileIsBeingPreparedMsg => '...',
 *    ErrorMsg => 
 *    NothingToExportMsg =>
 *    );
 */
var file_url = [];

var start_time = null;
var file_name = '';
var FiveMins = 1000 * 60 * 5;
var export_option = 'all';

function CurrentDateTimeStr() {
    var currentdate = new Date();
    var datetime = currentdate.getDate() + "_"
            + (currentdate.getMonth() + 1) + "_"
            + currentdate.getFullYear() + "_"
            + currentdate.getHours() + "_"
            + currentdate.getMinutes() + "_"
            + currentdate.getSeconds();
    return datetime;
}

function TimerStr(time_diff) {
    var date = new Date(time_diff);
    var mins = date.getMinutes();
    var secs = date.getSeconds();
    var res = '';
    if (mins > 0) {
        res = res + mins + ' ' + jsParams['MinsMsg'] + ' ';
    }
    if (secs > 0) {
        res = res + secs + ' ' + jsParams['SecsMsg'];
    }
    return res;
}

function clearLinks(export_type) {
    var $a = $("#zip-export");
    $a.unbind('click');
    $a.bind('click', function() {
        startExport($a, 'zip');
    });
    if (export_type == 'zip') {
        $a.removeClass('disabled-current');
    } else {
        $a.removeClass('disabled');
    }

    $a = $("#excel-export");
    $a.unbind('click');
    $a.bind('click', function() {
        startExport($a, 'excel');
    });
    if (export_type == 'excel') {
        $a.removeClass('disabled-current');
    } else {
        $a.removeClass('disabled');
    }
    
    $a = $("#authors-export");
    $a.unbind('click');
    $a.bind('click', function() {
        startExport($a, 'authors');
    });
    if (export_type == 'authors') {
        $a.removeClass('disabled-current');
    } else {
        $a.removeClass('disabled');
    }

    $a = $("#dspace-export");
    $a.unbind('click');
    $a.bind('click', function() {
        startExport($a, 'dspace');
    });
    if (export_type == 'dspace') {
        $a.removeClass('disabled-current');
    } else {
        $a.removeClass('disabled');
    }

    $a = $("#program-export");
    $a.unbind('click');
    $a.bind('click', function() {
        startExport($a, 'program');
    });
    if (export_type == 'program') {
        $a.removeClass('disabled-current');
    } else {
        $a.removeClass('disabled');
    }
}

function onFileCreated(export_type) {
    var $p = $("#export-links");
    var $p2 = $("#export-loading");
    $p2.remove();
    $p.after('<p id="export-file">' + jsParams['DownloadFileMsg'] + ' <a href="/uploads/export/' + file_name + '">' + file_name + '</a></p>');
    clearLinks(export_type);
}

function onEmptyFile(export_type) {
    var $p = $("#export-links");
    var $p2 = $("#export-loading");
    $p2.remove();
    $p.after('<p id="export-file">' + jsParams['NothingToExportMsg'] + '</p>');
    clearLinks(export_type);
}

function onErrorOccured(export_type) {
    var $p = $("#export-links");
    var $p2 = $("#export-loading");
    $p2.remove();
    $p.after('<p id="export-file">' + jsParams['ErrorMsg'] + '</p>');
    clearLinks(export_type);
}

function onTimeUp(export_type) {
    var $p = $("#export-links");
    var $p2 = $("#export-loading");
    $p2.remove();
    $p.after('<p id="export-file">' + jsParams['ErrorMsg'] + '</p>');
    clearLinks(export_type);
}

function waitFileCreated(export_type) {
    var $timer = $("#export-loading").find("#timer");
    var time_diff = new Date() - start_time;
    if (time_diff > FiveMins) {
        //если больше пяти минут,то просьба обратиться к администратору
        //if it hangs more than 5 minutes than show message to contact administrator
        onTimeUp(export_type);
    } else {
        $timer.text(TimerStr(time_diff));
        setTimeout(function() {
            var full_url = file_url[export_type] + jsParams['ParamsSign'] + 'file_name=' + file_name + '&option=' + export_option;
            $.ajax({
                type: "GET",
                url: full_url + '&action=test',
                timeout: 5000,
                complete: function(data, status) {
                    var created = false;
                    if (status == 'success') {
                        var xml = data.responseText;
                        if ($(xml).find('created').size() > 0) {
                            created = true;
                            onFileCreated(export_type);
                        };
                        if ($(xml).find('empty').size() > 0) {
                            created = true;
                            onEmptyFile(export_type);
                        };
                        if ($(xml).find('error').size() > 0) {
                            created = true;
                            onErrorOccured(export_type);
                        };
                    }
                    if (!created) {
                        waitFileCreated(export_type);
                    }
                }
            })
        }, 5000);
    }
}

function startExport($a, export_type) {
    $a = $("#zip-export");
    $a.unbind('click');
    $a.bind('click', function(e) {
        e.preventDefault();
    });
    if (export_type == 'zip') {
        $a.addClass('disabled-current');
    } else {
        $a.addClass('disabled');
    }

    $a = $("#excel-export");
    $a.unbind('click');
    $a.bind('click', function(e) {
        e.preventDefault();
    });
    if (export_type == 'excel') {
        $a.addClass('disabled-current');
    } else {
        $a.addClass('disabled');
    }
    
    $a = $("#authors-export");
    $a.unbind('click');
    $a.bind('click', function(e) {
        e.preventDefault();
    });
    if (export_type == 'authors') {
        $a.addClass('disabled-current');
    } else {
        $a.addClass('disabled');
    }

    $a = $("#dspace-export");
    $a.unbind('click');
    $a.bind('click', function(e) {
        e.preventDefault();
    });
    if (export_type == 'dspace') {
        $a.addClass('disabled-current');
    } else {
        $a.addClass('disabled');
    }

    $a = $("#program-export");
    $a.unbind('click');
    $a.bind('click', function(e) {
        e.preventDefault();
    });
    if (export_type == 'program') {
        $a.addClass('disabled-current');
    } else {
        $a.addClass('disabled');
    }

    var $p2 = $("#export-file");
    if ($p2.length > 0) {
        $p2.remove();
    }

    var $p = $("#export-links");
    $p.after('<p id="export-loading">' + jsParams['FileIsBeingPreparedMsg'] + ' <img src="/images/ajax-progress.gif" />&nbsp;<span id="timer"></span></p>');

    start_time = new Date();
    file_name = jsParams['ConfUrn'];
    if (export_type == 'dspace') {
        file_name = file_name + '_dspace';
    }

    file_name = file_name + '_export_' + export_option + '_' + CurrentDateTimeStr();
    if (export_type == 'zip') {
        file_name = file_name + '.zip';
    }

    if (export_type == 'excel') {
        file_name = file_name + '.xlsx';
    }
    
    if (export_type == 'authors') {
        file_name = jsParams['ConfUrn'] + '_authors_' + export_option + '_' + CurrentDateTimeStr() + '.xlsx';
    }

    if (export_type == 'dspace') {
        file_name = file_name + '.zip';
    }

    if (export_type == 'program') {
        file_name = jsParams['ConfUrn'] + '_program_' + CurrentDateTimeStr() + '.docx';
    }

    var full_url = file_url[export_type] + jsParams['ParamsSign'] + 'file_name=' + file_name + '&option=' + export_option;
    $.ajax({
        type: "GET",
        url: full_url + '&action=create',
        timeout: 5000,
        complete: function(data, status) {
            var created = false;
            if (status == 'success') {
                var xml = data.responseText;
                if ($(xml).find('created').size() > 0) {
                    created = true;
                    onFileCreated(export_type);
                };
                if ($(xml).find('empty').size() > 0) {
                            created = true;
                            onEmptyFile(export_type);
                };
                if ($(xml).find('error').size() > 0) {
                    created = true;
                    onErrorOccured(export_type);
                };
            }
            if (!created) {
                waitFileCreated(export_type);
            }
        }
    });
    return false;
}

function onExportRadioChanged($r) {
    export_option = $r.val();
    var url = jsParams['HtmlUrl'];
    var $htmlLink = $("#html-export");
    $htmlLink.attr('href', url + jsParams['ParamsSign'] + 'option=' + export_option);
}

$(function() {
    file_url = jsParams['ExportUrls'];
    var $a = $("#zip-export");
    $a.bind('click', function() {
        startExport($a, 'zip');
    });
    $a = $("#excel-export");
    $a.bind('click', function() {
        startExport($a, 'excel');
    });
    $a = $("#dspace-export");
    $a.bind('click', function() {
        startExport($a, 'dspace');
    });
    $a = $("#program-export");
    $a.bind('click', function() {
        startExport($a, 'program');
    });
    $a = $("#authors-export");
    $a.bind('click', function() {
        startExport($a, 'authors');
    });
    //export-radio
    var $r = $('[name="export-radio"]');
    $r.each(function() {
        $(this).bind('click', function() {
            onExportRadioChanged($(this));
        });
    });
});

