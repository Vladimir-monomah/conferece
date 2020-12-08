function adjustTranslations() {
    var $langs = $('[type=checkbox][name*="conf_languages"]');
    $langs.each(function(index) {
        var $lang = $(this).val();
        var $input = $('[name*="[subject][' + $lang + ']"]');
        var $tr = $input.parent().parent();
        if ($(this).attr('checked')) {
            $tr.show();
        } else {
            $tr.hide();
        }
        $input = $('[name*="[title][' + $lang + ']"]');
        $tr = $input.parent().parent();
        if ($(this).attr('checked')) {
            $tr.show();
        } else {
            $tr.hide();
        }
    });
}
$(function() {
    var $langs = $('[type=checkbox][name*="conf_languages"]');
    $langs.each(function(index) {
        $(this).change(function() {
            adjustTranslations();
        });
    });
});

