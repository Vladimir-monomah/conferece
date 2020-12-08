/*
 * var jsParams = array(
 *    AuthorsCount => ,
 *    DefaultLanguage => '...',
 *    Languages => '...',
 *    NewAuthorMsg => '...',
 *    RegisterAuthor => true or false,
 *    FindUserURL => ''
 *    SendPasswordURL => ''
 *    DeleteFileLinkMsg => 
 *    CheckPasswordMsg => 
 *    CorrectMsg => 
 *    NotCorrectMsg => 
 *    CsrfTokenName => 
 *    CsrfToken =>
 *    );
 */

var authorsCount = -1;
var selectedAuthorIdx = -1;
/*  Требуется регистрация первого автора на сайте или нет
    If it is needed to register the first author on the website or not  */
var registerAuthor = false;

function selectAuthor(idx) {
    //var idx =  this.getAttribute("author-idx");
    var lang = jsParams['DefaultLanguage'];
    var langs = jsParams['Languages'];

    //скрываем всех остальных
    //hide others
    $("div[id^='authorDiv']").each(function() {
        var $this = $(this);
        var authorName = '';
        $(this).css('display', 'none');
        var $lastname = $(this).find("[name*='[lastname][" + lang + "]']").first();
        langs.forEach(function(lang1) {
            var $str = $this.find("[name*='[lastname][" + lang1 + "]']").first();
            if($lastname.val() == '' ){
                $lastname = $str;
            };     
        });
        var $firstname = $(this).find("[name*='[firstname][" + lang + "]']").first();
        langs.forEach(function(lang1) {
                var $str = $this.find("[name*='[firstname][" + lang1 + "]']").first();
                if($firstname.val() == '' ){
                    $firstname = $str;
                };    
        });
        var $middlename = $(this).find("[name*='[middlename][" + lang + "]']").first();
        langs.forEach(function(lang1) {
                var $str = $this.find("[name*='[middlename][" + lang1 + "]']").first();
                if($middlename.val() == '' ){
                    $middlename = $str;
                };    
        });
        authorName = $lastname.val(); 
        var str = $firstname.val();
        str = str.substr(0, 1);
        if (str.length > 0) {
            str = str + '.';
        }
        ;
        authorName = authorName + ' ' + str;
        str = $middlename.val();
        str = typeof(str)=='undefined'?'':str.substr(0, 1);
        if (str.length > 0) {
            str = str + '.';
        }
        ;
        authorName = authorName + ' ' + str;
        _idx = $(this).attr('id').substr(9, 1);
        var email_id = 'author_' + _idx + '_email';
        $(this).find("#" + email_id).bind("blur", function() {
            findUser(_idx);
        });
        var $authorLinkDiv = $("div[id^='authorLinkDiv" + _idx + "']").first();
        $authorLinkDiv.css('background-color', '');
        var $link = $authorLinkDiv.find("a[id*='authorName']").first();
        authorName = authorName.trim(); 
        if(authorName == ''){
            authorName = '_';
        };
        $link.text(authorName);
    });

    //показываем выбранного
    //show selected author
    $("div[id='authorDiv" + idx + "']").each(function() {
        $(this).css('display', 'block');
    });
    $("div[id='authorLinkDiv" + idx + "']").each(function() {
        $(this).css('background-color', 'rgb(183,214,231)');
    });

    selectedAuthorIdx = idx;
}


function deleteAuthor(idx) {
    //удаляем выбранного
    //remove selected author
    $("div[id='authorLinkDiv" + idx + "']").each(function() {
        $(this).remove();
    });
    $("div[id='authorDiv" + idx + "']").each(function() {
        $(this).remove();
    });
    //если удаляется текущий автор, то нужно
    //выбрать другого, если он существует
    //if current author is being removed then
    //it is needed to select another one if it exists
    if (idx == selectedAuthorIdx) {
        idx = 0;
        var found = false;
        while (idx < authorsCount) {
            $div = $("div[id='authorDiv" + idx + "']");
            if ($div.length) {
                selectAuthor(idx);
                found = true;
                break;
            }
            ;
            idx++;
        }
        ;
        //если ни одного автора не осталось, то создает нового
        //when there is no author left then creating a new one
        if (!found) {
            createAuthor();
        }
    }
    findUser(-1);
    requireFirstAuthorEmail();
}


