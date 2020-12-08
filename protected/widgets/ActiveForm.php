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
class ActiveForm extends CActiveForm {

    public static $tableCss = 'field';
    public static $requiredCss = 'requiredOne';
    public static $afterRequiredLabel = ' <span class="requiredOne">*</span>';
    public static $honeypotCss = 'ukazhite_e_mail';

    //  $htmlOptions могут включать tableClass, hintClass
    //  $htmlOptions can include tableClass, hintClass
    public function textFields($model, $attribute, $htmlOptions = array(), $align = 'horizontal', $languages = NULL, $visibleLanguages = NULL) {
        $match = preg_match('/^(?:\[(\d*\w*)\])?(.*)$/', $attribute, $matches);
        $modelAttribute = $matches[2];
        if ($model->hasErrors($modelAttribute)) {
            $this->addErrorCss($htmlOptions);
        }     

        if ($languages == NULL) {
            $languages = Yii::app()->params['languages'];
        }
        if ($visibleLanguages == NULL) {
            $visibleLanguages = $languages;
        }
        if (!is_array($visibleLanguages)) {
            $visibleLanguages = array($visibleLanguages => $visibleLanguages);
        }
        $hints = Yii::app()->params['hints'];
        if (count($visibleLanguages) < 2) {
            //  не выводим подсказки, если всего один язык
            //  do not show hint if only one language
            $hints = array(); 
        }
        $tableClass = ' class="' . ActiveForm::$tableCss . '" ';
        if (isset($htmlOptions['tableClass'])) {
            $tableClass = ' class="' . $htmlOptions['tableClass'] . '" ';
        };
        $hintClass = 'hint';
        if (isset($htmlOptions['hintClass'])) {
            $hintClass = $htmlOptions['hintClass'];
        };

        if ($align == 'horizontal') {
            $html = '<table' . $tableClass . '><tr>';
            $i = 0;
            foreach ($languages as $language => $name) {
                $style = ' style="display:none" ';
                if (isset($visibleLanguages[$language]) && ($visibleLanguages[$language]!='')) {
                    $style = '';
                }
                if ($i > 0) {
                    $html = $html . '<td>&nbsp;</td>';
                };
                $i++;
                $html = $html . '<td' . $style . '>' . CHtml::activeTextField($model, $attribute . '[' . $language . ']', $htmlOptions);
                if (isset($hints[$language])) {
                    $hint = Yii::t('site', $hints[$language]);
                    $html = $html . '<br /><span class=\'' . $hintClass . '\'>' . $hint . '</span>';
                }
                $html = $html . '</td>';
            }
            $html = $html . '</tr></table>';
        } else {
            $html = '<table' . $tableClass . '>';
            $i = 0;
            foreach ($languages as $language => $name) {
                $style = ' style="display:none" ';
                if (isset($visibleLanguages[$language]) && ($visibleLanguages[$language]!='')) {
                    $style = '';
                }
                if ($i > 0) {
                    $html = $html . '<tr><td style="height:3px;"></td></tr>';
                }
                $i++;
                $html = $html . '<tr' . $style . '><td>' . CHtml::activeTextField($model, $attribute . '[' . $language . ']', $htmlOptions);
                if (isset($hints[$language])) {
                    $hint = Yii::t('site', $hints[$language]);
                    $html = $html . '<br /><span class=\'' . $hintClass . '\'>' . $hint . '</span>';
                }
                $html = $html . '</td></tr>';
            }
            $html = $html . '</table>';
        }
        return $html;
    }

    public function hiddenFields($model, $attribute, $languages = NULL, $visibleLanguages = NULL) {
        if ($languages == NULL) {
            $languages = Yii::app()->params['languages'];
        }
        $html = ''; $htmlOptions = array();
        foreach ($languages as $language => $name) {
            $html = $html . CHtml::activeHiddenField($model, $attribute . '[' . $language . ']', $htmlOptions);
        }
        return $html;
    }

