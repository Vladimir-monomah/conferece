function selectAuthors(participant_id, chbx) {
    var $chbx = $(chbx);
    $("[name*=\"[" + participant_id + "][authors]\"").each(function(index) {
        var $this = $(this);
        if (!$this.prop('disabled')) {
            $this.prop('checked', $chbx.prop('checked'));
        }
        ;
    });
}

function selectAuthor(participant_id, chbx) {
    var $chbx = $(chbx);
    if ($chbx.prop('checked')) {
        var $chbx1 = $("[name*=\"[" + participant_id + "][selected]\"").first();
        $chbx1.prop('checked', $chbx.prop('checked'));
    }
}

function selectByLocale(locale, chbx) {
    var $chbx = $(chbx);
    $("[name*=\"[locale]\"").each(function(index) {
        var $this = $(this);
        if ($this.val() == locale) {
            var $chbx1 = $this.parent().find("[name*=\"[selected]\"]").first();
            $chbx1.prop('checked', $chbx.prop('checked'));
            $chbx1.change();
        }
    });
}

function selectAll(chbx) {
    var $chbx = $(chbx);
    $("[name*=\"[locale]\"").each(function(index) {
        var $this = $(this);
        var $chbx1 = $this.parent().find("[name*=\"[selected]\"]").first();
        $chbx1.prop('checked', $chbx.prop('checked'));
        $chbx1.change();
    });  
}