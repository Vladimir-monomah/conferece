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

require_once(dirname(__FILE__) . "/../extensions/tbs/tbs_class_php4.php");
require_once(dirname(__FILE__) . "/../extensions/tbs/tbs_plugin_opentbs.php");

class ExportController extends CController {

    const EXPORT_PUBLISHED = 'published';
    const EXPORT_ACCEPTED = 'accepted';
    const EXPORT_ALL = 'all';

    public function actionIndex() {
        throw new CHttpException(400, Yii::t('participants', 'Forbidden.'));
    }

    protected function canExport($id) {
        $conf = $this->findConf($id);
        $params = array('conf_id' => $id, 'user_id' => Yii::app()->user->id);
        if (Yii::app()->user->checkAccess('modifyConf', $params)) {
            return true;
        };
        return ($conf->participant_publishing_option == ParticipantPublishingOption::FULL_LIST);
    }

    public function actionHtml($id) {
        if (!$this->canExport($id)) {
            throw new CHttpException(400, Yii::t('participants', 'Forbidden.'));
        };
        $topic_id = NULL;
        if (isset($_GET['topic_id'])) {
            $topic_id = $_GET['topic_id'];
        };
        $export_option = isset($_GET['option'])?$_GET['option']:'';
        if (empty($export_option)) {
            $export_option = ExportController::EXPORT_ALL;
        };
        $conf = $this->findConf($id);
        $participants = ParticipantView::model()->findAllForExport($conf, $export_option, $topic_id);
        $participantGroups = Participant::model()->groupByTopic($participants);
        $topic = array();
        if ($topic_id != NULL) {
            if (intval($topic_id) == 0) {
                if (($export_option != ExportController::EXPORT_PUBLISHED)) {
                    $topics[] = ConfTopic::noTopic();
                };
            } else {
                $topic = ConfTopic::model()->findByPk($topic_id);
                $topics[] = $topic;
            };
        } else {
            $topics = ConfTopic::model()->findByConfNameAsc($conf);
            if ($export_option != ExportController::EXPORT_PUBLISHED || ($conf->topicCount == 0)) {
                array_push($topics, ConfTopic::noTopic());
            };
        };

        $topicGroups = ConfTopic::model()->groupByScientificArea($topics);
        $this->renderPartial('html', array('conf' => $conf, 'topicGroups' => $topicGroups, 'participantGroups' => $participantGroups));
    }

    public function actionZip($id) {
        if (!$this->canExport($id)) {
            throw new CHttpException(400, Yii::t('participants', 'Forbidden.'));
        };
        $topic_id = NULL;
        if (isset($_GET['topic_id'])) {
            $topic_id = $_GET['topic_id'];
        };
        $action = $_GET['action'];
        $export_option = $_GET['option'];
        if (empty($export_option)) {
            $export_option = ExportController::EXPORT_ALL;
        };
        if ($action == 'create') {
            $created = FALSE;
            $fileName = $_GET['file_name'];
            $fileName = $this->get_members_zip_archiv($id, $fileName, $export_option, $topic_id);
            if ($fileName === 'empty') {
                echo "<root><empty>Empty.</empty></root>";
            } else {
                $filePath = FileUtils::tempPath() . $fileName;
                $exportFilePath = FileUtils::storagePath() . 'export/' . $fileName;
                if (is_file($filePath)) {
                    $created = copy($filePath, $exportFilePath);
                };
                if ($created) {
                    echo "<root><created>Created.</created></root>";
                } else {
                    Yii::log("Error occured when copying the file {$filePath} to {$exportFilePath}.", 'error', 'ExportController.actionZip');
                    echo "<root><error>Error occured.</error></root>";
                };
            }
        } else if ($action == 'test') {
            $fileName = $_GET['file_name'];
            $filePath = FileUtils::tempPath() . $fileName;
            $exportFilePath = FileUtils::storagePath() . 'export/' . $fileName;
            if (is_file($exportFilePath)) {
                echo "<root><created>Created.</created></root>";
            } else if (is_file($filePath)) {
                $created = copy($filePath, $exportFilePath);
                if ($created) {
                    echo "<root><preparing>Archive is being prepared...</preparing></root>"; 
                } else {
                    Yii::log("Error occured when copying the file {$filePath} to {$exportFilePath}.", 'error', 'ExportController.actionZip');
                    echo "<root><error>Error occured.</error></root>";
                };               
            } else {
                echo "<root><preparing>Archive is being prepared...</preparing></root>";
            };
        };
        Yii::app()->end();
    }

    public function actionExcel($id) {
        if (!$this->canExport($id)) {
            throw new CHttpException(400, Yii::t('participants', 'Forbidden.'));
        };
        $topic_id = NULL;
        if (isset($_GET['topic_id'])) {
            $topic_id = $_GET['topic_id'];
        };
        $action = $_GET['action'];
        $export_option = $_GET['option'];
        if (empty($export_option)) {
            $export_option = ExportController::EXPORT_ALL;
        };
        if ($action == 'create') {
            $created = FALSE;
            $fileName = $_GET['file_name'];
            $fileName = $this->createXlsx($id, $fileName, $export_option, $topic_id);
            $filePath = FileUtils::tempPath() . $fileName;
            $exportFilePath = FileUtils::storagePath() . 'export' . DIRECTORY_SEPARATOR . $fileName;
            if (is_file($filePath)) {
                $created = copy($filePath, $exportFilePath);
            };
            if ($created) {
                echo "<root><created>Created.</created></root>";
            } else {
                Yii::log("Error occured when copying the file {$filePath} to {$exportFilePath}.", 'error', 'ExportController.actionExcel');
                echo "<root><error>Error occured.</error></root>";
            };
        } else if ($action == 'test') {
            $fileName = $_GET['file_name'];
            $filePath = FileUtils::tempPath() . $fileName;
            $exportFilePath = FileUtils::storagePath() . 'export'. DIRECTORY_SEPARATOR . $fileName;
            if (is_file($exportFilePath)) {
                echo "<root><created>Created.</created></root>";
            } else if (is_file($filePath)) {
                $created = copy($filePath, $exportFilePath);
                if ($created) {
                    echo "<root><preparing>Archive is being prepared...</preparing></root>";
                } else {
                    Yii::log("Error occured when copying the file {$filePath} to {$exportFilePath}.", 'error', 'ExportController.actionExcel');
                    echo "<root><error>Error occured.</error></root>";
                };
            } else {
                echo "<root><preparing>Archive is being prepared...</preparing></root>";
            };
        };
        Yii::app()->end();
    }
    
    public function actionAuthors($id) {
        if (!$this->canExport($id)) {
            throw new CHttpException(400, Yii::t('participants', 'Forbidden.'));
        };
        $topic_id = NULL;
        if (isset($_GET['topic_id'])) {
            $topic_id = $_GET['topic_id'];
        };
        $action = $_GET['action'];
        $export_option = $_GET['option'];
        if (empty($export_option)) {
            $export_option = ExportController::EXPORT_ALL;
        };
        if ($action == 'create') {
            $created = FALSE;
            $fileName = $_GET['file_name'];
            $fileName = $this->createAuthorsXlsx($id, $fileName, $export_option, $topic_id);
            $filePath = FileUtils::tempPath() . $fileName;
            $exportFilePath = FileUtils::storagePath() . 'export' . DIRECTORY_SEPARATOR . $fileName;
            if (is_file($filePath)) {
                $created = copy($filePath, $exportFilePath);
            };
            if ($created) {
                echo "<root><created>Created.</created></root>";
            } else {
                Yii::log("Error occured when copying the file {$filePath} to {$exportFilePath}.", 'error', 'ExportController.actionExcel');
                echo "<root><error>Error occured.</error></root>";
            };
        } else if ($action == 'test') {
            $fileName = $_GET['file_name'];
            $filePath = FileUtils::tempPath() . $fileName;
            $exportFilePath = FileUtils::storagePath() . 'export' . DIRECTORY_SEPARATOR . $fileName;
            if (is_file($exportFilePath)) {
                echo "<root><created>Created.</created></root>";
            } else if (is_file($filePath)) {
                $created = copy($filePath, $exportFilePath);
                if ($created) {
                    echo "<root><preparing>Archive is being prepared...</preparing></root>";
                } else {
                    Yii::log("Error occured when copying the file {$filePath} to {$exportFilePath}.", 'error', 'ExportController.actionExcel');
                    echo "<root><error>Error occured.</error></root>";
                };
            } else {
                echo "<root><preparing>Archive is being prepared...</preparing></root>";
            };
        };
        Yii::app()->end();
    }

