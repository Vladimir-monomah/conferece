/*
 * var jsParams = array(
 *    Language => '...',
 *    BlockFormats => '...' (не обязательное, not mandatory),
 *    FilemanagerTitle => '...'
 *    FilemanagerEnabled => boolean
 *    FilemanagerAccessKey => key string,
 *    MediaEnabled => boolean
 *    );
 * 
 */
// loading modifed scripts
$.getScript( "/js/tinymce_4.1.9/plugins/media/plugin.min.js?v=2", 
function( data, textStatus, jqxhr ) {
  console.log( "Load was performed." );
});

$(function() {
    if (!('BlockFormats' in jsParams)) {
        jsParams['BlockFormats'] = '';
    }
    if (!('FilemanagerEnabled' in jsParams)) {
        jsParams['FilemanagerEnabled'] = false;
    }
    if (!('FilemanagerAccessKey' in jsParams)) {
        jsParams['FilemanagerAccessKey'] = '';
    }
    if (!('MediaEnabled' in jsParams)) {
        jsParams['MediaEnabled'] = true;
    }
    var rf_filemanager_access_key = jsParams['FilemanagerAccessKey'];
    var rf_plugins = 'table contextmenu  emoticons textcolor paste colorpicker';
    var rf_toolbar2 = '| link unlink | image media | forecolor | table | nonbreaking charmap | fullscreen code  ';
    var rf_external_plugins = ''; 
    if (jsParams['FilemanagerEnabled'] == true) {
        rf_plugins = 'table contextmenu  emoticons textcolor paste colorpicker responsivefilemanager';
        rf_toolbar2 = 'responsivefilemanager | link unlink | image media | forecolor | table | nonbreaking charmap | fullscreen code  ';
        rf_external_plugins = { "filemanager" : "/filemanager/plugin.min.js"};            
    }
    if (jsParams['MediaEnabled'] == false) {
      rf_toolbar2 = '| link unlink | forecolor | table | nonbreaking charmap | fullscreen code  ';    
    }
    tinymce.init({
        selector: "textarea.editor",
        language: jsParams['Language'],
        plugins: [
            "advlist autolink link image lists charmap preview hr ",
            "searchreplace visualblocks wordcount visualchars code fullscreen  media nonbreaking",
            rf_plugins
        ],
        media_alt_source: false,
        media_poster: true,
        sfu_media_jwplayer: '/js/tinymce_4.1.9/plugins/media/jwplayer.swf',
        toolbar1: "| formatselect | removeformat | bold italic underline | subscript superscript | bullist numlist | outdent indent | cut copy paste pastetext | undo redo",
        toolbar2: rf_toolbar2,
        browser_spellcheck: false,
        relative_urls: false, 
        paste_as_text: false,
        schema: "html5",
        extended_valid_elements: 'embed[*]',
        paste_word_valid_elements : "a,em,strong,cite,code,ul,ol,li,dl,dt,dd,p,br,span,u,style,img,h3,h4,h5,h6,address,pre,font,div,hr,table,tr,th,td", 
        menubar: false,
        toolbar_items_size: 'small',
        block_formats: jsParams['BlockFormats'] + "Header 3=h3;Header 4=h4;Header 5=h5;Header 6=h6;Paragraph=p",
        filemanager_crossdomain: false,
        external_filemanager_path: "/filemanager/",
        filemanager_title: jsParams['FilemanagerTitle'] ,
        filemanager_access_key: rf_filemanager_access_key,
        external_plugins: rf_external_plugins   
    });
});