function createAuthor() {
    var lang = jsParams['DefaultLanguage'];
    var newAuthorStr = jsParams['NewAuthorMsg'];
    //создаем автора
    //creating author
    var $templateDiv = $("div[id='authorDivTemplate']");
    var $newDiv = $templateDiv.clone(true);
    var idx = authorsCount;
    authorsCount++;
    var $elems = $newDiv.find("[name*='Template']");
    $elems.each(function(index) {
        var name = $(this).attr('name');
        name = name.replace("Template", idx);
        $(this).attr('name', name);
        var id = $(this).attr('id');
        if (id) {
            id = id.replace("Template", idx);
            $(this).attr('id', id);
        }
        if (name.indexOf('link') >= 0) {
            var onclick = $(this).attr("onclick");
            onclick = onclick.replace("Template", idx);
            $(this).attr("onclick", onclick);
        }
        if (name.indexOf('[lastname][' + lang + ']') >= 0) {
            $(this).val(newAuthorStr);
        }
    });
    $elems = $newDiv.find("[for*='Template']");
    $elems.each(function(index) {
        var _for = $(this).attr('for');
        _for = _for.replace("Template", idx);
        $(this).attr('for', _for);
    });    
    var id = $newDiv.attr('id');
    id = id.replace("Template", idx);
    $newDiv.attr('id', id);
    var email_id = 'author_' + idx + '_email';
    $newDiv.find("#" + email_id).bind("blur", function() {
        findUser(idx);
    });
    $templateDiv.before($newDiv);
    //создаем ссылку-переключатель автора
    //creating a switching link for the author
    $templateDiv = $("div[id='authorLinkDivTemplate']");
    $newDiv = $templateDiv.clone(true);
    $newDiv.find("a").each(
            function(index) {
                var id = $(this).attr('id');
                id = id.replace("Template", idx);
                $(this).attr('id', id);
                if (id.indexOf('authorName') >= 0) {
                    $(this).click(function() {
                        selectAuthor(idx);
                    });
                    $(this).text(newAuthorStr);
                }
                ;
                if (id.indexOf('deleteAuthor') >= 0) {
                    $(this).click(function() {
                        deleteAuthor(idx);
                    });
                }
                ;
            });
    $newDiv.css('display', 'inline-block');
    id = $newDiv.attr('id');
    id = id.replace("Template", idx);
    $newDiv.attr('id', id);
    $templateDiv.before($newDiv);
    selectAuthor(idx);
}

function requireFirstAuthorEmail() {
    var idx = findFirstAuthorIdx();
    if (idx > -1) {
        var $label = $("#author_email_label_" + idx + "_id").find("label");
        if (!($label.find('span').length > 0)) {
            $label.append(' <span class="required">*</span>');
        }
        ;
    }
}

/*  Возвращает индекс первого автора
    Returns index of the first author   */
function findFirstAuthorIdx() {
    var _idx = -1;
    var i = 0;
    var $div;
    while (true) {
        $div = $("div[id='authorDiv" + i + "']");
        if ($div.length) {
            _idx = i;
            break;
        }
        ;
        i++;
        //больше 20 авторов не может быть
        //there can not be more than 20 authors
        if (i > 20) {
            break;
        }
    }
    ;
    return _idx;
}

/*  Проверяет, зарегистрирован ли первый автор или нет
    Tests if the first author is registered in the system   */
function findUser(idx) {
    //если не требуется регистрация, то выходим
    //if registration is not needed than return
    if (registerAuthor == false) {
        return;
    }
    //ищем первого автора, и прикручиваем проверку существует ли для него пользователь
    //find the first author and attaches a test function that finds corresponding user
    var _idx = findFirstAuthorIdx();
    //если не найден первый автор, то выходим
    //if the first author is not found than return
    if (_idx == -1) {
        return;
    }
    //если в параметре передан реальный автор и он не первый, то выходим
    //if parameter idx corresponds to the existing author that is not first than return 
    if ((idx > -1)) {
        if (_idx != idx) {
            return;
        }
        ;
    }
    ;
    var email_id = 'author_' + _idx + '_email';
    var $email_input = $("#" + email_id);
    var url = jsParams['FindUserURL'] + '?email=' + $email_input.val();
    var post_data = {};
    post_data[jsParams['CsrfTokenName']] = jsParams['CsrfToken'];
    $.ajax({
        type: "POST",
        url: url,
        data: post_data,
        timeout: 5000,
        complete: function(data, status) {
            if (status == 'success') {
                var div_id = 'div_' + _idx + '_existed_author_password_id';
                var xml = data.responseText;
                if ($(xml).find('user').text().length > 0) {
                    $('#' + div_id).css('display', 'block');
                    var msg_id = "send_password_msg_" + _idx + "_id";
                    var $span = $('#' + msg_id);
                    $span.addClass('hidden');
                    $('#captcha_id').css('display', 'none');
                } else {
                    $('#' + div_id).css('display', 'none');
                    $('#captcha_id').css('display', 'block');
                }
                ;

            }
            ;
        }
    });
}

