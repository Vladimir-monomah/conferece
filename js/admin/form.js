 /*
 * var jsParams = array(
 *    DeleteFieldMsg => '...',
 *    RevertMsg => '...',
 *    );
 * 
 */  
   
    function returnField(a){
        var $a = $(a);
        var $stubTr = $a.parents('tr');
        var $prevTr = $stubTr.prev();
        var $tr = $prevTr.prev();
        $stubTr.remove();
        $prevTr.remove();
        $tr.css('display','');
        var $enabled = $tr.find("input[name$='enabled]']");
        $enabled.val(1);
    }
    
    function deleteField(a){
        var $a = $(a);
        var $tr = $a.parents('tr');
        var $stub = $("<tr class='ordered stub' style='margin:0;padding:0;'><td colspan='3' style='font-size:0;margin:0;padding:0;'></td></tr><tr class='ordered stub'><td colspan='3' style='text-align:center;color:red'>" + jsParams['DeleteFieldMsg'] + "<a href='javascript:void(0)' onclick='returnField(this)' class='link'>" + jsParams['RevertMsg'] + "</a></td></tr>");
        $tr.css('display','none');
        var $enabled = $tr.find("input[name$='enabled]']");
        $enabled.val(0);
        $tr.after($stub);
    }
    
    function upField(a){
        var $a = $(a);
        var $tr = $a.parents('tr');
        var $prevTr = $tr.prev('tr:not(:has(th))');
        if ($prevTr.length > 0) {
            var $prevPrevTr = $prevTr.prev('tr:not(:has(th))');
            if ($prevTr.hasClass('stub')){
                $prevTr = $prevTr.prev('tr:not(:has(th))').prev('tr:not(:has(th))');
                $prevPrevTr = $prevTr.prev('tr:not(:has(th))');
            }
            if ($prevPrevTr.length == 0) { 
                $a.addClass('disabled');
                var $a2 = $prevTr.find("a[name='up']");
                $a2.removeClass('disabled');
            }
            var $nextTr = $tr.next('tr'); 
            $prevTr.before($tr);
            if ($nextTr.length == 0) {
                $a = $tr.find("a[name='down']");
                $a.removeClass('disabled');
                var $a2 = $prevTr.find("a[name='down']");
                $a2.addClass('disabled');                
            }
        } 
    }
    
    function downField(a){
        var $a = $(a);
        var $tr = $a.parents('tr');
        var $nextTr = $tr.next('tr');
        if ($nextTr.length > 0) {
            var $nextNextTr = $nextTr.next('tr');
            var ifStub = false;
            if ($nextNextTr.hasClass('stub')) {
                ifStub = true;
                $nextNextTr = $nextNextTr.next('tr').next('tr');
            };       
            if ($nextNextTr.length == 0){
                $a.addClass('disabled');
                var $a2 = $nextTr.find("a[name='down']");
                $a2.removeClass('disabled');
            };
            var $prevTr = $tr.prev('tr:not(:has(th))');
            if (ifStub) {
                $nextTr.next('tr').next('tr').after($tr);
            } else {
                $nextTr.after($tr);
            };
            if ($prevTr.length == 0){
                $a = $tr.find("a[name='up']");
                $a.removeClass('disabled');
                var $a2 = $nextTr.find("a[name='up']");
                $a2.addClass('disabled');
            };            
        };        
    }