    public function compareByLastnameFirstname($arr1, $arr2) {
        $lastname1 = mb_strtolower($arr1[0], 'UTF-8');
        $lastname2 = mb_strtolower($arr2[0], 'UTF-8');
        $firstname1 = mb_strtolower($arr1[1], 'UTF-8');
        $firstname2 = mb_strtolower($arr2[1], 'UTF-8');
        // так так нет возможности сравнить в utf-8, то пока так ...
        // so as these is no possibility to compare in utf-8, let it be like this ...
        if ($lastname1 == $lastname2) {
            if ($firstname1 == $firstname2) {
                return 0;
            }
            return ($firstname1 < $firstname2?-1:1);
        }
        return ($lastname1 < $lastname2?-1:1);
    }
    
    protected function createAuthorsXlsx($id, $fileName, $export_option, $topic_id = NULL) {
        $conf = $this->findConf($id);
        $conf_languages = $conf->getLanguages();
        $participants = ParticipantView::model()->findAllForExport($conf, $export_option, $topic_id);
        foreach ($participants as $participant) {
            $authors = $participant->_authors;
            foreach ($authors as $author) {
                $locale = $author->locale;
                $lastname = $this->convert_encoding($author->notEmptyLastname($locale));
                $middlename = $this->convert_encoding($author->notEmptyMiddlename($locale));
                $firstname = $this->convert_encoding($author->notEmptyFirstname($locale));
                $country = $this->convert_encoding($author->notEmptyCountry($locale));
                $city = $this->convert_encoding($author->notEmptyCity($locale));
                $email = $this->convert_encoding($author->email);
                $key = mb_strtolower($lastname, 'UTF-8') . mb_strtolower($firstname, 'UTF-8') . mb_strtolower($middlename, 'UTF-8') 
                        . mb_strtolower($country, 'UTF-8') .mb_strtolower($city, 'UTF-8') . mb_strtolower($email, 'UTF-8');
                $exported_data[$key] = array($lastname, $firstname, $middlename, $country, $city, $email);
            };        
        };      
        
        usort($exported_data, array("ExportController", "compareByLastnameFirstname"));
        $header =  array('Фамилия (Last name)', 'Имя (First name)', 'Отчество (Middle name)', 'Страна (Country)', 'Город (City)', 'E-mail');
        array_unshift($exported_data, $header); 
        
        if (empty($fileName)) {
            $fileName = $conf->urn() . "_authors_" . date('j_m_Y_h_m_s') . ".xlsx";
        };
        $filePath = FileUtils::tempPath() . $fileName;
        $excelObj = new PHPExcel();
        $excelObj->getActiveSheet()->fromArray($exported_data);
        
        // стили отображения
        // applying styles to the sheet
        $styles = array(
            'header' => array(
		'alignment' => array(
			'horizontal' => 'center',
			'vertical' => 'center',
		),
		'fill' => array(
			'type' => 'solid',
			'color' => array(
				'rgb' => 'BDBDBD',
			)
		),
            ),    
            'data-odd' => array(
		'alignment' => array(
			'horizontal' => 'left',
			'vertical' => 'top',
		), 
		'fill' => array(
			'type' => 'solid',
			'color' => array(
				'rgb' => 'F5F5F5',
			),
		)
            ),
            'data-even' => array(
		'alignment' => array(
			'horizontal' => 'left',
			'vertical' => 'top',
		), 
		'fill' => array(
			'type' => 'solid',
			'color' => array(
				'rgb' => 'FFFFFF',
			),
		)
            ),
            'row-height' => 25,
            'col-width' => array(24, 24, 24, 27, 24, 35)
        );
        $cols = 6;
        $rows = count($exported_data);
        for ($row = 1; $row <= $rows; $row++) {
            for ($col = 0; $col < $cols;  $col++) {
                $cell = $excelObj->getActiveSheet()->getCellByColumnAndRow($col, $row);
                if ($row == 1) {
                    $cell->getStyle()->applyFromArray($styles['header']);
                } elseif (($row % 2) == 1) {
                    $cell->getStyle()->applyFromArray($styles['data-even']);
                } else {
                    $cell->getStyle()->applyFromArray($styles['data-odd']);
                }
              	$excelObj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth($styles['col-width'][$col]);
            }
            $excelObj->getActiveSheet()->getRowDimension($row)->setRowHeight($styles['row-height']);   
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($excelObj, 'Excel2007');
        $objWriter->save($filePath);
        return $fileName;
    }
    
    protected function convert_encoding($string) {
        /*mb_regex_encoding("UTF-8");
        $string = $this->html_entity_decode($string);
        $string = mb_ereg_replace("[\r\n]", ' ', $string);*/
        $string = $this->html_entity_decode($string);
        return $string;
       // return mb_convert_encoding($string, "cp1251", "UTF-8");
    }

    protected function createXlsx($id, $fileName, $export_option, $topic_id = NULL) {
        $conf = $this->findConf($id);
        $conf_urn = Trim($conf->urn());
        $conf_languages = $conf->getLanguages();
        $settings = AppFormSettings::model()->findByConf($conf);
       
        // дополнительные списочные атрибуты автора
        // additional list author attributes
        $attributes = array();
        $_attributes = $settings->getAAttributes(true);
        foreach($_attributes as $attribute){
            $attribute_type = $settings->{$attribute . '_type'}; 
            if ($settings->isAdditionalAttribute($attribute) && ($attribute_type == FieldType::SELECT)) {
                $attributes[] = $attribute;
            }
        }
        // $name = $this->_appFormSettings->value($field . '_name');
        // $name = $this->_appFormSettings->strictValue($field . '_name');
                
                
        $header = array();

        $id = $this->convert_encoding(Yii::t('participants', 'Report Identifier'));
        array_push($header, $id);

        if ($conf->topicCount > 0) {
            if (count($conf_languages) > 1) {
                foreach ($conf_languages as $language => $name) {
                    $msg = 'Topic (' . $language . ')';
                    $topic = $this->convert_encoding(Yii::t('participants', $msg));
                    array_push($header, $topic);
                }
            } else {
                $msg = 'Topic';
                $topic = $this->convert_encoding(Yii::t('participants', $msg));
                array_push($header, $topic);
            }
        }
        
        // hack for Isuf2018 conference
        $topics_isuf2018 = array();      
        if ($conf_urn == 'isuf2018') {
            $topics_isuf2018 = $settings->getSelectFieldList('pl_field1');
            array_push($header, $this->convert_encoding('Topic of conference (Тема к обсуждению)'));
        }
        // hack for yeniseysibir
        $topics_yeniseysibir = array();
        if ($conf_urn == 'yeniseysibir') {
            $topics_yeniseysibir = $settings->getSelectFieldList('pl_field1');
            array_push($header, $this->convert_encoding('Направления научной работы'));
        }
        
        $partType = $this->convert_encoding(Yii::t('participants', 'Participation Type'));
        array_push($header, $partType);


        if (count($conf_languages) > 1) {
            foreach ($conf_languages as $language => $name) {
                $msg = 'Title (' . $language . ')';
                $title = $this->convert_encoding(Yii::t('participants', $msg));
                array_push($header, $title);
            }
        } else {
            $msg = 'Title';
            $title = $this->convert_encoding(Yii::t('participants', $msg));
            array_push($header, $title);
        }

        if (count($conf_languages) > 1) {
            foreach ($conf_languages as $language => $name) {
                $msg = 'Authors (' . $language . ')';
                $authors = $this->convert_encoding(Yii::t('participants', $msg));
                array_push($header, $authors);
            }
        } else {
            $msg = 'Authors';
            $authors = $this->convert_encoding(Yii::t('participants', $msg));
            array_push($header, $authors);
        }

        $emails = $this->convert_encoding('E-mail');
        array_push($header, $emails);

        $phone = $this->convert_encoding(Yii::t('participants', 'Phone'));
        array_push($header, $phone);

        if (count($conf_languages) > 1) {
            foreach ($conf_languages as $language => $name) {
                $msg = 'Institution (' . $language . ')';
                $organization = $this->convert_encoding(Yii::t('participants', $msg));
                array_push($header, $organization);
            }
        } else {
            $msg = 'Institution';
            $organization = $this->convert_encoding(Yii::t('participants', $msg));
            array_push($header, $organization);
        }

        // должность
		if (count($conf_languages) > 1) {
            foreach ($conf_languages as $language => $name) {
                $msg = 'Position (' . $language . ')';
                $position = $this->convert_encoding(Yii::t('participants', $msg));
                array_push($header, $position);
            }
        } else {
            $msg = 'Position';
            $position = $this->convert_encoding(Yii::t('participants', $msg));
            array_push($header, $position);
        }
        // конец должности

        // страна
	if (count($conf_languages) > 1) {
            foreach ($conf_languages as $language => $name) {
                $msg = 'Country (' . $language . ')';
                $city = $this->convert_encoding(Yii::t('participants', $msg));
                array_push($header, $city);
            }
        } else {
            $msg = 'Country';
            $city = $this->convert_encoding(Yii::t('participants', $msg));
            array_push($header, $city);
        }
	// конец страна
        
        // город
	if (count($conf_languages) > 1) {
            foreach ($conf_languages as $language => $name) {
                $msg = 'City (' . $language . ')';
                $city = $this->convert_encoding(Yii::t('participants', $msg));
                array_push($header, $city);
            }
        } else {
            $msg = 'City';
            $city = $this->convert_encoding(Yii::t('participants', $msg));
            array_push($header, $city);
        }
	// конец города

		if (count($conf_languages) > 1) {
            foreach ($conf_languages as $language => $name) {
                $msg = 'Academic Degree (' . $language . ')';
                $degree = $this->convert_encoding(Yii::t('participants', $msg));
                array_push($header, $degree);
            }
        } else {
            $msg = 'Academic Degree';
            $degree = $this->convert_encoding(Yii::t('participants', $msg));
            array_push($header, $degree);
        }

        if (count($conf_languages) > 1) {
            foreach ($conf_languages as $language => $name) {
                $msg = 'Supervisor (' . $language . ')';
                $supervisor = $this->convert_encoding(Yii::t('participants', $msg));
                array_push($header, $supervisor);
            }
        } else if ($conf_urn != 'yeniseysibir') {
            $msg = 'Supervisor';
            $supervisor = $this->convert_encoding(Yii::t('participants', $msg));
            array_push($header, $supervisor);
        }

        // дополнительные атрибуты автора
        foreach ($attributes as $attribute) {
            if (count($conf_languages) > 1) {
                foreach ($conf_languages as $language => $name) {
                    $msg = $settings->strictValue($attribute . '_name', $language);
                    $msg = $this->convert_encoding($msg);
                    array_push($header, $msg);
                }
            } else {
                $msg = $settings->value($attribute . '_name');
                $msg = $this->convert_encoding($msg);
                array_push($header, $msg);
            }
        }

        
        $file = $this->convert_encoding(Yii::t('participants', 'File'));
        array_push($header, $file);

        if (count($conf_languages) > 1) {
            foreach ($conf_languages as $language => $name) {
                $msg = 'Annotation (' . $language . ')';
                $annotation = $this->convert_encoding(Yii::t('participants', $msg));
                array_push($header, $annotation);
            }
        } else if ($conf_urn == 'yeniseysibir') {
            array_push($header, $this->convert_encoding('Технические средства, необходимые для доклада'));
        } else {
            $msg = 'Annotation';
            $annotation = $this->convert_encoding(Yii::t('participants', $msg));
            array_push($header, $annotation);
        }
        
        
        $reports = array("0" => $header);

        $topics = array();
        if ($topic_id == NULL) {
            $topics = ConfTopic::model()->findByConfNameAsc($conf);
            if ($export_option != ExportController::EXPORT_PUBLISHED || ($conf->topicCount == 0)) {
                array_push($topics, ConfTopic::noTopic());
            };
        } else {
            if (intval($topic_id) == 0) {
                if ($export_option != ExportController::EXPORT_PUBLISHED) {
                    array_push($topics, ConfTopic::noTopic());
                }
            } else {
                array_push($topics, ConfTopic::model()->findByPk($topic_id));
            }
        };

        $participants = ParticipantView::model()->findAllForExport($conf, $export_option, $topic_id);
        $this->assignFileNames($conf, $participants, $export_option, $topic_id);
        $participantGroups = Participant::model()->groupByTopic($participants);

        $empty_str = '  ';

		foreach ($topics as $topic) {
            $participants = isset($participantGroups[$topic->id])?$participantGroups[$topic->id]:array();
            if (empty($participants)) {
                continue;
            };
            foreach ($participants as $participant) {
                $buf = array();

                array_push($buf, $this->convert_encoding($participant->id));

                if ($conf_urn == 'isuf2018') {
                    $topic_id = $participant->pl_field1_value;
                    array_push($buf, $this->convert_encoding($topics_isuf2018[$topic_id]));
                } if ($conf_urn == 'yeniseysibir') {
                    $topic_id = $participant->pl_field1_value;
                    array_push($buf, $this->convert_encoding($topics_yeniseysibir[$topic_id]));                   
                } else {
                    if ($conf->topicCount > 0) {
                    if (count($conf_languages) > 1) {
                        foreach ($conf_languages as $language => $name) {
                            $topic_title = $this->convert_encoding($topic->title($language));
                            if (empty($topic_title)) {
                                $topic_title = $empty_str;
                            }
                            array_push($buf, $topic_title);
                        }
                    } else {
                        $topic_title = $this->convert_encoding($topic->title());
                        if (empty($topic_title)) {
                            $topic_title = $empty_str;
                        }
                        array_push($buf, $topic_title);
                    }
                    }
                }

                $partType = $this->convert_encoding($participant->participationType());
                if (empty($partType)) {
                    $partType = $empty_str;
                }
                array_push($buf, $partType);


                if (count($conf_languages) > 1) {
                    foreach ($conf_languages as $language => $name) {
                        $title = $this->convert_encoding($participant->title($language));
                        if (empty($title)) {
                            $title = $empty_str;
                        }
                        array_push($buf, $title);
                    };
                } else {
                    $title = $this->convert_encoding($participant->title());
                    if (empty($title)) {
                        $title = $empty_str;
                    }
                    array_push($buf, $title);
                }

                $authors = $participant->_authors;
                $leftColumns = count($buf);
                $rightColumns = 0;

                //  главный автор
                //  main author
                $author = array_shift($authors);

                if (count($conf_languages) > 1) {
                    foreach ($conf_languages as $language => $name) {
                        $authors_str = NULL;
                        if ($author) {
                            $authors_str = $this->convert_encoding($author->authorFullName($language));
                        }
                        if (empty($authors_str)) {
                            $authors_str = $empty_str;
                        }
                        array_push($buf, $authors_str);
                    }
                } else {
                    $authors_str = NULL;
                    if ($author) {
                        $authors_str = $this->convert_encoding($author->authorFullName());
                    }
                    if (empty($authors_str)) {
                        $authors_str = $empty_str;
                    }
                    array_push($buf, $authors_str);
                }

                $email = $this->convert_encoding($author->email);
                if (empty($email)) {
                    $email = $empty_str;
                }
                array_push($buf, $email);

                $phone = $this->convert_encoding($author->phone);
                if (empty($phone)) {
                    $phone = $empty_str;
                }
                array_push($buf, $phone);

                if (count($conf_languages) > 1) {
                    foreach ($conf_languages as $language => $name) {
                        $organization_str = $this->convert_encoding($author->institution($language));
                        if (empty($organization_str)) {
                            $organization_str = $empty_str;
                        }
                        array_push($buf, $organization_str);
                    }
                } else {
                    $organization_str = NULL;
                    if ($author) {
                        $organization_str = $this->convert_encoding($author->institution());
                    }
                    if (empty($organization_str)) {
                        $organization_str = $empty_str;
                    }
                    array_push($buf, $organization_str);
                }

                // должность
				if (count($conf_languages) > 1) {
                    foreach ($conf_languages as $language => $name) {
                        $position_str = $this->convert_encoding($author->position($language));
                        if (empty($position_str)) {
                            $position_str = $empty_str;
                        }
                        array_push($buf, $position_str);
                    }
                } else {
                    $position_str = NULL;
                    if ($author) {
                        $position_str = $this->convert_encoding($author->position());
                    }
                    if (empty($position_str)) {
                        $position_str = $empty_str;
                    }
                    array_push($buf, $position_str);
                }
				// конец должности

                // страна
		if (count($conf_languages) > 1) {
                    foreach ($conf_languages as $language => $name) {
                        $country_str = $this->convert_encoding($author->country($language));
                        if (empty($country_str)) {
                            $country_str = $empty_str;
                        }
                        array_push($buf, $country_str);
                    }
                } else {
                    $country_str = NULL;
                    if ($author) {
                        $country_str = $this->convert_encoding($author->country());
                    }
                    if (empty($country_str)) {
                        $country_str = $empty_str;
                    }
                    array_push($buf, $country_str);
                }
	        // конец страна
                
                // город
		if (count($conf_languages) > 1) {
                    foreach ($conf_languages as $language => $name) {
                        $city_str = $this->convert_encoding($author->city($language));
                        if (empty($city_str)) {
                            $city_str = $empty_str;
                        }
                        array_push($buf, $city_str);
                    }
                } else {
                    $city_str = NULL;
                    if ($author) {
                        $city_str = $this->convert_encoding($author->city());
                    }
                    if (empty($city_str)) {
                        $city_str = $empty_str;
                    }
                    array_push($buf, $city_str);
                }
				// конец города

				if (count($conf_languages) > 1) {
                    foreach ($conf_languages as $language => $name) {
                        $degree_str = $this->convert_encoding($author->academicDegree($language));
                        if (empty($degree_str)) {
                            $degree_str = $empty_str;
                        }
                        array_push($buf, $degree_str);
                    }
                } else {
                    $degree_str = NULL;
                    if ($author) {
                        $degree_str = $this->convert_encoding($author->academicDegree());
                    }
                    if (empty($degree_str)) {
                        $degree_str = $empty_str;
                    }
                    array_push($buf, $degree_str);
                }

                if (count($conf_languages) > 1) {
                    foreach ($conf_languages as $language) {
                        $supervisors_str = $this->convert_encoding($author->supervisor($language));
                        if (empty($supervisors_str)) {
                            $supervisors_str = $empty_str;
                        }
                        array_push($buf, $supervisors_str);
                    }
                } else if ($conf_urn != 'yeniseysibir') {
                    $supervisors_str = NULL;
                    if ($author) {
                        $supervisors_str = $this->convert_encoding($author->supervisor());
                    }
                    if (empty($supervisors_str)) {
                        $supervisors_str = $empty_str;
                    }
                    array_push($buf, $supervisors_str);
                }
                
                 // дополнительные атрибуты автора (только списки)
                foreach ($attributes as $attribute) {
                    if (count($conf_languages) > 1) {
                        foreach ($conf_languages as $language => $name) {
                            $item_id = $author->l_field_value($attribute . '_value');
                            $list_item = ListItem::model()->findByPk($item_id);
                            $msg = $list_item?$list_item->itemValue($language):'';
                            $msg = $this->convert_encoding($msg);
                            array_push($buf, $msg);
                        }
                    } else {
                        $item_id = $author->l_field_value($attribute . '_value');
                        $list_item = ListItem::model()->findByPk($item_id);
                        $msg = $list_item?$list_item->itemValue():'';
                        $msg = $this->convert_encoding($msg);
                        array_push($buf, $msg);
                    }
                }

                $file_dest = $participant->file_dest;
                $combined_file_dest = '';
                foreach($file_dest as $_file_dest){
                    $combined_file_dest .= $_file_dest . "\n";
                };
                $file_dest = $combined_file_dest;
                if (!empty($file_dest)) {
                    $file = $this->convert_encoding($file_dest);
                } else {
                    $file = $empty_str;
                }
                array_push($buf, $file);
                $rightColumns++;

                if (count($conf_languages) > 1) {
                    foreach ($conf_languages as $language => $name) {
                        $annotation = $participant->annotation($language);
                        $annotation = $this->convert_encoding($annotation);
                        if (empty($annotation)) {
                            $annotation = $empty_str;
                        }
                        array_push($buf, $annotation);
                        $rightColumns++;
                    }
                } else if ($conf_urn == 'yeniseysibir') {
                    $annotation = StringUtils::stripTags($participant->pt_field2_value['ru']); 
                    $annotation = $this->convert_encoding($annotation);
                    if (empty($annotation)) {
                        $annotation = $empty_str;
                    }
                    array_push($buf, $annotation);
                    $rightColumns++;
                } else {
                    $annotation = $participant->annotation();
                    $annotation = $this->convert_encoding($annotation);
                    if (empty($annotation)) {
                        $annotation = $empty_str;
                    }
                    array_push($buf, $annotation);
                    $rightColumns++;
                }                
                array_push($reports, $buf);

                //  остальные авторы
                //  other authors
                if (empty($authors)) {
                    $authors = array();
                }
                foreach ($authors as $n => $author) {

                    $buf = array();
                    for ($i = 0; $i < $leftColumns; $i++) {
                        array_push($buf, $empty_str);
                    }

                    if (count($conf_languages) > 1) {
                        foreach ($conf_languages as $language => $name) {
                            $authors_str = $this->convert_encoding($author->authorFullName($language));
                            if (empty($authors_str)) {
                                $authors_str = $empty_str;
                            }
                            array_push($buf, $authors_str);
                        }
                    } else {
                        $authors_str = $this->convert_encoding($author->authorFullName());
                        if (empty($authors_str)) {
                            $authors_str = $empty_str;
                        }
                        array_push($buf, $authors_str);
                    }

                    $email = $this->convert_encoding($author->email);
                    if (empty($email)) {
                        $email = $empty_str;
                    };
                    array_push($buf, $email);

                    $phone = $this->convert_encoding($author->phone);
                    if (empty($phone)) {
                        $phone = $empty_str;
                    };
                    array_push($buf, $phone);

                    if (count($conf_languages) > 1) {
                        foreach ($conf_languages as $language => $name) {
                            $organization_str = $this->convert_encoding($author->institution($language));
                            if (empty($organization_str)) {
                                $organization_str = $empty_str;
                            }
                            array_push($buf, $organization_str);
                        }
                    } else {
                        $organization_str = $this->convert_encoding($author->institution());
                        if (empty($organization_str)) {
                            $organization_str = $empty_str;
                        }
                        array_push($buf, $organization_str);
                    }

                    // должность
		    if (count($conf_languages) > 1) {
                        foreach ($conf_languages as $language => $name) {
                            $position_str = $this->convert_encoding($author->position($language));
                            if (empty($position_str)) {
                                $position_str = $empty_str;
                            }
                            array_push($buf, $position_str);
                        }
                    } else {
                        $position_str = $this->convert_encoding($author->position());
                        if (empty($position_str)) {
                            $position_str = $empty_str;
                        }
                        array_push($buf, $position_str);
                    }
		    // конец должности

                    // страна
		    if (count($conf_languages) > 1) {
                        foreach ($conf_languages as $language => $name) {
                            $country_str = $this->convert_encoding($author->country($language));
                            if (empty($country_str)) {
                                $country_str = $empty_str;
                            }
                            array_push($buf, $country_str);
                        }
                    } else {
                        $country_str = $this->convert_encoding($author->country());
                        if (empty($country_str)) {
                            $country_str = $empty_str;
                        }
                        array_push($buf, $country_str);
                    }
		    // конец страна
                    
                    // город
		    if (count($conf_languages) > 1) {
                        foreach ($conf_languages as $language => $name) {
                            $city_str = $this->convert_encoding($author->city($language));
                            if (empty($city_str)) {
                                $city_str = $empty_str;
                            }
                            array_push($buf, $city_str);
                        }
                    } else {
                        $city_str = $this->convert_encoding($author->city());
                        if (empty($city_str)) {
                            $city_str = $empty_str;
                        }
                        array_push($buf, $city_str);
                    }
		    // конец города

		    if (count($conf_languages) > 1) {
                        foreach ($conf_languages as $language => $name) {
                            $degree_str = $this->convert_encoding($author->academicDegree($language));
                            if (empty($degree_str)) {
                                $degree_str = $empty_str;
                            }
                            array_push($buf, $degree_str);
                        }
                    } else {
                        $degree_str = NULL;
                        if ($author) {
                            $degree_str = $this->convert_encoding($author->academicDegree());
                        }
                        if (empty($degree_str)) {
                            $degree_str = $empty_str;
                        }
                        array_push($buf, $degree_str);
                    }

                    if (count($conf_languages) > 1) {
                        foreach ($conf_languages as $language => $name) {
                            $supervisors_str = $this->convert_encoding($author->supervisor($language));
                            if (empty($supervisors_str)) {
                                $supervisors_str = $empty_str;
                            }
                            array_push($buf, $supervisors_str);
                        }
                    } else if ($conf_urn != 'yeniseysibir') {
                        $supervisors_str = $this->convert_encoding($author->supervisor());
                        if (empty($supervisors_str)) {
                            $supervisors_str = $empty_str;
                        }
                        array_push($buf, $supervisors_str);
                    }
                    
                     // дополнительные атрибуты автора
                    foreach ($attributes as $attribute) {
                        if (count($conf_languages) > 1) {
                            foreach ($conf_languages as $language => $name) {
                                $item_id = $author->l_field_value($attribute . '_value');
                                $list_item = ListItem::model()->findByPk($item_id);
                                $msg = $list_item?$list_item->itemValue($language):'';
                                $msg = $this->convert_encoding($msg);
                                array_push($buf, $msg);
                            }
                        } else {
                            $item_id = $author->l_field_value($attribute . '_value');
                            $list_item = ListItem::model()->findByPk($item_id);
                            $msg = $list_item?$list_item->itemValue():'';
                            $msg = $this->convert_encoding($msg);
                            array_push($buf, $msg);
                        }
                    }

                    for ($i = 0; $i < $rightColumns; $i++) {
                        array_push($buf, $empty_str);
                    }
                    array_push($reports, $buf);
                }
            }
        }

        /*
        старый вариант с генерацией .csv          
        if (empty($fileName)) {
            $fileName = $conf->urn() . "_reports_" . date('j_m_Y_h_m_s') . ".csv";
        };
        $filePath = FileUtils::tempPath() . $fileName;

        $fp = fopen($filePath, 'w');
        fprintf($df, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM for UTF8
        $created = ($fp !== FALSE);
        foreach ($reports as $k => $v) {
            $created = $created && (fputcsv($fp, $v, "\t") !== FALSE);
            //$created = $created && fwrite($fp, implode($v, "\t") . "\n");
        };
        $created = $created && fclose($fp);
        if (!$created) {
            Yii::log("Error occured when creating excel file {$filePath}.", 'error', 'ExportController.createCsv');         
        };
        */
        
        if (empty($fileName)) {
            $fileName = $conf->urn() . "_reports_" . date('j_m_Y_h_m_s') . ".xlsx";
        };
        $filePath = FileUtils::tempPath() . $fileName;
        $excelObj = new PHPExcel();
        $excelObj->getActiveSheet()->fromArray($reports);
        
        // стили отображения
        // applying styles to the sheet
        $styles = array(
            'header' => array(
		'alignment' => array(
			'horizontal' => 'center',
			'vertical' => 'center',
		),
		'fill' => array(
			'type' => 'solid',
			'color' => array(
				'rgb' => 'BDBDBD',
			)
		),
            ),    
            'data-odd' => array(
		'alignment' => array(
			'horizontal' => 'justify',
			'vertical' => 'top',
		), 
		'fill' => array(
			'type' => 'solid',
			'color' => array(
				'rgb' => 'F5F5F5',
			),
		),
                'borders' => array(
			'allborders' => array(
				'style' => 'thin',
				'color' => array('rgb' => 'ffffff')
			),
		),
            ),
            'data-even' => array(
		'alignment' => array(
			'horizontal' => 'justify',
			'vertical' => 'top',
		), 
		'fill' => array(
			'type' => 'solid',
			'color' => array(
				'rgb' => 'FFFFFF',
			),
		),
            	'borders' => array(
			'allborders' => array(
				'style' => 'thin',
				'color' => array('rgb' => 'f5f5f5')
			),
		),

            ),
            'row-height' => 25,
            'col-width-isuf2018' => array(26, 50, 25, 50, 50, 30, 30, 30, 30, 40, 40, 30, 30, 20, 20, 23, 23, 30, 30, 30, 30, 40, 35, 35),
            'col-width-yeniseysibir' =>  array(26, 50, 25, 50, 50, 50, 30, 30, 30, 30, 40, 40, 30, 45),
            'col-width' => array(26, 50, 50, 25, 50, 50, 30, 30, 30, 30, 40, 40, 30, 30, 20, 20, 23, 23, 30, 30, 30, 30, 40, 35, 35),
            'col-width-980' => array(26, 50, 50, 25, 50, 50, 30, 30, 30, 30, 40, 40, 30, 30, 20, 20, 23, 23, 30, 30, 30, 30, 35, 35, 40, 35, 35)
        );
        $col_width_key = "col-width-${conf_urn}";
        if (!isset($styles[$col_width_key])) { $col_width_key = "col-width"; };
        $cols = count($reports[0]);
        $rows = count($reports);
        $odd = 'odd';
        for ($row = 1; $row <= $rows; $row++) {
            for ($col = 0; $col < $cols;  $col++) {
                $cell = $excelObj->getActiveSheet()->getCellByColumnAndRow($col, $row);
                if ($row == 1) {
                    $cell->getStyle()->applyFromArray($styles['header']);
                } else { 
                    if ($col == 0) {
                        $val = trim($cell->getValue());
                        if (!empty($val)) {
                            $odd = ($odd == 'odd'?'even':'odd');
                        }
                    }
                    $cell->getStyle()->applyFromArray($styles["data-${odd}"]);
                }    
                $width = isset($styles[$col_width_key][$col])?$styles[$col_width_key][$col]:30; 
                $excelObj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth($width);
            }
            if ($row == 1) {
                $excelObj->getActiveSheet()->getRowDimension($row)->setRowHeight($styles['row-height']);  
            }
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($excelObj, 'Excel2007');
        $objWriter->save($filePath);

        return $fileName;
    }

    public function actionProgram($id) {
        if (!$this->canExport($id)) {
            throw new CHttpException(400, Yii::t('participants', 'Forbidden.'));
        };
        $topic_id = NULL;
        if (isset($_GET['topic_id'])) {
            $topic_id = $_GET['topic_id'];
        };
        $action = $_GET['action'];
        $export_option = $_GET['option'];
        if (empty($export_option)) {
            $export_option = ExportController::EXPORT_ALL;
        };
        if ($action == 'create') {
            $created = FALSE;
            $fileName = $_GET['file_name'];
            $fileName = $this->CreateConfProgram($id, $fileName, $export_option, $topic_id);
            $filePath = FileUtils::tempPath() . $fileName;
            $exportFilePath = FileUtils::storagePath() . 'export' . DIRECTORY_SEPARATOR . $fileName;
            if (is_file($filePath)) {
                $created = copy($filePath, $exportFilePath);
            };
            if ($created) {
                echo "<root><created>Created.</created></root>";
            } else {
                Yii::log("Error occured when copying the file {$filePath} to {$exportFilePath}.", 'error', 'ExportController.actionProgram');
                echo "<root><error>Error occured.</error></root>";
            }
        } else if ($action == 'test') {
            $fileName = $_GET['file_name'];
            $filePath = FileUtils::tempPath() . $fileName;
            $exportFilePath = FileUtils::storagePath() . 'export' . DIRECTORY_SEPARATOR . $fileName;
            if (is_file($exportFilePath)) {
                echo "<root><created>Created.</created></root>";
            } else if (is_file($filePath)) {
                $created = copy($filePath, $exportFilePath);
                if ($created) {
                    echo "<root><preparing>Archive is being prepared...</preparing></root>";
                } else {
                    Yii::log("Error occured when copying the file {$filePath} to {$exportFilePath}.", 'error', 'ExportController.actionProgram');
                    echo "<root><error>Error occured.</error></root>";
                };
            } else {
                echo "<root><preparing>Archive is being prepared...</preparing></root>";
            };
        };
        Yii::app()->end();
    }

    protected function CreateConfProgram($conf_id, $fileName, $export_option, $topic_id = NULL) {
        $conf = $this->findConf($conf_id);

        if (empty($fileName)) {
            $fileName = $conf->urn() . "_program_" . date('j_m_Y_h_i_s') . ".docx";
        }
        $TBS = new clsTinyButStrong;
        $TBS->PlugIn(TBS_INSTALL, OPENTBS_PLUGIN);
        $template = Yii::getPathOfAlias('application.extensions.tbs') . DIRECTORY_SEPARATOR . 'conf_program.docx';
        if ($conf->topicCount == 0) {
            $template = Yii::getPathOfAlias('application.extensions.tbs') . DIRECTORY_SEPARATOR . 'conf_program_notopics.docx';
        };
        $TBS->SetOption('noerr', true);

        global $show_logo;
        $show_logo = 0;
        $logo = $conf->getFile('logo');
        if ($logo) {
            $show_logo = 1;
        };

        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

        $dates = '';
        if (!empty($conf->start_date)) {
            if ($conf->start_date == $conf->end_date) {
                $dates = Yii::app()->locale->dateFormatter->formatDateTime($conf->start_date, 'long', NULL);
            } else {
                $dates = Yii::app()->locale->dateFormatter->formatDateTime($conf->start_date, 'long', NULL) . ' – ' . Yii::app()->locale->dateFormatter->formatDateTime($conf->end_date, 'long', NULL);
            }
        };

        //  title page
        $export_conf = array(
            'subject' => $conf->subject(),
            'title' => $conf->title(),
            'location' => $conf->place(),
            'dates' => $dates,
            'program_label' => Yii::t('confs', 'Conference Program'));
        $TBS->MergeField('conf', $export_conf);

        //  conf logo
        if ($show_logo == 1) {
            $logo_path = $logo->path();
            $prms = array('unique' => true);
            $TBS->Plugin(OPENTBS_CHANGE_PICTURE, 'conf_logo', $logo_path, $prms);
        };

        $topics = array();
        if ($topic_id == NULL) {
            $topics = ConfTopic::model()->findByConf($conf);
            if ($export_option != ExportController::EXPORT_PUBLISHED || ($conf->topicCount == 0)) {
                array_push($topics, ConfTopic::noTopic());
            };
        } else {
            if (intval($topic_id) == 0) {
                if ($export_option != ExportController::EXPORT_PUBLISHED) {
                    array_push($topics, ConfTopic::noTopic());
                }
            } else {
                array_push($topics, ConfTopic::model()->findByPk($topic_id));
            }
        }

        $participants = ParticipantView::model()->findAllForExport($conf, $export_option, $topic_id);
        $participantGroups = Participant::model()->groupByTopic($participants);

        $export_topics = array();
        global $export_participants;
        $export_participants = array();
        foreach ($topics as $topic) {
            $topicTitle = $topic->title();
            if ($conf->topicCount == 0) {
                $topicTitle = Yii::t('participants', 'Participants');
            };

            $export_topics[] = array(
                'topic_id' => $topic->id,
                'title' => $topicTitle,
                'place' => $topic->place(),
                'place_label' => Yii::t('confs', 'Place') . ':',
                'time_label' => Yii::t('participants', 'Start Time'),
                'participant_label' => Yii::t('participants', 'Participant')
            );

            $export_participants[$topic->id] = array();
            $participants = isset($participantGroups[$topic->id])?$participantGroups[$topic->id]:array();
            if (empty($participants)) {
                continue;
            };

            foreach ($participants as $i => $participant) {
                $j = $i + 1;
                $time = '';

                $startDate = $participant->getStartDate();
                $startTime = $participant->getStartTime();
                if (!empty($startDate) || !empty($startTime)) {
                    $time = Yii::app()->locale->dateFormatter->formatDateTime($participant->start_date, 'long', NULL);
                    if (!empty($startTime)) {
                        if (!empty($time)) {
                            $time.="\n";
                        };
                        $time.=$startTime;
                    };
                };
                $title = $this->html_entity_decode($participant->title());
                $export_participants[$topic->id][] = array(
                    'number' => "$j.",
                    'time' => $time,
                    'name' => $participant->authorNames(),
                    'title' => $title);
            };
        }

        $TBS->MergeBlock('main', $export_topics);
        $TBS->MergeBlock('sub', 'array', 'export_participants[%p1%]');

        $filePath = FileUtils::tempPath() . $fileName;
        $TBS->Show(OPENTBS_FILE, $filePath); 

        return $fileName;
    }

    public function actionDspace($id) {
        if (!$this->canExport($id)) {
            throw new CHttpException(400, Yii::t('participants', 'Forbidden.'));
        };
        $topic_id = NULL;
        if (isset($_GET['topic_id'])) {
            $topic_id = $_GET['topic_id'];
        };
        $action = $_GET['action'];
        $export_option = $_GET['option'];
        if (empty($export_option)) {
            $export_option = ExportController::EXPORT_ALL;
        };
        if ($action == 'create') {
            $created = FALSE;
            $fileName = $_GET['file_name'];
            $fileName = $this->getDspaceArchive($id, $fileName, $export_option, $topic_id);
            if ($fileName === 'empty') {
                echo "<root><empty>Empty.</empty></root>";
            } else {
                $filePath = FileUtils::tempPath() . $fileName;
                $exportFilePath = FileUtils::storagePath() . 'export' . DIRECTORY_SEPARATOR . $fileName;
                if (is_file($filePath)) {
                    $created = copy($filePath, $exportFilePath);
                };
                if ($created) { 
                    echo "<root><created>Created.</created></root>";
                } else {
                    Yii::log("Error occured when copying the file {$filePath} to {$exportFilePath}.", 'error', 'ExportController.actionDspace');
                    echo "<root><error>Error occured.</error></root>";
                };
            }
        } else if ($action == 'test') {
            $fileName = $_GET['file_name'];
            $filePath = FileUtils::tempPath() . $fileName;
            $exportFilePath = FileUtils::storagePath() . 'export' . DIRECTORY_SEPARATOR . $fileName;
            if (is_file($exportFilePath)) {
                echo "<root><created>Created.</created></root>";
            } else if (is_file($filePath)) {
                $created = copy($filePath, $exportFilePath);
                if ($created) {
                    echo "<root><preparing>Archive is being prepared...</preparing></root>";
                } else {
                    Yii::log("Error occured when copying the file {$filePath} to {$exportFilePath}.", 'error', 'ExportController.actionDspace');
                    echo "<root><error>Error occured.</error></root>";
                };
            } else {
                echo "<root><preparing>Archive is being prepared...</preparing></root>";
            };
        };
        Yii::app()->end();
    }

    protected function nvl($value, $default) {
        return empty($value) ? $default : $value;
    }

    protected function first($values) {
        foreach ($values as $lang => $value) {
            if (!empty($value)) {
                return $value;
            }
        };
        return '';
    }

    protected function getDspaceArchive($conf_id, $fileName, $export_option, $topic_id = NULL) {

        Yii::log(' Dspace-archive creation started: ' . $fileName, 'info', 'dspace');

        $article_extensions = Yii::app()->params['dspaceExportExts'];

        $conf = $this->findConf($conf_id);

        if (empty($fileName)) {
            $fileName = $conf->urn() . "_dspace_" . date('j_m_Y_h_i_s') . ".zip";
        }

        $zip_path = FileUtils::tempPath() . $fileName;
        $zip = new ZipArchive();
        if ($zip->open($zip_path, ZIPARCHIVE::CREATE) !== TRUE) {
            Yii::log(' Could not create archive: ' . $fileName, 'error', 'dspace');
            echo "Could not create archive.";
            exit(1);
        }

        $topics = array();
        if ($topic_id == NULL) {
            $topics = ConfTopic::model()->findByConfNameAsc($conf);
            if ($export_option != ExportController::EXPORT_PUBLISHED || ($conf->topicCount == 0)) {
                array_push($topics, ConfTopic::noTopic());
            };
        } else {
            if (intval($topic_id) == 0) {
                if ($export_option != ExportController::EXPORT_PUBLISHED) {
                    array_push($topics, ConfTopic::noTopic());
                };
            } else {
                array_push($topics, ConfTopic::model()->findByPk($topic_id));
            };
        };
        $participants = ParticipantView::model()->findAllForExport($conf, $export_option, $topic_id);
        $participantGroups = Participant::model()->groupByTopic($participants);

        $i = 0;
        $conf_articles = 1;
        $skipped_articles = 0;
        foreach ($topics as $topic) {
            $participants = isset($participantGroups[$topic->id])?$participantGroups[$topic->id]:array();
            if (empty($participants)) {
                continue;
            };
            foreach ($participants as $participant) {
                $i++;
                //$participant = Participant::model()->findByPk($participantView->id);
                //  загрузка информации о докладе
                //  load information about report
                $file = $participant->getContentFile(); 
           
                if (!$file || $file->isEmpty() || !is_readable($file->path())) {
                    $skipped_articles++;
                    Yii::log($i . ' !Participant without file: id=' . $participant->id, 'info', 'dspace');
                    //  пропуск докладов без файлов
                    //  skip applications whithout files attached
                    continue;
                }
                $ext = $file->extension();
                if (!in_array($ext, $article_extensions)) {
                    $skipped_articles++;
                    Yii::log($i . ' !Unsupported file format (.' . $ext . '): id=' . $participant->id, 'info', 'dspace');
                    //  пропуск неподдерживаемых форматов файлов
                    //  skip unsupported file formats
                    continue; 
                }
                $authors = $participant->_authors;
                $this->add_article2zip($zip, $conf, $topic, $participant, $file, "items/item$conf_articles", $authors);

                $conf_articles++;
                Yii::log($i . ' File added: id=' . $participant->id, 'info', 'dspace');
            }
        }
        $conf_articles--;
        //  закрываем архив и переадресуем на файл
        //  closing archive and redirecting to the file
        $numFiles = $zip->numFiles;
        $created = $zip->close();
        $filesize = FileUtils::fileSizeStr(filesize($zip_path));

        if ($created) {
            Yii::log('Archive creation ' . $fileName . ' completed. Files added (total) : ' . $conf_articles . '. Files skipped: ' . $skipped_articles, 'info', 'ExportController.getDspaceArchive');
        } else {
            Yii::log('Error occured when creating zip archive: ' . $zip_path, 'error', 'ExportController.getDspaceArchive'); 
        };
        
        if($created && ($numFiles <= 0)){
            return 'empty';
        }
        
        return $fileName;
    }
    
    protected function html_entity_decode($string) {
        return html_entity_decode($string, ENT_COMPAT | ENT_HTML401, 'UTF-8');
    }

    protected function add_article2zip($zip, $conf, $topic, $participant, $file, $item_dir, $authors) {

        $xml_template = "<?xml version='1.0' encoding='utf-8'?>
<dublin_core>
\$xml	<dcvalue element='publisher' qualifier='none' language='ru'>Сибирский федеральный университет</dcvalue>
</dublin_core>";

        $langs = $conf->getLanguages();

        //  dublin_core.xml
        $xml = '';

        //  локализуемые поля
        //  localized fields
        foreach ($langs as $lang => $name) {
            //  заголовок
            //  title
            $title = $participant->title($lang);
            $title = $this->html_entity_decode($title);
            if (!empty($title))
                $xml .= $this->format_xml_field('title', 'none', htmlspecialchars($title), $lang);

            //  авторы
            //  authors
            foreach ($authors as $author) {
                $authorName = $author->authorNameDC($lang);
                if (!empty($authorName))
                    $xml .= $this->format_xml_field('contributor', 'author', htmlspecialchars($authorName), $lang);
            }

            //  аннотация
            //  annotation
            $abstract = $participant->annotation($lang);
            $abstract = $this->html_entity_decode($abstract);
            $abstract = $this->prepare_abstract($abstract);
            if (!empty($abstract))
                $xml .= $this->format_xml_field('description', 'abstract', $abstract, $lang);
        }

        //  библиографическое описание
        //  bibliography
        $citation = $this->format_citation($conf, $participant, $authors);
        if ($citation != '')
            $xml .= $this->format_xml_field('identifier', 'citation', htmlspecialchars($citation), 'ru');

        //  контакты (email)
        //  contacts (email)
	/*
        $emails = array();
        foreach ($authors as $author) {
            if (($email = trim($author->email)) != '') {
                $emails[$email] = TRUE;
            }
        }
        if ($emails) {
            $contacts = htmlspecialchars(join(', ', array_keys($emails)));
            $xml .= $this->format_xml_field('x-contacts', 'none', $contacts);
        }
	*/

        //  дата публикации
        //  publication date
        if ($conf->getPublicationDate() || $conf->start_date) {
            $issued = $conf->getPublicationDate() ? date("Y-m-d", $conf->getPublicationDate()) : date('Y', $conf->start_date);
            $xml .= $this->format_xml_field('date', 'issued', $issued);
        }

        //  источник (название конференции и секции)
        //  source (conference name and topic)
        $values = array();
        foreach ($langs as $lang => $name) {
            $values[$lang] = $this->format_conf_title($conf, $lang);
        }
        $source = $this->first($values);
        if ($source != "") {
            $ruTitle = $topic->strictTitle('ru');
            if ($topic->id != 0 && !empty($ruTitle)) {
                $source .= ", ";
                $source .= strpos(mb_strtolower($ruTitle), 'секция') === 0 ? $ruTitle : "Секция «" . $ruTitle . "»";
            }
            $source = $this->html_entity_decode($source);
            $xml .= $this->format_xml_field('source', 'none', htmlspecialchars($source));
        }

        eval("\$xml = \"$xml_template\";");
        $zip->addFromString("$item_dir/dublin_core.xml", $xml);

        //  contents
        $file_out = str_replace(" ", "_", $file->name());
        $zip->addFromString("$item_dir/contents", "$file_out\tbundle:ORIGINAL\n");

        //  pdf/doc
        $zip->addFile($file->path(), "$item_dir/$file_out");
    }

    /**  
     *  форматирование названия конференции.
     * 
     *  Conference name formatting.
     */
    protected function format_conf_title($conf, $lang = '') {
        if ($lang != '')
            $lang = "$lang";
        $subject = $conf->strictSubject($lang);
        $full_name = $conf->strictTitle($lang);
        if ($full_name == "")
            return "";
        return $this->html_entity_decode($subject == "" ? $full_name : "$subject «${full_name}»");
    }

    /** 
     *  форматирование одного DC-поля в XML.
     * 
     *  Formatting single DC field to XML.
     */
    protected function format_xml_field($element, $qualifier, $value, $language = '') {
        $xml_field_template = "\t<dcvalue element='\$element' qualifier='\$qualifier'\$language>\$value</dcvalue>\n";
	$value = trim(preg_replace("/\s+/", ' ', $value));
        if ($qualifier == '')
            $qualifier = 'none';
        $xml = '';
        if ($language == 'ru')
            $language = '';
        if ($language != '')
            $language = " language='$language'";
        eval("\$xml=\"$xml_field_template\";");
        return $xml;
    }

    /** 
     *  Подготовка аннотации к включению в XML.
     *  
     *  Prepare annotation to include into XML.
     */
    protected function prepare_abstract($abstract) {
        $abstract = preg_replace("|<table>.*?</table>|ims", " ", trim($abstract));
        $abstract = strip_tags(str_replace('&nbsp;', ' ', $abstract));
        $abstract = preg_replace("/[ \t\r\n]+/", " ", $abstract);
        $abstract = htmlspecialchars(trim($abstract));
        return $abstract;
    }
    
    protected function format_citation($conf, $participant, $authors) {

        $citation_template = '${c_author} $c_title // $c_conf, сборник материалов [Электронный ресурс]. — Красноярск: Сибирский федеральный ун-т, ${c_year}. — Режим доступа: ${c_url}, свободный.';
        $citation_template2 = '${c_author} $c_title / $c_authors // $c_conf, сборник материалов [Электронный ресурс]. — Красноярск: Сибирский федеральный ун-т, ${c_year}. — Режим доступа: ${c_url}, свободный.';
        
        $langs = $conf->getLanguages();
        $citation = '';
        $values = array();
        foreach ($langs as $lang => $name) {
            $values[$lang] = $participant->title($lang);
        };
        $c_title = trim(preg_replace("/\s+/", ' ', $this->html_entity_decode($this->first($values))));
        $values = array();
        foreach ($langs as $lang => $name) {
            $values[$lang] = $this->format_conf_title($conf, $lang);
        };
        $c_conf = $this->first($values);
        $c_year = date('Y', $this->nvl($conf->getPublicationDate(), $conf->start_date));
        $c_url = $this->createAbsoluteUrl('participant/view', array('urn' => $conf->urn(), 'participant_urn' => $participant->urn()));
        if ($c_title == '' || $c_conf == "" || $conf->start_date == 0)
            return '';
        $authorView = current($authors);
        $values = array();
        $langs = $conf->getLanguages();
        foreach ($langs as $lang => $name) {
            $values[$lang] = $authorView->authorNameDC($lang);
        };
        $c_author = $this->first($values);
        if ($c_author == '')
            return '';
        if (count($authors) == 1) {
            eval("\$citation=\"$citation_template\";");
        } elseif (count($authors) > 1) {
            $c_authors = array();
            foreach ($authors as $authorView) {
                $values = array();
                $langs = $conf->getLanguages();
                foreach ($langs as $lang => $name) {
                    $values[$lang] = $authorView->authorNameDC2($lang);
                };
                $authorName = $this->first($values);
                if ($authorName != '')
                    $c_authors[] = $authorName;
            }
            if (count($c_authors) == 1) {
                eval("\$citation=\"$citation_template\";");
            } else {
                $c_authors = join(', ', $c_authors);
                eval("\$citation=\"$citation_template2\";");
            }
        }
        return $citation;
    }

    protected function searchExportFileName($files, $id) {
        foreach ($files as $file) {
            if ($file['participant_id'] == $id) {
                return $file;
            }
        }
        return NULL;
    }

    protected function get_members_zip_archiv($conf_id, $fileName = NULL, $export_option, $topic_id = NULL) {
        $conf = $this->findConf($conf_id);
        $src_dir = FileUtils::$webFolder . DIRECTORY_SEPARATOR;

        //  создание zip архива
        $zip = new ZipArchive();

        //  имя файла архива
        if (empty($fileName)) {
            $fileName = $conf->urn() . "_export_" . date('j_m_Y_h_m_s') . ".zip";
        };
        $filePath = FileUtils::$tempFolder . DIRECTORY_SEPARATOR . $fileName;

        if ($zip->open($filePath, ZIPARCHIVE::CREATE) !== true) {
            Yii::log(' Could npt create archive: ' . $fileName, 'error', 'zip');
            echo "Error while creating archive file";
            exit(1);
        }

        //  добавляем в архив все файлы из папки src_dir
        //  adding all files from src_dir folder to archive
        Yii::log(' Starting creating zip-archive: ' . $filePath, 'info', 'zip');
        $dirHandle = opendir($src_dir);
        $files = $this->getExportFileNames($conf, $export_option, $topic_id);
        foreach ($files as $i => $file) {
            if (is_file($src_dir . $file['src'])) {
                $result = $zip->addFile($src_dir . $file['src'], $file['dest']);
                if (!$result) { 
                    //Yii::log($i . ' Error occured when adding new file to archive. Source: ' . $file['src'] . ' File name in archive: ' . $file['dest'], 'error', 'zip');
                } else {
                    //Yii::log($i . ' File successfully added to archive. Source: ' . $file['src'] . ' File name in archive: ' . $file['dest'], 'info', 'zip');
                };
            }
        }

        //  закрываем архив
        //  closing arcive
        $numFiles = $zip->numFiles;
        $created = $zip->close();
        if ($created) {
            Yii::log('Archive created: ' . $filePath . ' numFiles = ' . $numFiles, 'info', 'zip');
        } else {
            Yii::log('Error occured when creating zip archive: ' . $filePath, 'error', 'ExportController.get_members_zip_archiv');   
        };
        
        if($created && ($numFiles <= 0)){
            return 'empty';
        }
        
        return $fileName;
    }

    public function compare_src($a, $b) {
        return strnatcmp($a['src'], $b['src']);
    }

    public function compare_dest($a, $b) {
        return strnatcmp($a['dest'], $b['dest']);
    }

    // экспорт файлов для конференции ISUF2018
    // files export for the conference with urn = Isuf2018
    protected function getExportFileNamesIsuf2018($conf) {
        $files = array();
        $languages = $conf->getLanguages();
        $settings = AppFormSettings::model()->findByConf($conf);
        $participants = Participant::model()->findByConf($conf, false);        
        $topics = $settings->getSelectFieldList('pl_field1');
        $fileDests = array(); // для обеспечения уникальности имен файлов в архиве
        foreach ($participants as $participant) {
           $topic_id = $participant->pl_field1_value; 
           $topicDir = FileUtils::safeFileName($topics[$topic_id]);
           $topicDir = substr($topicDir, 0, 100);
           // файлы аннотаций
           $annotation_files = $participant->getFiles('pf_field1_files');
           foreach ($annotation_files as $file) {               
                if ($file && !$file->isEmpty()) {
                    foreach ($languages as $lang => $name) {
                        $fileSrc = $file->strictName($lang);
                        if (empty($fileSrc)) { continue; };
                        
                        $fileDest = $participant->id . '_annotation' . '_' . $lang . '_' . $participant->authorNames() . '_' . $participant->title();
                        $fileDest = FileUtils::safeFileName($fileDest);
                        $fileDest = substr($fileDest, 0, 100);
                        
                        $dest = (empty($topicDir)?'':($topicDir . DIRECTORY_SEPARATOR)) . $fileDest;                       
                                                
                        if(!array_key_exists($dest, $fileDests)){
                            $fileDests[$dest] = 0;  
                        } else {
                            $fileDests[$dest] += 1;  
                            $num = $fileDests[$dest];                      
                            $dest .= "_$num" ; 
                        };           
                        $dest .= '.' . FileUtils::getExtension($fileSrc);
                        
                        array_push($files, array('participant_id' => $participant->id, 'src' => $fileSrc, 'dest' => $dest));
                    };
                }
           }                    
           // полная версия статьи
           $full_text_files = $participant->getFiles('pf_field2_files');
           foreach ($full_text_files as $file) {
                if ($file && !$file->isEmpty()) {
                    foreach ($languages as $lang => $name) {
                        $fileSrc = $file->strictName($lang);
                        if (empty($fileSrc)) { continue; };
                        
                        $fileDest = $participant->id . '_full_text' . '_' . $lang . '_' . $participant->authorNames() . '_' . $participant->title();
                        $fileDest = FileUtils::safeFileName($fileDest);
                        $fileDest = substr($fileDest, 0, 100);
                        
                        $dest = (empty($topicDir)?'':($topicDir . DIRECTORY_SEPARATOR)) . $fileDest;                       
                                                
                        if(!array_key_exists($dest, $fileDests)){
                            $fileDests[$dest] = 0;  
                        } else {
                            $fileDests[$dest] += 1;  
                            $num = $fileDests[$dest];                      
                            $dest .= "_$num" ; 
                        };           
                        $dest .= '.' . FileUtils::getExtension($fileSrc);
                        
                        array_push($files, array('participant_id' => $participant->id, 'src' => $fileSrc, 'dest' => $dest));
                    };
                }
           }             
        };       
        return $files;
    }
    
    protected function getExportFileNames($conf, $export_option, $topic_id = NULL) {

        $conf_urn = Trim($conf->urn());
        
        // хак для конференции 975
        // hack for conference 975
        if ($conf_urn == 'isuf2018') { // ISUF2018
            return $this->getExportFileNamesIsuf2018($conf);
        };
        
        $languages = Yii::app()->params['languages'];
        $files = array();
        $topics = array();
        if ($topic_id == NULL) {
            $topics = ConfTopic::model()->findByConfNameAsc($conf);
            if ($export_option != ExportController::EXPORT_PUBLISHED || ($conf->topicCount == 0)) {
                array_push($topics, ConfTopic::noTopic());
            };
        } else {
            if (intval($topic_id) == 0) {
                if ($export_option != ExportController::EXPORT_PUBLISHED) {
                    array_push($topics, ConfTopic::noTopic());
                };
            } else {
                array_push($topics, ConfTopic::model()->findByPk($topic_id));
            };
        }
        $participants = ParticipantView::model()->findAllForExport($conf, $export_option, $topic_id);
        $topic_id = -1;
        $topic = NULL;
        $topicDir = NULL;
        $topicDirs = array();
        
        $fileDests = array(); // для обеспечения уникальности имен файлов fileName => num
        
        foreach ($participants as $participant) {
            if ($topic_id != $participant->topic_id) {
                $topic_id = $participant->topic_id;
                foreach ($topics as $_topic) {
                    if ($_topic->id == $topic_id) {
                        $topic = $_topic;
                        $topicDir = FileUtils::safeFileName($topic->title());
                        $topicDir = substr($topicDir, 0, 100);
                        if (in_array($topicDir, $topicDirs)) {
                            $topicDir .= '_';
                        }
                        $topicDirs[] = $topicDir;
                        break;
                    }
                };
            };
            $participant_files = $participant->getContentFiles();
            foreach($participant_files as $file){
                if ($file && !$file->isEmpty()) {
                    foreach($languages as $lang => $name){
                        $fileSrc = $file->strictName($lang);
                        if(empty($fileSrc)) { continue; };
                        $fileDest = $participant->id . '_' . $lang . '_' . $participant->fileDest();
                        $fileDest = FileUtils::safeFileName($fileDest);
                        $fileDest = substr($fileDest, 0, 100);
                        
                        $dest = (empty($topicDir)?'':($topicDir . DIRECTORY_SEPARATOR)) . $fileDest;                       
                        if ($conf->topicCount == 0) {
                            $dest = $fileDest;
                        };
                                                
                        if(!array_key_exists($dest, $fileDests)){
                            $fileDests[$dest] = 0;  
                        } else {
                            $fileDests[$dest] += 1;  
                            $num = $fileDests[$dest];                      
                            $dest .= "_$num" ; 
                        };           
                        $dest .= '.' . FileUtils::getExtension($fileSrc);
                        array_push($files, array('participant_id' => $participant->id, 'src' => $fileSrc, 'dest' => $dest));
                    };
                }
           }
        };
             
        return $files;
    }

    protected function assignFileNames($conf, &$participants, $export_option, $topic_id) {

        $conf_id = $conf->id;
        $languages = Yii::app()->params['languages'];

        $files = array();

        $topics = array();
        if ($topic_id == NULL) {
            $topics = ConfTopic::model()->findByConfNameAsc($conf);
            if ($export_option != ExportController::EXPORT_PUBLISHED) {
                array_push($topics, ConfTopic::noTopic());
            };
        } else {
            if (intval($topic_id) == 0) {
                if ($export_option != ExportController::EXPORT_PUBLISHED) {
                    array_push($topics, ConfTopic::noTopic());
                }
            } else {
                array_push($topics, ConfTopic::model()->findByPk($topic_id));
            }
        };

        $topic_id = -1;
        $topic = NULL;
        $topicDir = NULL;
        
        $fileDests = array(); // для обеспечения уникальности имен файлов fileName => num
        
        foreach ($participants as &$participant) {
            if ($topic_id != $participant->topic_id) {
                $topic_id = $participant->topic_id;
                foreach ($topics as $_topic) {
                    if ($_topic->id == $topic_id) {
                        $topic = $_topic;
                        $topicDir = FileUtils::safeFileName($topic->title());
                        $topicDir = substr($topicDir, 0, 100);
                        break;
                    }
                };
            };
            $files = $participant->getContentFiles();
            $participant->file_src = array();
            $participant->file_dest = array();
            foreach($files as $file){
                if ($file && !$file->isEmpty()) {
                    foreach($languages as $lang => $name){
                        $fileSrc = $file->strictName($lang);
                        if(empty($fileSrc)) { continue; };
                        $participant->file_src[] = $fileSrc;
                        $fileDest = $participant->id . '_' . $lang . '_' . $participant->fileDest();
                        $fileDest = FileUtils::safeFileName($fileDest);
                        $fileDest = substr($fileDest, 0, 100);     
                        if ($conf->topicCount > 0) {
                            $fileDest = $topicDir . DIRECTORY_SEPARATOR . $fileDest;
                        };
                        if(!array_key_exists($fileDest, $fileDests)){
                          $fileDests[$fileDest] = 0;  
                        } else {
                            $fileDests[$fileDest] += 1;  
                            $num = $fileDests[$fileDest];                      
                            $fileDest .= "_$num" ;      
                        };
                        $participant->file_dest[] = $fileDest . "." . FileUtils::getExtension($fileSrc);
                    };
                };
            };
        };
        unset($participant);        
        return $participants;
    }

    protected $conf = NULL;

    protected function findConf($id) {
        if ($this->conf == NULL) {
            $this->conf = Conf::model()->findByUrn($id);
            if (is_null($this->conf)) {
                throw new CHttpException(404, Yii::t('confs', 'Conference not found.'));
            }
        }
        return $this->conf;
    }

    public function accessRules() {
        $params = 'array(
            "conf_id"=>Yii::app()->getRequest()->getQuery("id"),
            "user_id"=>Yii::app()->user->id
        )';
        return array(
            array('allow',
                'actions' => array('html', 'zip', 'excel', 'dspace', 'program', 'authors'),
                'expression' => 'Yii::app()->user->checkAccess("viewAllParticipants",' . $params . ')'
            ),
            array('deny',
                'users' => array('*')   //  any user
            )
        );
    }

}

?>