function authorFromXml(idx, xml) {
    var $xml = $(xml);
    var langs = jsParams['Languages'];
    var $field = null;
    var value = null;
    var $div = $("div[id='authorDiv" + idx + "']");
    langs.forEach(function(lang) {
        //Lastname
        $field = $div.find("[name*='[lastname][" + lang + "]']");
        if ($field.length > 0) {
            value = $xml.find('lastname[lang="' + lang + '"]').text();
            $field.val(value);
        }
        ;
        //Firstname
        $field = $div.find("[name*='[firstname][" + lang + "]']");
        if ($field.length > 0) {
            value = $xml.find('firstname[lang="' + lang + '"]').text();
            $field.val(value);
        }
        ;
        //Middlename
        $field = $div.find("[name*='[middlename][" + lang + "]']");
        if ($field.length > 0) {
            value = $xml.find('middlename[lang="' + lang + '"]').text();
            $field.val(value);
        }
        ;
    });
    //Locale
    value = $xml.find('locale').text();
    $field = $div.find("[name*='[locale]']").filter('[value="' + value + '"]');
    if ($field.length > 0) {
        $field.attr('checked', true);
    }
    ;

    //Other fields
    var lang = jsParams['DefaultLanguage'];
    var fields = ['phone', 'fax', 'country', 'city', 'institution', 'institution_address',
        'position', 'academic_degree', 'academic_title', 'supervisor', 'home_address'];
    fields.forEach(function(field) {
        $field = $div.find("[name*='[" + field + "][" + lang + "]']");
        value = $xml.find(field).text();
        if ($field.length > 0) {
            $field.val(value);
        }
        ;
    });

    //Изображение код см. в ActiveForm.imgFields  
    //Image, see also ActiveForm.imgFields
    var image_url = $xml.find('image_url').text();
    var $image_div = $('#image_' + idx + '_' + jsParams['Language'] + '_div_id');
    if (image_url.length > 0) {
        var image_filename = $xml.find('image_filename').text();
        var image_html = "<input id=\"image_Template_ru_id\" type=\"hidden\" value=\"\" name=\"Author[Template][image][ru][id]\"></input>" +
                "<input id=\"image_Template_ru_temp_name\" type=\"hidden\" value=\"image_filename\" name=\"Author[Template][image][ru][temp_name]\"></input>" +
                "<img id=\"image_Template_ru_img\" width=\"150\" alt=\"image\" src=\"image_url\" style=\"margin:5px\"></img>" +
                "<br /><a href=\"javascript:return false;\" onclick=\"deleteFile('image_Template_ru',this)\">" + jsParams['DeleteFileLinkMsg'] + "</a><br />";
        image_html = image_html.replace(/Template/g, idx);
        image_html = image_html.replace("image_url", image_url);
        image_html = image_html.replace("image_filename", image_filename);
        $image_div.html(image_html);
    } else {
        $image_div.html('');
    }
}

function sendPassword(btn) {
    var $btn = $(btn);
    var btn_id = $btn.attr('id');
    var idx = btn_id.substring(0, btn_id.indexOf('_'));
    var msg_id = "send_password_msg_" + idx + "_id";
    var $span = $('#' + msg_id);
    var email_id = 'author_' + idx + '_email';
    var $email_input = $("#" + email_id);
    var url = jsParams['SendPasswordURL'] + '?email=' + $email_input.val();
    var post_data = {};
    post_data[jsParams['CsrfTokenName']] = jsParams['CsrfToken'];
    $.ajax({
        type: "POST",
        data: post_data,
        url: url,
        timeout: 5000,
        complete: function(data, status) {
            if (status == 'success') {
                var xml = data.responseText;
                if ($(xml).find('result').text().length > 0) {
                    $span.removeClass('hidden');
                } else {
                    $span.addClass('hidden');
                }
            }
        }
    });
}

function authorizeUser(btn) {
    var $btn = $(btn);
    var btn_id = $btn.attr('id');
    var idx = btn_id.substring(0, btn_id.indexOf('_'));
    var email_id = 'author_' + idx + '_email';
    var $email_input = $("#" + email_id);
    var password = $("[name='Author[" + idx + "][password]']").val();
    var $result = $('#' + idx + '_authorize_result_id');
    $result.text(jsParams['CheckPasswordMsg']);
    $result.removeClass('warning');
    $result.removeClass('success');
    var url = jsParams['AuthorizeUserURL'] + '?email=' + $email_input.val();
    var post_data = {};
    post_data[jsParams['CsrfTokenName']] = jsParams['CsrfToken'];
    post_data['password'] = password;    
    $.ajax({
        type: "POST",
        url: url,
        data: post_data,
        timeout: 5000,
        complete: function(data, status) {
            if (status == 'success') {
                var xml = data.responseText;
                if ($(xml).find('user').text().length > 0) {
                    authorFromXml(idx, xml);
                    $result.text(jsParams['CorrectMsg']);
                    $result.addClass('success');
                } else {
                    $result.text(jsParams['NotCorrectMsg']);
                    $result.addClass('warning');
                }
            }
        }
    });
}

/*  При старте выделять первого автора
    Select first author on page loading */
$(function() {
    authorsCount = jsParams['AuthorsCount'];
    registerAuthor = jsParams['RegisterAuthor'];
    if (authorsCount == 0) {
        createAuthor();
    } else {
        selectAuthor(0);
    }
    requireFirstAuthorEmail();
});

