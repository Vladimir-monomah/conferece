<?php

/**
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class CommentsUtils {

    public static function iconv_wordwrap($string, $width = 75, $break = "\n", $cut = false, $charset = 'utf-8') {
        $stringWidth = iconv_strlen($string, $charset);
        $breakWidth = iconv_strlen($break, $charset);

        if (strlen($string) === 0) {
            return '';
        }; 

        $result = '';
        $lastStart = $lastSpace = 0;

        for ($current = 0; $current < $stringWidth; $current++) {
            $char = iconv_substr($string, $current, 1, $charset);

            if ($breakWidth === 1) {
                $possibleBreak = $char;
            } else {
                $possibleBreak = iconv_substr($string, $current, $breakWidth, $charset);
            }

            if ($possibleBreak === $break) {
                $result .= iconv_substr($string, $lastStart, $current - $lastStart + $breakWidth, $charset);
                $current += $breakWidth - 1;
                $lastStart = $lastSpace = $current + 1;
            } elseif ($char === ' ') {
                if ($current - $lastStart >= $width) {
                    $result .= iconv_substr($string, $lastStart, $current - $lastStart, $charset) . $break;
                    $lastStart = $current + 1;
                }

                $lastSpace = $current;
            } elseif ($current - $lastStart >= $width && $cut && $lastStart >= $lastSpace) {
                $result .= iconv_substr($string, $lastStart, $current - $lastStart, $charset) . $break;
                $lastStart = $lastSpace = $current;
            } elseif ($current - $lastStart >= $width && $lastStart < $lastSpace) {
                $result .= iconv_substr($string, $lastStart, $lastSpace - $lastStart, $charset) . $break;
                $lastStart = $lastSpace = $lastSpace + 1;
            }
        }

        if ($lastStart !== $current) {
            $result .= iconv_substr($string, $lastStart, $current - $lastStart, $charset);
        }

        return $result;
    }

    public static function prepareText($text) {
        $text = CommentsUtils::iconv_wordwrap($text, 75, " ", true);
        $text = htmlspecialchars($text);
        $text = str_replace("  ", " &nbsp;", $text);
        return $text;
    }

    public static function textToJavaScriptString($text) {
        $text = CommentsUtils::prepareText($text);
        $text = nl2br($text);
        $text = preg_replace("/\s+/", ' ', $text);
        $text = str_replace("\\", "\\\\", $text);
        return $text;
    }

    public static function getUsername($userId) {
        $user = User::model()->findByPk($userId);
        if ($user) {
            return $user->fullName();
        }
        return Yii::t('comments', 'User removed.');
    }

    public static function formatCommentDate($commentDate) {
        return date("d.m.Y H:i", $commentDate);
    }

    public static function getAssocComments($user, $item_id, $sub_item_id = NULL) {
        $comments = array();
        $cmnts = Comment::model()->findAllByItemSubItem($item_id, $sub_item_id);
        foreach ($cmnts as $cmnt) {
            $comment['id'] = $cmnt->id;
            $comment['item_id'] = $cmnt->item_id;
            $comment['sub_item_id'] = $cmnt->sub_item_id;
            $comment['text'] = $cmnt->text;
            $comment['date'] = $cmnt->date;
            $comment['user_id'] = $cmnt->user_id;
            $comment['username'] = CommentsUtils::getUsername($cmnt->user_id);
            $comment['editable'] = CommentsUtils::hasEditCommentPrivilege($user, $cmnt);
            $comments[$cmnt->id] = $comment;
        }
        return $comments;
    }

    public static function validComment($comment, &$errors) {
        if (empty($comment->item_id)) {
            array_push($errors, 'item_id is empty');
        }
        if (empty($comment->user_id)) {
            array_push($errors, 'user_id is empty');
        }
        if (empty($comment->sub_item_id)) {
            array_push($errors, 'sub_item_id empty');
        }
        if (empty($comment->text)) {
            array_push($errors, 'no text');
        }
        return !count($errors);
    }

    public static function hasAddCommentPrivilege($user, $comment) {
        $participant = Participant::model()->findByPk($comment->item_id);
        $params = array(
            "conf_id" => $participant->conf_id,
            "class" => "Comment",
            "id" => $comment->id,
            "owner_attr" => "user_id",
            "user_id" => $user->id
        );
        return Yii::app()->authManager->checkAccess("createComment", $user->id, $params);
    }

    public static function hasEditCommentPrivilege($user, $comment) {
        $participant = Participant::model()->findByPk($comment->item_id);
        $params = array(
            "conf_id" => $participant->conf_id,
            "class" => "Comment",
            "id" => $comment->id,
            "owner_attr" => "user_id",
            "user_id" => $user->id
        );
        return Yii::app()->authManager->checkAccess("modifyComment", $user->id, $params);
    }

    public static function hasEnableDisableCommentsPriviledge($item_id, $user) {
        $participant = Participant::model()->findByPk($item_id);
        $params = array(
            "conf_id" => $participant->conf_id,
            "class" => "Comment",
            "id" => $item_id,
            "owner_attr" => "user_id",
            "user_id" => $user->id
        );
        return Yii::app()->authManager->checkAccess("enableComment", $user->id, $params);
    }

    public static function addComment(&$comment, $user, &$errors) {
        if (!CommentsUtils::validComment($comment, $errors)) {
            return false;
        }
        if (CommentsUtils::hasAddCommentPrivilege($user, $comment)) {
            $comment->date = mktime();
            try {
                $comment->save();
            } catch (Exception $e) {
                array_push($errors, $e->getMessage());
                return false;
            }
        } else {
            array_push($errors, "not enough privileges");
            return false;
        }
        CommentsUtils::commentNotification('add', $user, $comment);
        return true;
    }

    /**  
     *  Уведомления авторам доклада о добавлении/изменении/удалении комментария.
     * 
     *  Notification to the authors of a report about adding/updating/deleting a comment.   
     */
    public static function commentNotification($action, $user, $comment, $oldComment = NULL) {
        $participant = Participant::model()->findByPk($comment->item_id);

        //  привязываем обработчик события onComment
        //  attaching a handler for onComment event
        $participant->onComment = array(NotificationService::getInstance(), "notifyComment");
        //  инициируем это событие
        //  initializing the event
        $participant->onComment(new CEvent('CommentsUtils', array("participant" => $participant,
            "action" => $action,
            "comment" => $comment,
            "oldComment" => $oldComment)));
        return true;
    }

    public static function deleteComment($id, $user, &$errors) {
        $comment = Comment::model()->findByPk($id);
        if ($comment != NULL) {
            if (CommentsUtils::hasEditCommentPrivilege($user, $comment)) {
                try {
                    $comment->delete();
                } catch (Exception $e) {
                    array_push($errors, $e->getMessage());
                    return false;
                }
                CommentsUtils::commentNotification('delete', $user, $comment);
                return true;
            } else {
                array_push($errors, "not enough privileges");
                return false;
            }
        }
        return true;
    }

    public static function updateComment(&$newComment, $user, &$errors) {
        $comment = Comment::model()->findByPk($newComment->id);
        if ($comment != NULL) {
            if (CommentsUtils::hasEditCommentPrivilege($user, $comment)) {
                $oldComment = Comment::model()->findByPk($comment->id);
                $comment->text = $newComment->text;
                try {
                    $comment->save();
                } catch (Exception $e) {
                    array_push($errors, $e->getMessage());
                    return false;
                }
                $newComment = $comment;
                CommentsUtils::commentNotification('update', $user, $newComment, $oldComment);
                return true;
            } else {
                array_push($errors, "not enough privileges");
                return false;
            }
        }
        array_push($errors, "comment not found in db");
        return false;
    }

    public static function getUncommentedSubItems($item_id) {
        $commentedItems = CommentedItem::model()->findAllUncommented($item_id);
        $ids = array();
        foreach ($commentedItems as $commentedItem) {
            $ids[] = $commented_item->sub_item_id;
        }
        return $ids;
    }

    public static function enableDisableComments($item_id, $sub_item_id, $commented, $user, &$errors) {
        if (CommentsUtils::hasEnableDisableCommentsPriviledge($item_id, $user)) {
            $commentedItem = CommentedItem::model()->findByItemSubItem($item_id, $sub_item_id);
            if ($commentedItem == NULL) {
                $commentedItem = new CommentedItem();
                $commentedItem->item_id = $item_id;
                $commentedItem->sub_item_id = $sub_item_id;
            }
            $commented->commented = $commented;
            try {
                $commented->save();
            } catch (Exception $e) {
                array_push($errors, $e->getMessage());
                return false;
            }
        } else {
            array_push($errors, "not enough privileges");
            return false;
        }
        return true;
    }

    public static function countComments($item_id) {
        return Comment::model()->countEnabledComments($item_id);
    }

}

?>