    //  $htmlOptions могут включать tableClass, hintClass
    //  $htmlOptions can include tableClass, hintClass
    public function textAreas($model, $attribute, $htmlOptions = array(), $align = 'horizontal', $languages = NULL, $visibleLanguages = NULL) {
        $match = preg_match('/^(?:\[(\d*\w*)\])?(.*)$/', $attribute, $matches);
        $modelAttribute = $matches[2];
        if ($model->hasErrors($modelAttribute)) {
            $this->addErrorCss($htmlOptions);
        }     
        
        if ($languages == NULL) {
            $languages = Yii::app()->params['languages'];
        }
        if ($visibleLanguages == NULL) {
            $visibleLanguages = $languages;
        }
        if (!is_array($visibleLanguages)) {
            $visibleLanguages = array($visibleLanguages => $visibleLanguages);
        }
        $hints = Yii::app()->params['hints'];
        if (count($visibleLanguages) < 2) {
            //  не выводим подсказки, если всего один язык
            //  do not hsow hints if only one language
            $hints = array();
        }

        $tableClass = ' class="' . ActiveForm::$tableCss . '" ';
        if (isset($htmlOptions['tableClass'])) {
            $tableClass = ' class="' . $htmlOptions['tableClass'] . '" ';
        };
        $hintClass = 'textareaHint';
        if (isset($htmlOptions['hintClass'])) {
            $hintClass = $htmlOptions['hintClass'];
        };

        if ($align == 'horizontal') {
            $html = '<table' . $tableClass . '><tr>';
            $i = 0;
            foreach ($languages as $language => $name) {
                $style = ' style="display:none" ';
                if (isset($visibleLanguages[$language]) && ($visibleLanguages[$language]!='')) {
                    $style = '';
                }
                if ($i > 0) {
                    $html = $html . '<td>&nbsp;</td>';
                };
                $i++;
                $html = $html . '<td' . $style . '>' . CHtml::activeTextArea($model, $attribute . '[' . $language . ']', $htmlOptions);
                $hint = '';
                if (isset($hints[$language])) {
                    $hint = '&nbsp;' . Yii::t('site', $hints[$language]);
                    $html = $html . '<span class=\'' . $hintClass . '\'>' . $hint . '</span></td>';
                }
            }
            $html = $html . '</tr></table>';
        } else {
            $html = '<table' . $tableClass . '>';
            $i = 0;
            foreach ($languages as $language => $name) {
                $style = ' style="display:none" ';
                if (isset($visibleLanguages[$language]) && ($visibleLanguages[$language]!='')) {
                    $style = '';
                }
                if ($i > 0) {
                    $html = $html . '<tr><td style="height:3px;"></td></tr>';
                }
                $i++;
                $html = $html . '<tr' . $style . '><td>' . CHtml::activeTextArea($model, $attribute . '[' . $language . ']', $htmlOptions);
                $hint = '';
                if (isset($hints[$language])) {
                    $hint = '&nbsp;' . Yii::t('site', $hints[$language]);
                    $html = $html . '<span class=\'' . $hintClass . '\' >' . $hint . '</span></td></tr>';
                }
            }
            $html = $html . '</table>';
        }
        return $html;
    }

    protected function addErrorCss(&$htmlOptions) {
        if (isset($htmlOptions['class']))
            $htmlOptions['class'].=' ' . CHtml::$errorCss;
        else
            $htmlOptions['class'] = CHtml::$errorCss;
    }

    public function label($model, $attribute, $htmlOptions = array()) {
        $html = '';
        if (isset($htmlOptions['requiredOne'])) {
            if ($htmlOptions['requiredOne']) {
                unset($htmlOptions['requiredOne']);
                $htmlOptions['required'] = true;

                $requiredCss = CHtml::$requiredCss;
                $afterRequiredLabel = CHtml::$afterRequiredLabel;
                CHtml::$requiredCss = self::$requiredCss;
                CHtml::$afterRequiredLabel = self::$afterRequiredLabel;

                $html = CHtml::activeLabel($model, $attribute, $htmlOptions);

                CHtml::$requiredCss = $requiredCss;
                CHtml::$afterRequiredLabel = $afterRequiredLabel;
            }
        } else {
            $html = CHtml::activeLabel($model, $attribute, $htmlOptions);
        }
        return $html;
    }

