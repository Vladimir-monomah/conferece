/*
 * var jsParams = array(
 *    CsrfTokenName => 
 *    CsrfToken =>
 *    );
 */

function isEmpty(obj) {
    if (typeof obj == 'undefined' || obj === null || obj === '')
        return true;
    if (typeof obj == 'number' && isNaN(obj))
        return true;
    if (obj instanceof Date && isNaN(Number(obj)))
        return true;
    return false;
}

(function($) {

    var settings = {
        'item_id': '',
        'sub_item_id_prefix': 'commented_',
        'comments': new Array(),
        'locale': 'ru',
        'url': '',
        'editable': true,
        /*  Администратор может включать/отключать комментирование некоторых абзацев
         Admin can enable/disable commenting of some paragraphs. */
        'admin': true,
        /*  Комментирование отключено, если есть в массиве и значение равно false
         Commenting is disabled when array holds value 'false'    */
        'commented_items': new Array()
    };

    /*  Переводы
     Translations    */
    var messages = new Array();
    messages['ru'] = new Array();
    messages['ru']["comments"] = "комментарии";
    messages['ru']['item_comments'] = "Комментарии";
    messages['ru']["noComments"] = "комментировать";
    messages['ru']["newComment"] = "Новый комментарий:";
    messages['ru']['send'] = "Отправить";
    messages['ru']['edit'] = "Редактировать";
    messages['ru']['delete'] = "Удалить";
    messages['ru']['save'] = "Сохранить";
    messages['ru']['confirmDelete'] = "Удалить комментарий?";
    messages['ru']['addCommentError'] = "Ошибка на сервере. Комментарий не сохранен.";
    messages['ru']['deleteCommentError'] = "Ошибка на сервере. Комментарий не был удален.";
    messages['ru']['enable'] = "включить";
    messages['ru']['disable'] = "отключить";
    messages['ru']['enableCommentsError'] = "Ошибка на сервере. Не удалось включить комментирование.";
    messages['ru']['disableCommentsError'] = "Ошибка на сервере. Не удалось отключить комментирование.";
    messages['ru']['confirmEnableComments'] = "Включить комментирование?";
    messages['ru']['confirmDisableComments'] = "Отключить комментирование?";
    messages['ru']['authorizeToComment'] = "Для того, чтобы оставить комментарий, пожалуйста, авторизуйтесь.";

    messages['en'] = new Array();
    messages['en']["comments"] = "comments";
    messages['en']['item_comments'] = "Comments";
    messages['en']["noComments"] = "post comment";
    messages['en']["newComment"] = "New comment:";
    messages['en']['send'] = "Send";
    messages['en']['edit'] = "Edit";
    messages['en']['delete'] = "Delete";
    messages['en']['save'] = "Save";
    messages['en']['confirmDelete'] = "Delete comment?";
    messages['en']['addCommentError'] = "Error on the server. Comment is not saved.";
    messages['en']['deleteCommentError'] = "Error on the server. Comment was not removed.";
    messages['en']['enable'] = "enable";
    messages['en']['disable'] = "disable";
    messages['en']['enableCommentsError'] = "Error on the server. Failed to enable commenting.";
    messages['en']['disableCommentsError'] = "Error on the server. Failed to disable commenting.";
    messages['en']['confirmEnableComments'] = "Enable commenting?";
    messages['en']['confirmDisableComments'] = "Disable commenting?";
    messages['en']['authorizeToComment'] = "In order to post comments, login, please.";

    messages['es'] = new Array();
    messages['es']["comments"] = "comentarios";
    messages['es']['item_comments'] = "Comentarios";
    messages['es']["noComments"] = "publicar comentario";
    messages['es']["newComment"] = "Comentario nuevo:";
    messages['es']['send'] = "Enviar";
    messages['es']['edit'] = "Editar";
    messages['es']['delete'] = "Eliminar";
    messages['es']['save'] = "Guardar";
    messages['es']['confirmDelete'] = "Eliminar comentario?";
    messages['es']['addCommentError'] = "Error en el servidor. Comentario no se ha guardado.";
    messages['es']['deleteCommentError'] = "Error en el servidor. Comentario no se ha eliminado.";
    messages['es']['enable'] = "activar";
    messages['es']['disable'] = "desactivar";
    messages['es']['enableCommentsError'] = "Error en el servidor. No se puede permitir comentar.";
    messages['es']['disableCommentsError'] = "Error en el servidor. No se pudo desactivar comentarios.";
    messages['es']['confirmEnableComments'] = "Habilitar comentarios?";
    messages['es']['confirmDisableComments'] = "Deshabilitar comentarios?";
    messages['es']['authorizeToComment'] = "Con el fin de enviar comentarios, entrada, por favor.";

    function getMessage(key) {
        var locale = settings["locale"];
        if (messages[locale] != undefined) {
            if (messages[locale][key] != undefined) {
                return messages[locale][key];
            }
        }
        return messages['ru'][key];
    }

    function textToHtml(text) {
        return text.replace(/<br \/>/g, '\n').
                replace(/&lt;/g, "<").
                replace(/&gt;/g, ">").
                replace(/&amp;/g, "&").
                replace(/&quot;/g, "\"").
                replace(/&#92;/g, "\\").
                replace(/&nbsp;/g, " ");
    }

    function htmlToText(html) {
        return html.replace(/&/g, "&amp;").
                replace(/</g, "&lt;").
                replace(/>/g, "&gt;").
                replace(/\n/g, "<br />").
                replace(/\"/g, "&quot;").
                replace(/\\/g, "&#92;").
                replace(/  /g, " &nbsp;");
    }

    function onAddCommentClick(_sub_item_id, $newCommentDiv, $textarea, $commentsBtn) {
        if ($textarea.val() == '') {
            return false;
        }
        var $sendBtn = $newCommentDiv.find('button');
        var $ajax_progress_img = $newCommentDiv.find('img');
        $sendBtn.attr('disabled', 'disabled');
        $ajax_progress_img.show();
        var post_data = {action: 'add', item_id: settings['item_id'], sub_item_id: _sub_item_id, text: $textarea.val()};
        post_data[jsParams['CsrfTokenName']] = jsParams['CsrfToken'];
        $.ajax({
            type: "POST",
            url: settings['url'],
            data: post_data,
            success: function(xml) {
                parseAddCommentXml($newCommentDiv, $textarea, $commentsBtn, xml);
            }
        });
        return true;
    }

    function onDeleteCommentClick(_comment_id, $commentView, $commentsBtn, $deleteBtn) {
        $deleteBtn.attr('disabled', 'disabled');
        if (!confirm(getMessage('confirmDelete'))) {
            return false;
        }
        var post_data = {action: "delete", comment_id: _comment_id};
        post_data[jsParams['CsrfTokenName']] = jsParams['CsrfToken'];
        $.ajax({
            type: "POST",
            url: settings['url'],
            data: post_data,
            success: function(xml) {
                $deleteBtn.removeAttr("disabled");
                if ($(xml).find("error").size() > 0) {
                    alert(getMessage("deleteCommentError") + $(xml).find("error").text());
                } else {
                    var $commentsDiv = $commentView.parent();
                    $commentView.remove();
                    setCommentsBtnText($commentsBtn, $commentsDiv);
                }
            }
        });
        return true;
    }

    function onEditCommentClick(comment_id, text, $commentText, $editBtn, $commentsBtn, mode) {
        if (mode == "view") {
            $commentText.empty();
            $commentText.attr('class', 'commentTextView');
            $commentText.html(text);
            $editBtn.unbind('click');
            $editBtn.bind('click', function() {
                onEditCommentClick(comment_id, text, $commentText, $editBtn, $commentsBtn, "edit");
            });
        } else {
            $editBtn.unbind('click');
            $editBtn.bind('click', function() {
                onEditCommentClick(comment_id, text, $commentText, $editBtn, $commentsBtn, "view");
            });

            var $textarea = $("<textarea cols='30' rows='7'></textarea>");
            $textarea.attr('class', 'commentTextarea');
            $textarea.val(textToHtml(text));

            var $updateBtn = $('<button />');
            $updateBtn.text(getMessage('save'));
            $updateBtn.attr('class', 'saveCommentBtn');
            $updateBtn.bind('click', function() {
                onUpdateCommentClick(comment_id, $commentText.parent(), $textarea, $commentsBtn, $updateBtn, $ajax_progress_img);
            });

            $commentText.empty();
            $commentText.attr('class', 'commentTextEdit');
            $commentText.append($textarea);
            $commentText.append($updateBtn);
            //иконка ожидания
            //progress icon
            var $ajax_progress_img = $("<img src='/images/ajax-progress.gif' class='ajax_progress' />");
            $commentText.append($ajax_progress_img);
            $ajax_progress_img.hide();

        }

    }

    function onUpdateCommentClick(_comment_id, $commentView, $textarea, $commentsBtn, $updateBtn, $ajax_progress_img) {
        if ($textarea.val() == '') {
            return false;
        }
        $updateBtn.attr('disabled', 'disabled');
        $ajax_progress_img.show();
        var post_data = {action: 'update', comment_id: _comment_id, text: $textarea.val()};
        post_data[jsParams['CsrfTokenName']] = jsParams['CsrfToken'];
        $.ajax({
            type: "POST",
            url: settings['url'],
            data: post_data,
            success: function(xml) {
                parseUpdateCommentXml($commentView, $commentsBtn, xml, $updateBtn, $ajax_progress_img);
            }
        });
        return true;
    }
    ;

    function commentView(id, text, author, editable, commentDate, $commentsBtn) {
        var $commentView = $('<div />');
        $commentView.attr('class', 'commentView');
        $commentView.html('<strong>' + author + '</strong>&nbsp;' + commentDate);
        var $commentText = $('<div />');
        if (settings['editable'] && ("true" == editable)) {

            var $deleteImg = $('<img />');
            $deleteImg.attr('src', '/images/delete.png');
            $deleteImg.attr('alt', getMessage("delete"));
            $deleteImg.attr('class', 'commentBtnImg');

            var $deleteBtn = $("<a href='javascript:void(0)' />");
            $deleteBtn.html($deleteImg);
            $deleteBtn.attr('class', 'deleteCommentBtn');
            $deleteBtn.bind('click', function() {
                onDeleteCommentClick(id, $commentView, $commentsBtn, $deleteBtn);
            });

            var $editImg = $('<img />');
            $editImg.attr('src', '/images/edit.png');
            $editImg.attr('alt', getMessage("edit"));
            $editImg.attr('class', 'commentBtnImg');

            var $editBtn = $("<a href='javascript:void(0)' />");
            $editBtn.html($editImg);
            $editBtn.attr('class', 'editCommentBtn');
            $editBtn.bind('click', function() {
                onEditCommentClick(id, text, $commentText, $editBtn, $commentsBtn, "edit");
            });

            $commentView.append($deleteBtn);
            $commentView.append($editBtn);
        }

        $commentText.attr('class', 'commentTextView');
        $commentText.html(text);
        $commentView.append($commentText);
        return $commentView;
    }

    function parseAddCommentXml($newCommentDiv, $textarea, $commentsBtn, xml) {
        var $sendBtn = $newCommentDiv.find('button');
        var $ajax_progress_img = $newCommentDiv.find('img');
        $sendBtn.removeAttr("disabled");
        $ajax_progress_img.hide();
        if ($(xml).find("error").size() > 0) {
            alert(getMessage("addCommentError") + $(xml).find("error").text());
            return;
        } else {
            $(xml).find("comment").each(function() {
                var $comment = $(this);
                var author = $comment.find("author").text();
                var text = htmlToText($comment.find("text").text());
                var id = $comment.find('id').text();
                var editable = $comment.find('editable').text();
                var commentDate = $comment.find('date').text();

                var $commentView = commentView(id, text, author, editable, commentDate, $commentsBtn);

                $textarea.val('');
                $newCommentDiv.before($commentView);
                var $commentsDiv = $newCommentDiv.parent();
                setCommentsBtnText($commentsBtn, $commentsDiv)
            });
        }
    }

    function  parseUpdateCommentXml($commentView, $commentsBtn, xml, $updateBtn, $ajax_progress_img) {
        $updateBtn.removeAttr("disabled");
        $ajax_progress_img.hide();
        if ($(xml).find("error").size() > 0) {
            alert(getMessage("addCommentError") + $(xml).find("error").text());
            return;
        } else {
            $(xml).find("comment").each(function() {
                var $comment = $(this);
                var author = $comment.find("author").text();
                var text = htmlToText($comment.find("text").text());
                var id = $comment.find('id').text();
                var editable = $comment.find('editable').text();
                var commentDate = $comment.find('date').text();
                var $newCommentView = commentView(id, text, author, editable, commentDate, $commentsBtn);
                $commentView.replaceWith($newCommentView);
            });
        }
    }

    function setCommentsBtnText($commentsBtn, $commentsDiv) {
        var count = 0;
        if ($commentsDiv.children('div')) {
            count = $commentsDiv.children('div').size();
            //if(settings['editable']){
            count = count - 1;
            //}
        }
        if (count == 0) {
            if ($commentsBtn != null) {
                $commentsBtn.text(getMessage('noComments'));
                $commentsBtn.attr('class', 'commentsBtn');
            }
        } else {
            if ($commentsBtn != null) {
                $commentsBtn.text(getMessage('comments') + ' (' + count + ')');
                $commentsBtn.attr('class', 'commentsBtnBold');
            }
        }
    }

    function onCommentsClick($commentsBtn, $commentsDiv, mode) {
        setCommentsBtnText($commentsBtn, $commentsDiv);
        if ("hide" == mode) {
            $commentsDiv.hide();
            mode = "show";
        } else {
            $commentsDiv.show();
            mode = "hide";
        }
        if ($commentsBtn != null) {
            $commentsBtn.unbind('click');
            $commentsBtn.bind('click', function() {
                onCommentsClick($commentsBtn, $commentsDiv, mode);
            });
        }
    }

    function disableComments(id, $switchBtn, $commentsBtn, $commentsDiv) {
        if (confirm(getMessage('confirmDisableComments'))) {
            var post_data = {
                action: 'disableComments',
                item_id: settings['item_id'],
                sub_item_id: id
            };
            post_data[jsParams['CsrfTokenName']] = jsParams['CsrfToken'];
            $.ajax({
                type: "POST",
                url: settings['url'],
                data: post_data,
                success: function(xml) {
                    if ($(xml).find("error").size() > 0) {
                        alert(getMessage("disableCommentsError") + $(xml).find("error").text());
                        return;
                    } else {
                        settings['commented_items'][id] = false;
                        if ($commentsBtn != null) {
                            $commentsBtn.attr('class', 'commentsBtnDisabled');
                            $commentsBtn.unbind('click');
                            $commentsBtn.bind('click', function() {
                                onCommentsClick($commentsBtn, $commentsDiv, "hide");
                            });
                            $commentsBtn.click();
                            $commentsBtn.unbind('click');
                        }
                        $switchBtn.text(getMessage('enable'));
                        $switchBtn.unbind('click');
                        $switchBtn.bind('click', function() {
                            enableComments(id, $switchBtn, $commentsBtn, $commentsDiv);
                        });
                    }
                }
            });
        }
    }

    function enableComments(id, $switchBtn, $commentsBtn, $commentsDiv) {
        if (confirm(getMessage('confirmEnableComments'))) {
            var post_data = {
                action: 'enableComments',
                item_id: settings['item_id'],
                sub_item_id: id
            };
            post_data[jsParams['CsrfTokenName']] = jsParams['CsrfToken'];
            $.ajax({
                type: "POST",
                url: settings['url'],
                data: post_data,
                success: function(xml) {
                    if ($(xml).find("error").size() > 0) {
                        alert(getMessage("enableCommentsError") + $(xml).find("error").text());
                        return;
                    } else {
                        settings['commented_items'][id] = true;
                        if ($commentsBtn != null) {
                            $commentsBtn.attr('class', 'commentsBtn');
                            $commentsBtn.unbind('click');
                            $commentsBtn.bind('click', function() {
                                onCommentsClick($commentsBtn, $commentsDiv, "show");
                            });
                        }
                        $switchBtn.text(getMessage('disable'));
                        $switchBtn.unbind('click');
                        $switchBtn.bind('click', function() {
                            disableComments(id, $switchBtn, $commentsBtn, $commentsDiv);
                        });
                    }
                }
            });
        }
    }

    //plugin
    $.fn.commenter = function(options) {
        //mode = 'sub_item' or 'item'
        var bindCommenter = function($this, mode) {
            var id = $this.attr('id');
            if ("item" == mode) {
                id = settings['item_id'];
            }

            if ((settings['commented_items'][id] != undefined) &&
                    (settings['commented_items'][id] == false) &&
                    !settings['admin']) {
                //если комментирование отключено и не админ, выходим
                //if commenting is disabled and the user is not admin then return
                return;
            }

            var exist = false;
            if (settings['comments'][id] != undefined) {
                exist = true;
            }

            var $commentsDiv = $('<div />');
            $commentsDiv.attr('class', 'commentsDiv');

            $this.after($commentsDiv);

            if (!settings['editable'] && !exist) {
                var $div = $("<div class='authorizeDiv'>" + getMessage('authorizeToComment') + "</div>");
                $commentsDiv.append($div);
                return;
            }

            var $switchBtn = null;
            if (settings['admin']) {
                $switchBtn = $("<a href='javascript:void(0)'></a>");
                $switchBtn.attr('class', 'switchBtn');
            }
            var $commentsBtn = null;

            if ("sub_item" == mode) {
                $commentsBtn = $("<a href='javascript:void(0)'></a>")
                $commentsBtn.attr('class', 'commentsBtn');
                $this.append('&nbsp;');
                $this.append($commentsBtn);
                if ($switchBtn != null) {
                    $this.append('&nbsp;&nbsp;');
                    $this.append($switchBtn);
                }
            } else {
                var $h2 = $('<h2 />');
                $h2.append(getMessage('item_comments'));
                /*if($switchBtn != null){
                 $h2.append('&nbsp;&nbsp;');
                 $h2.append($switchBtn);
                 }*/
                $commentsDiv.append($h2);

            }
            //сообщения
            //messages
            if (exist) {
                var $commentView;
                var sub_item_comments = settings['comments'][id];
                for (var comment_id in sub_item_comments) {
                    $commentView = commentView(sub_item_comments[comment_id]['id'],
                            sub_item_comments[comment_id]['text'],
                            sub_item_comments[comment_id]['author'],
                            sub_item_comments[comment_id]['editable'],
                            sub_item_comments[comment_id]['date'],
                            $commentsBtn);
                    $commentsDiv.append($commentView);
                }
            }
            if (settings['editable']) {
                var $newCommentDiv = $('<div />');
                $commentsDiv.append($newCommentDiv);
                $newCommentDiv.attr('class', 'newCommentDiv');
                $newCommentDiv.append('<br /><span>' + getMessage('newComment') + '</span>');

                //textarea для ввода сообщения
                //textares for message input
                var $textarea = $("<textarea cols='30' rows='7'></textarea>");
                $textarea.attr('class', 'commentTextarea');
                $newCommentDiv.append($textarea);

                //кнопка отослать комментарий
                //send comment button
                var $addCommentBtn = $("<button />");
                $newCommentDiv.append($addCommentBtn);
                $addCommentBtn.text(getMessage("send"));

                //иконка ожидания
                //progress icon
                var ajax_progress_img = $("<img src='/images/ajax-progress.gif' class='ajax_progress' />");
                $newCommentDiv.append(ajax_progress_img);
                ajax_progress_img.hide();

                $addCommentBtn.bind('click', function() {
                    onAddCommentClick(id, $newCommentDiv, $textarea, $commentsBtn);
                    return false;
                });
            } else {
                var $div = $("<div class='authorizeDiv'>" + getMessage('authorizeToComment') + "</div>");
                $commentsDiv.append($div);
            }
            if ("sub_item" == mode) {
                $commentsBtn.bind('click', function() {
                    onCommentsClick($commentsBtn, $commentsDiv, "hide");
                });

                $commentsBtn.click();
            }
            if ($switchBtn != null) {
                if ((settings['commented_items'][id] != undefined) &&
                        (settings['commented_items'][id] == false)) {
                    //выключаем
                    //switching off
                    if ($commentsBtn != null) {
                        $commentsBtn.attr('class', 'commentsBtnDisabled');
                        $commentsBtn.unbind('click');
                    }
                    $switchBtn.text(getMessage('enable'));
                    $switchBtn.bind('click', function() {
                        enableComments(id, $switchBtn, $commentsBtn, $commentsDiv);
                    });
                } else {
                    //включаем
                    //switchinf on
                    $switchBtn.text(getMessage('disable'));
                    $switchBtn.bind('click', function() {
                        disableComments(id, $switchBtn, $commentsBtn, $commentsDiv);
                    });
                }
            }
        }

        var bindSubItemCommenter = function() {
            var $this = $(this);
            var sub_item_id = $this.attr('id');
            if (!isEmpty(sub_item_id) && (sub_item_id.indexOf(settings['sub_item_id_prefix']) == 0)) {
                bindCommenter($this, "sub_item");
            }
        }

        return this.each(function() {
            if (options) {
                $.extend(settings, options);
            }
            var $container = $(this);
            $container.find('p').each(bindSubItemCommenter);
            $container.find('li').each(bindSubItemCommenter);
            $container.find('table').each(bindSubItemCommenter);

            bindCommenter($container, "item");
        });
    };

})(jQuery);


(function($) {

    var settings = {
        'id_prefix': 'commented_'
    };

    $.fn.commentedIdGenerator = function(options) {

        function generateUID()
        {
            function S4() {
                return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
            }
            function guid() {
                return S4() + S4() + S4();//(S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
            }

            return guid();
        }

        return this.each(function() {
            if (options) {
                $.extend(settings, options);
            }
            var $this = $(this);
            $this.parents('form').bind('submit',
                    function() {
                        var textareaId = $this.attr('id');
                        var $textarea = $('#' + textareaId);
                        var content = '';
                        if (tinyMCE) {
                            var inst = tinyMCE.get(textareaId);
                            if (inst) {
                                content = inst.getContent();
                            }
                        } else {
                            content = $textarea.val();
                        }
                        var $text = $('<div>' + content + '</div>');
                        var generateFunc = function() {
                            var id = generateUID();
                            var $elem = $(this);
                            if (isEmpty($elem.attr('id'))) {
                                $elem.attr('id', settings['id_prefix'] + id);
                            }
                        };
                        $text.find('p').not('table p').each(generateFunc);
                        $text.find('li').not('table li').each(generateFunc);
                        $text.find('table').not('table table').each(generateFunc);

                        if (tinyMCE) {
                            if (inst) {
                                inst.setContent($text.html());
                            }
                        } else {
                            $textarea.val($text.html());
                        }
                    });
        });
    }
})(jQuery);
