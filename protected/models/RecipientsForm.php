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
class RecipientsForm extends CFormModel {
    
    /* 
     * $r[participant_id]['selected'] = TRUE|FALSE
     * $r[participant_id]['title'] = 'Title'
     * $r[participant_id]['authors'][author_id]['selected'] = TRUE|FALSE 
     * $r[participant_id]['authors'][author_id]['email'] = 'Author Name <author@email>'
     * $r[participant_id]['authors'][author_id]['valid'] = TRUE|FALSE
     * $r[participant_id]['locale'] = 'preffered email language'
     */
    public $recipients;
    
    public function rules() {
        return array(
            array('recipients', 'safe')
        );
    }
    
    
    public function init($conf, $participantViews, $mailTask = NULL) {
        mb_regex_encoding("UTF-8");
        $validator = new CEmailValidator();
        $validator->allowEmpty = FALSE;
        $validator->allowName  = TRUE; 
        $r = array();
        $selected = array();
        if ($mailTask != NULL) {
            $selected = $mailTask->unpackParticipants($mailTask->participants);
        }
        foreach($participantViews as $participantView){
            $r[$participantView->id] = array();
            $r[$participantView->id]['selected'] = isset($selected[$participantView->id]);
            $r[$participantView->id]['title'] = $participantView->fullTitleWithLinks($conf);
            $authors = $participantView->authors;
            $locale = '';
            $r[$participantView->id]['authors'] = array();
            $n = -1;
            foreach($authors as $author_id => $author){
                $n++;
                if ($n==0) {
                    // using locale of the first author
                    $locale = $author->locale;
                    $r[$participantView->id]['locale'] = $locale;
                }
                $name = $author->authorNameForEmail($locale);
                $email = trim($author->email);
                // remove forbidden characters (brackets and comma)
                $name = mb_ereg_replace('[<>,]', '', $name);
                $email = mb_ereg_replace('[<>,]', '', $email);
                $email = (empty($email)?$name:"${name} <${email}>");
                $r[$participantView->id]['authors'][$author->id]['selected'] = (isset($selected[$participantView->id])?in_array($email, $selected[$participantView->id]['authors']):FALSE);
                $r[$participantView->id]['authors'][$author->id]['email'] = CHtml::encode($email); 
                $r[$participantView->id]['authors'][$author->id]['valid'] = $validator->validateValue($email);                
            }
        }     
        $this->recipients = $r;
    }
    
    public function getLanguageName($lang){
       return StringUtils::getLanguageName($lang);
    }
    
    
    /*
     *  Сохраняет информацию в объект $mailTask
     */
    public function transferDataTo($mailTask) {
        $r = $this->recipients;
        $participants = array();
        foreach ($r as $participant_id => $participant) {
            if (isset($participant['selected']) && $participant['selected'] && isset($participant['authors'])) {
                $participants[$participant_id] = array();
                $participants[$participant_id]['locale'] = $participant['locale'];
                $authors = $participant['authors'];
                $participants[$participant_id]['authors'] = array();
                foreach($authors as $id => $author){
                    if ($author['selected']) {
                        $participants[$participant_id]['authors'][] = CHtml::decode($author['email']);
                    }
                }
            }        
        };
        $mailTask->participants = $mailTask->packParticipants($participants);
    }
    
}