    //  метка с двоеточием
    //  a label with a colon
    public static function labelC($model, $attribute, $htmlOptions = array()) {
        //  e.g. $attribute = [12]image, $attribute = [Template]image
        $match = preg_match('/^(?:\[(\d*\w*)\])?(.*)$/', $attribute, $matches);
        $ownerIdx = $matches[1];
        $attribute = $matches[2];
        
        $html = '';
        $requiredOne = false;
        if (isset($htmlOptions['requiredOne'])) {
            if ($htmlOptions['requiredOne']) {
                unset($htmlOptions['requiredOne']);
                $htmlOptions['required'] = true;
                $requiredOne = true;
                $requiredCss = CHtml::$requiredCss;
                $afterRequiredLabel = CHtml::$afterRequiredLabel;
                CHtml::$requiredCss = self::$requiredCss;
                CHtml::$afterRequiredLabel = self::$afterRequiredLabel;
            }
        };
        if ($model->hasErrors($attribute)) {
            if (isset($htmlOptions['class']))
                $htmlOptions['class'].=' ' . CHtml::$errorCss;
            else
                $htmlOptions['class'] = CHtml::$errorCss;
        }
        $for = '';
        if (isset($htmlOptions['for'])) {
            $for = $htmlOptions['for'];
            unset($htmlOptions['for']);
        } else
            $for = CHtml::getIdByName(CHtml::resolveName($model, $attribute));
        $label = $model->getAttributeLabel($attribute) . ':';
        $html = CHtml::label($label, $for, $htmlOptions);
        if ($requiredOne) {
            CHtml::$requiredCss = $requiredCss;
            CHtml::$afterRequiredLabel = $afterRequiredLabel;
        };
        return $html;
    }

    public static function ViewFile($model, $attribute, $idx = -1, $languages = array('ru' => 'Русский')) {
        return $this->viewIndexedFileFields($model, $attribute, $idx, $languages);
    }

    public function fileFields($model, $attribute, $idx = -1, $languages = array('ru' => 'Русский'), $visibleLanguages = NULL) {
        return $this->indexedFileFields($model, $attribute, $idx, $languages, $visibleLanguages);
    }

    public static function ViewIndexedFile($model, $attribute, $idx, $languages = array('ru' => 'Русский')) {
        $hints = Yii::app()->params['hints'];
        if (count($languages) < 2) {
            $hints = array();
        }
        $file = $model->getFile($attribute, $idx);
        $html = "<table style='width:100%;' >";
        foreach ($languages as $language => $name) {
            $html.="<tr><td>";
            $hint = '&nbsp;';
            if (isset($hints[$language])) {
                $hint = Yii::t('site', $hints[$language]);
                $html = $html . '<span class=\'fileHint\'>' . $hint . '</span>';
            };
            $fileExists = $file && !$file->isEmpty($language);
            if ($fileExists) {
                $html .= CHtml::link(CHtml::encode($file->name($language)), $file->url($language)) . ' (' . $file->sizeStr($language) . ')';
            } else {
                $html .= Yii::t('site', 'No');
            };
            $html .= '</td></tr>';
        }
        $html .= '</table>';
        return $html;
    }
    
    public static function Sfu2016ViewIndexedFile($model, $attribute, $idx, $languages = array('ru' => 'Русский')) {
        $hints = Yii::app()->params['hints'];
        if (count($languages) < 2) {
            $hints = array();
        }
        $file = $model->getFile($attribute, $idx);
        $html = '';
        foreach ($languages as $language => $name) {
            $hint = '&nbsp;';
            if (isset($hints[$language])) {
                $hint = Yii::t('site', $hints[$language]);
                $html = $html . '<span class=\'fileHint\'>' . $hint . '</span>';
            };
            $fileExists = $file && !$file->isEmpty($language);
            if ($fileExists) {
                $html .= CHtml::link(CHtml::encode($file->name($language)), $file->url($language)) . ' <span class="text">(' . $file->sizeStr($language) . ')</span>';
            } else {
                $html .= Yii::t('site', 'No');
            };
            $html .= '<br />';
        }
        return $html;
    }


