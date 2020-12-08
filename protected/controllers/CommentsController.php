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
class CommentsController extends CController {

    function actionIndex() {
        
        $user = Yii::app()->user;

        $action = $_POST['action']; //  counts, list, add, update, delete
        if (empty($action)) {
            $action = "counts";
        }

        $output = '';

        if (!isset($user)) {
            $output = errorXML('unauthorized access');
        } else {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($action == "add") {
                    $item_id = $_POST['item_id'];
                    $sub_item_id = $_POST['sub_item_id'];
                    $text = $_POST['text'];

                    if (empty($text) or empty($sub_item_id) or empty($item_id)) {
                        $output = $this->errorXML('not enough parameters');
                    } else {
                        $comment = new Comment();
                        $comment->item_id = $item_id;
                        $comment->user_id = $user->id;
                        $comment->sub_item_id = $sub_item_id;
                        $comment->text = $text;
                        $errors = array();
                        if (CommentsUtils::addComment($comment, $user, $errors)) {
                            $comment->username = CommentsUtils::getUsername($user->id);
                            $output = $this->commentXML($comment);
                        } else {
                            $output = $this->errorXML('error occured:' . $this->errorsToStr($errors));
                        }
                    }
                } if
                ($action == "delete") {
                    $id = $_POST['comment_id'];
                    if (empty($id)) {
                        $output = $this->errorXML('not enough parameters');
                    } else {
                        $errors = array();
                        if (CommentsUtils::deleteComment($id, $user, $errors)) {
                            $output = $this->successXML('removed');
                        } else {
                            $output = $this->errorXML('error occured:' . $this->errorsToStr($errors));
                        }
                    }
                } if
                ($action == "update") {
                    $id = $_POST['comment_id'];
                    $text = $_POST['text'];
                    if (empty($text) or empty($id)) {
                        $output = $this->errorXML('not enough parameters');
                    } else {
                        $errors = array();
                        $comment = new Comment();
                        $comment->id = $id;
                        $comment->text = $text;
                        if (CommentsUtils::updateComment($comment, $user, $errors)) {
                            $comment->username = CommentsUtils::getUsername($user->id);
                            $output = $this->commentXML($comment);
                        } else {
                            $output = $this->errorXML('error occured:' . $this->errorsToStr($errors));
                        }
                    }
                } if
                ($action == "enableComments") {
                    $item_id = $_POST['item_id'];
                    $sub_item_id = $_POST['sub_item_id'];
                    if (empty($item_id) or empty($sub_item_id)) {
                        $output = $this->errorXML('not enough parameters');
                    } else {
                        $errors = array();
                        if (CommentsUtils::enableDisableComments($item_id, $sub_item_id, 'Y', $user, $errors)) {
                            $output = $this->successXML('comments enabled');
                        } else {
                            $output = $this->errorXML('error occured:' . $this->errorsToStr($errors));
                        }
                    }
                } if
                ($action == "disableComments") {
                    $item_id = $_POST['item_id'];
                    $sub_item_id = $_POST['sub_item_id'];
                    if (empty($item_id) or empty($sub_item_id)) {
                        $output = $this->errorXML('not enough parameters');
                    } else {
                        $errors = array();
                        if (CommentsUtils::enableDisableComments($item_id, $sub_item_id, 'N', $user, $errors)) {
                            $output = $this->successXML('comments disabled');
                        } else {
                            $output = $this->errorXML('error occured:' . $this->errorsToStr($errors));
                        }
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::log("Error occured when processing a comment.", 'error', 'CommentsController.actionIndex');
                throw new CHttpException(400, 'System error.');
            }
        }
        echo $output;
        Yii::app()->end();
    }

    function errorXML($errorMsg) {
        return "<root>
                <error>
                $errorMsg
                </error>
                </root>";
    }

    function successXML($msg) {
        return "<root>
                <success>
                $msg
                </success>
                </root>";
    }

    function commentXML($comment) {
        $commentDate = CommentsUtils::formatCommentDate($comment->date);
        $text = CommentsUtils::prepareText($comment->text);
        return "<root>
                <comment>
                  <id>{$comment->id}</id>
                  <editable>true</editable>
                  <text>{$text}</text>
                  <author>{$comment->username}</author>
                  <date>{$commentDate}</date>
                </comment>
               </root>";
    }

    function errorsToStr($errors) {
        $res = '';
        foreach ($errors as $error) {
            $res .= $error;
        }
        return $res;
    }

    public function filters() {
        return array_merge(
                parent::filters(), 
                array( 'accessControl',)
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index'),
                'expression' => '!Yii::app()->user->isGuest'
            ),
            array('deny',
                'users' => array('*')   //  any user
            )
        );
    }

}

?>