    public function indexedFileFields($model, $attribute, $idx, $languages = array('ru' => 'Русский'), $visibleLanguages = NULL) {
        //  e.g. $attribute = [12]image, $attribute = [Template]image
        $match = preg_match('/^(?:\[(\d*\w*)\])?(.*)$/', $attribute, $matches);
        $ownerIdx = $matches[1];
        $attribute = $matches[2];
        if (empty($ownerIdx) && ($ownerIdx !== 0) && ($ownerIdx !== '0')) {
            $ownerIdx = NULL;
        } else if ($ownerIdx !== 'Template') {
        //    $ownerIdx = NULL;
        //} else {
            $ownerIdx = intval($ownerIdx);
        };
        $model->ownerIdx = $ownerIdx;
        
        if ($model->hasErrors($attribute)) {
            $this->addErrorCss($htmlOptions);
        }
        $hints = Yii::app()->params['hints'];
        if ($visibleLanguages == NULL) {
            $visibleLanguages = $languages;
        }
        if (!is_array($visibleLanguages)) {
            $visibleLanguages = array($visibleLanguages => $visibleLanguages);
        }
        if (count($visibleLanguages) < 2) {
            //  не выводим подсказки, если всего один язык
            //  do not shpw hints if only one language
            $hints = array(); 
        }

        $file = $model->getFile($attribute, $idx);
        $html = "<table style='width:100%;' >";
        foreach ($languages as $language => $name) {
            $style = " style='display:none' ";
            if (isset($visibleLanguages[$language]) && ($visibleLanguages[$language]!='')) {
                $style = '';
            }
            $html.="<tr ${style}><td>";
            $hint = '&nbsp;';
            if (isset($hints[$language])) {
                $hint = Yii::t('site', $hints[$language]);
                $html = $html . '<span class=\'fileHint\'>' . $hint . '</span>';
            }

            $lang_attribute = get_class($model) . (($ownerIdx !== NULL)?'_' . strval($ownerIdx): '') . '_' . $attribute . '_' . $language;
            if ($idx >= 0) {
                $lang_attribute.='_' . $idx;
            }
            $inputFieldId = $model->getIdInputFieldName($attribute, $idx, $language);
            $inputFieldTempName = $model->getTempNameInputFieldName($attribute, $idx, $language);
            $fileInputField = $model->getFileInputFieldName($attribute, $idx, $language);
            $fileValid = $file && !$file->isEmpty($language) && $file->isValid($language);
            $fileInvalid = $file && !$file->isEmpty($language) && !$file->isValid($language);
            if ($fileValid) {
                $temp_name = urlencode($file->temp_name($language));
                $html.="<input type='hidden' id='{$lang_attribute}_id' name='{$inputFieldId}' value='{$file->id}' />";
                $html.="<input type='hidden' id='{$lang_attribute}_temp_name' name='{$inputFieldTempName}' value='{$temp_name}' />";
                $html.= CHtml::link(CHtml::encode(Yii::app()->getBaseUrl(true) . $file->url($language)), $file->url($language), array('id' => "{$lang_attribute}_link"));
                $html.='&nbsp;&nbsp;';
                $html.= CHtml::link(Yii::t('actions', 'delete'), 'javascript:return false;', array('class' => 'action','onclick' => "deleteFile('{$lang_attribute}',this)"));
                $html.='<br />';
                $html.=Yii::t('actions', 'Update') . ':&nbsp;' . CHtml::fileField($fileInputField, '', array('position' => 'relative'));
            } else if ($fileInvalid) {
                $temp_name = urlencode($file->temp_name($language));
                $html.="<input type='hidden' id='{$lang_attribute}_id' name='{$inputFieldId}' value='{$file->id}' />";
                $html.="<input type='hidden' id='{$lang_attribute}_temp_name' name='{$inputFieldTempName}' value='{$temp_name}' />";
                $html.= CHtml::link(CHtml::encode(Yii::app()->getBaseUrl(true) . $file->url($language)), $file->url($language), array('id' => "{$lang_attribute}_link", 'class'=>'error'));
                $html.='&nbsp;&nbsp;';
                $html.= CHtml::link(Yii::t('actions', 'delete'), 'javascript:return false;', array('onclick' => "deleteFile('{$lang_attribute}',this)"));
                $html.='<br />';
                $html.=Yii::t('actions', 'Update') . ':&nbsp;' . CHtml::fileField($fileInputField, '', array('position' => 'relative'));
            } else {
                $html.=Yii::t('actions', 'Upload') . ':&nbsp;' . CHtml::fileField($fileInputField, '', array('position' => 'relative'));
            }
            $html.='</td></tr>';
        }
        $html.='</table>';
        return $html;
    }

    public function imgFields($model, $attribute, $languages = array('ru' => 'Русский')) {
        //  e.g. $attribute = [12]image, $attribute = [Template]image
        $match = preg_match('/^(?:\[(\d*\w*)\])?(.*)$/', $attribute, $matches);
        $ownerIdx = $matches[1];
        $attribute = $matches[2];
        if (empty($ownerIdx) && ($ownerIdx !== 0) && ($ownerIdx !== '0')) {
            $ownerIdx = NULL;
        };
        $model->ownerIdx = $ownerIdx;

        if ($model->hasErrors($attribute)) {
            $this->addErrorCss($htmlOptions);
        }
        $hints = Yii::app()->params['hints'];
        if (count($languages) < 2) {
            //  не выводим подсказки, если всего один язык
            //  do not show hints when only one language
            $hints = array(); 
        }

        $file = $model->getFile($attribute);
        $html = "<table style='width:100%'>";
        foreach ($languages as $language => $name) {
            $html.="<tr><td>";
            $hint = '&nbsp;';
            if (isset($hints[$language])) {
                $hint = Yii::t('site', $hints[$language]);
                $html = $html . '<span class=\'fileHint\'>' . $hint . '</span>';
            }

            $lang_attribute = $attribute;
            if ($ownerIdx !== NULL) {
                $lang_attribute.='_' . $ownerIdx;
            };
            $lang_attribute.='_' . $language;
            $inputFieldId = $model->getIdInputFieldName($attribute, -1, $language);
            $inputFieldTempName = $model->getTempNameInputFieldName($attribute, -1, $language);
            $fileInputField = $model->getFileInputFieldName($attribute, -1, $language);
            if (($file != NULL) && !$file->isEmpty($language) && $file->isValid($language)) {
                $temp_name = urlencode($file->temp_name($language));
                $html.="<div id='{$lang_attribute}_div_id' name='{$lang_attribute}_div'>";
                $html.="<input type='hidden' id='{$lang_attribute}_id' name='{$inputFieldId}' value='{$file->id}' />";
                $html.="<input type='hidden' id='{$lang_attribute}_temp_name' name='{$inputFieldTempName}' value='{$temp_name}' />";
                $html.=CHtml::image($file->url($language), "{$attribute}", array('width' => '150', 'id' => "{$lang_attribute}_img", 'style' => 'margin:5px')) . '<br />';
                $html.='&nbsp;&nbsp;';
                $html.= CHtml::link(Yii::t('actions', 'delete'), 'javascript:return false;', array('class' => 'action','onclick' => "deleteFile('{$lang_attribute}',this)"));
                $html.='<br />';
                $html.="</div>";
                $html.=Yii::t('actions', 'Update') . ':&nbsp;' . CHtml::fileField($fileInputField, '', array('position' => 'relative'));
            } else {
                $html.="<div id='{$lang_attribute}_div_id' name='{$lang_attribute}_div'></div>";
                $html.=Yii::t('actions', 'Upload') . ':&nbsp;' . CHtml::fileField($fileInputField, '', array('position' => 'relative'));
            }
            $html.='</td></tr>';
        }
        $html.='</table>';
        return $html;
    }
    
    
    /*
$errorObjects = array($participant);
        $errorObjects = array_merge($errorObjects, $authors);
        $errorObjects = array_merge($errorObjects, array($captcha)); 
        $summary = $form->errorSummary2($participant, $authors, $captcha, $settings);
        $summary = $form->errorSummary($errorObjects);
        
     *      */
    
    protected function modelAttribute($settings, $attribute){
            $attribute_type = $settings->{$attribute . '_type'}; 
            if ($attribute == 'classification') { $attribute = 'classification_code'; };
            if ($attribute == 'report_topic') {$attribute = 'topic' ; };
            if ($attribute == 'report_title') {$attribute = 'title' ; };
            if ($attribute == 'report_text') {$attribute = 'content' ; };
            if ($attribute == 'more_info') {$attribute = 'information' ; };
            if ($attribute == 'accommodation') { $attribute = 'is_' . $attribute . '_required'; }; 
            if ($attribute == 'report_topic') { $attribute == 'topic'; };
            if ($attribute == 'report_file') { $attribute = 'content_files'; };
            if ($attribute == 'org') { $attribute = 'institution'; };
            if ($attribute == 'org_address') { $attribute = 'institution_address'; }; 
            if ($attribute == 'address') { $attribute = 'home_address';};
            if ($settings->isAdditionalAttribute($attribute) && ($attribute_type != FieldType::FILE)) {
                $attribute .= '_value';
            };
            if ($settings->isAdditionalAttribute($attribute) && ($attribute_type == FieldType::FILE)) { 
                $attribute .= '_files'; 
            };    
            return $attribute;
     }
        
    public function errorSummary2($participant, $authors, $captcha, $settings) {
        $content = '';
        $error = $participant->getError('ukazhite_e_mail'); //honeypot
        $content .= empty($error)?'':"<li>$error</li>\n";
        $pAttributesEnabled = $settings->getPAttributes(true);      
        $aAttributesEnabled = $settings->getAAttributes(true);
        if (!is_array($authors)) {
            $authors = array($authors);
        };
        foreach($pAttributesEnabled as $attribute) {
            if ($attribute == 'authors') {
                foreach($authors as $author) {
                    foreach($aAttributesEnabled as $attribute2) {
                        $attribute2 = $this->modelAttribute($settings, $attribute2);
                        $error = $author->getError($attribute2);
                        $content .= empty($error)?'':"<li>$error</li>\n";
                        if ($attribute2 == 'email') {
                            $error = $author->getError('password');
                            $content .= empty($error)?'':"<li>$error</li>\n";
                        }
                    }
                };
            } else {
                $attribute = $this->modelAttribute($settings, $attribute);
                $error = $participant->getError($attribute);
                $content .= empty($error)?'':"<li>$error</li>\n";
            };
        };        
        $error = $captcha->getError('verifyCode');
        $content .= empty($error)?'':"<li>$error</li>\n";
        return empty($content)?'':CHtml::tag('div', array('class' => 'errorSummary'), "\n<ul>\n$content</ul>");
    }
    
    public function honeypot($model, $attribute, $htmlOptions = array()) {
        $class = $htmlOptions['honeypotClass'];
        unset($htmlOptions['honeypotClass']);
        if (empty($class)) {
            $class = ActiveForm::$honeypotCss;
        };
        $html = CHtml::activeLabel($model, $attribute);
        $html .= CHtml::activeTextField($model, $attribute, array('autocomplete' => 'off'));
        $html = CHtml::tag('div', array('class' => $class), "$html");
        return $html;
    }
 

}

?>
