<?php
/**
 *  @var $this   ConfController
 *  @var $conf   Conf
 *  @var $topic    ConfTopics
 *  @var $topics     array of ConfTopic
 *  @var $participant    Participant
 *  @var $authors    array of Author
 *  @var $settings AppFormSettings
 *  @var $viewUnpublished
 *  @var $preferredLanguage language used for Email
 *  @var $mailTextPreview
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs = array(
    StringUtils::cutOnWord($conf->title()) => array('conf/view', 'urn' => $conf->urn()));
if(Yii::app()->authManager->isOwner('Participant', $participant->id) && !Yii::app()->authManager->isConfAdmin($conf->id) && !Yii::app()->authManager->isAdmin() ){
    $count = ParticipantView::model()->countByAttributes(array('user_id' => Yii::app()->user->id, 'conf_id' => $conf->id));
    if($count > 1){
        $this->breadcrumbs[Yii::t('confs','My applications')] = array('participant/myApplication','urn'=>$conf->urn());
    }; 
} else {
    $this->breadcrumbs[Yii::t('participants','Participants')] = array('participant/list','urn' => $conf->urn());
    if(($conf->topicCount > 0) && ($topic != NULL)){
        $this->breadcrumbs[StringUtils::cutOnWord($topic->title())] = array('participant/topicList', 'urn' => $conf->urn(), 'topic_urn' => $topic->urn());
    };
};
$title = $participant->title();
if (empty($title)) {$title = Yii::t('participants', 'Untitled');};
array_push($this->breadcrumbs, StringUtils::cutOnWord($title));
?>
<?php 
    $jsParams2 = array();
    $jsParams2['PreferredLanguage'] = $preferredLanguage; 
    $jsParams2['StatusNew'] = Yii::t('participants', 'new', array(), NULL, $preferredLanguage); 
    $jsParams2['StatusApproved'] = Yii::t('participants', 'approved', array(), NULL, $preferredLanguage); 
    $jsParams2['StatusDiscarded'] = Yii::t('participants', 'discarded', array(), NULL, $preferredLanguage); 
    Yii::app()->clientScript->registerScript('js.participant.view.params2', 'var jsParams2=' . CJSON::encode($jsParams2) . ';', CClientScript::POS_HEAD);  
    Yii::app()->clientScript->registerCoreScript('jquery'); 
    Yii::app()->clientScript->registerScriptFile('/js/mediaplayer-5.10/jwplayer.js');
    Yii::app()->clientScript->registerScriptFile('/js/participant/author-info.js');
    Yii::app()->clientScript->registerScriptFile('/js/chosen-1.8.2/chosen.jquery.js', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerCssFile('/js/chosen-1.8.2/chosen.css?v=1');
    Yii::app()->clientScript->registerScriptFile('/js/participant/mailTextPreview.js?v=2', CClientScript::POS_HEAD); 
?>
<script type="text/javascript">
  $(function() {       
     $(".chosen-select").chosen({disable_search_threshold: 100});   
  });
</script>
<!-- подключаем комментирование -->
<!-- commenting -->
<?php 
if ($conf->is_commenting_enabled) { 
    $jsParams = array();
    $jsParams['CsrfTokenName'] = Yii::app()->request->csrfTokenName;       
    $jsParams['CsrfToken'] = Yii::app()->request->csrfToken;     
    Yii::app()->clientScript->registerScript('js.participant.view.params', 'var jsParams=' . CJSON::encode($jsParams) . ';', CClientScript::POS_HEAD);  
    Yii::app()->clientScript->registerCssFile('/css/comments.css'); 
    Yii::app()->clientScript->registerScriptFile('/js/common/jquery-comments.js?v=2'); 
?>
<script type="text/javascript">
    $(document).ready(function(){
         var comments=new Array();
         var sub_item_id;
         var id;
         var text;
         var editable;
         var author;
         var commentDate;
         <?php
         $user=Yii::app()->user;
         $comments=CommentsUtils::getAssocComments($user,$participant->id);
         foreach($comments as $comment){
         ?>
         id=<?php echo $comment['id']; ?>;
         sub_item_id="<?php echo $comment['sub_item_id']?>";
         text="<?php echo CommentsUtils::textToJavaScriptString($comment['text']); ?>";
         author="<?php echo htmlspecialchars($comment['username']);?>";
         editable="<?php echo ($comment['editable']?'true':'false');?>";
         commentDate="<?php echo CommentsUtils::formatCommentDate($comment['date']); ?>"
         if(comments[sub_item_id]){
         }else{
             comments[sub_item_id]=new Array();
         }
         comments[sub_item_id][id]=new Array();
         comments[sub_item_id][id]['id']=id;
         comments[sub_item_id][id]['text']=text;
         comments[sub_item_id][id]['editable']=editable;
         comments[sub_item_id][id]['author']=author;
         comments[sub_item_id][id]['date']=commentDate;
         <?php };?>
         var item_id=<?php echo $participant->id; ?>;
         var url='comments';

         var commentedItems=new Array();
         <?php
           $uncommentedItems = CommentsUtils::getUncommentedSubItems($participant->id);
           foreach($uncommentedItems as $sub_item_id){
         ?>
            commentedItems['<?php echo $sub_item_id; ?>'] = false;
         <?php }?>
         <?php $admin = CommentsUtils::hasEnableDisableCommentsPriviledge($participant->id,$user); ?>
         $("#commentedDivId").commenter({'url':url, 'item_id':item_id,
                'comments':comments,'editable':<?php echo ($user->isGuest?'false':'true');?>,
            'locale':'<?php echo Yii::app()->language; ?>','commented_items':commentedItems, 'admin':<?php echo ($admin?'true':'false');?>});
 });
</script>
<?php }?>
<!--конец подключаем комментирование-->
<!-- end of commenting -->    
<?php 
    // поля в заявке на участие
    // fields in the application form
      $pAttributesEnabled = $settings->getPAttributes(true);      
    // поля автора  
    // author fields  
      $aAttributesEnabled = $settings->getAAttributes(true);
    // application type (with paper or without)  
      $wi_paper_mode = $participant->isReport();
?>
<h2><?php 
   $title = $participant->title();
   if (empty($title)) {$title = Yii::t('participants', 'Untitled');};
   echo $title;
   ?></h2>
<div class="form participant-view" >    
    <?php if(Yii::app()->user->hasFlash('saved')) {?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('saved');?>
    </div>
    <?php }?>
    <?php if(Yii::app()->user->hasFlash('created')) {?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('created');?>   
    </div>
    <?php }?>
    <?php if(Yii::app()->user->hasFlash('userCreated')) {?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('userCreated');?>     
    </div>
    <?php }?> 
    <?php //    администратор, administrator
    if (Yii::app()->user->checkAccess('enableParticipant', array('conf_id' => $conf->id))) { ?>
        <?php if (Yii::app()->user->hasFlash('success')) {?>
        <div class="success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
        <?php };?>
        <?php if (Yii::app()->user->hasFlash('status_notification')) {?>
        <div class="success"><?php echo Yii::app()->user->getFlash('status_notification'); ?></div>
        <?php };?>
    <div class="row admin-row" >        
        <?php $form = $this->beginWidget('ActiveForm', array('action' => $this->createUrl('participant/enable', array('urn' => $conf->urn(), 'participant_urn' => $participant->urn())), 'htmlOptions' => array('enctype' => 'multipart/form-data'))); ?>        
        <div class="row">
        <div class="label">
        <?php echo $form->label($participant, 'status');?>
        </div>
        <div class="value">
        <?php echo $form->radioButtonList($participant, 'status', array('2' => Yii::t('participants', 'new'), '1' => Yii::t('participants','approved'), '0' => Yii::t('participants','discarded')), array('separator' => '&nbsp;&nbsp;', 'labelOptions' => array('class' => 'radioLabel')));?>
        </div>
        </div>
        <div class="row">
        <div class="label">
            <?php echo $form->label($participant,'status_reason');?>
            <span class="hint"><?php echo Yii::t('participants', 'Is sent to authors with the notification at change of the status');?></span>
            <?php echo CHtml::link(Yii::t('participants', 'show/hide E-mail text'), '#', array('id' => 'show-mail-preview-id', style => 'display:none', 'onclick' => 'showHideDiv("mail-preview-div-id",this);return false;')); ?>
        </div>
        <div class="value">
            <?php echo $form->textAreas($participant,'status_reason',array('cols' => 97, 'rows' => 5, 'class' => 'editor value'), 'vertical', array($preferredLanguage => $preferredLanguage) );?>
            <div id='mail-preview-div-id' style='display:none; border:solid 1px #a9a9a9;padding:5px;margin-right:12px'>
                <?php echo $mailTextPreview; ?>
            </div>
        </div>
        </div>
        <?php if($conf->topicCount > 0){?>
        <div class="row">
        <div class="label">
        <?php echo $form->label($participant,'topic');?>
        </div>
        <div class="value">
        <?php
        $data = array();
        foreach($topics as $topic) {
            $data[$topic->id] = $topic->title();
        };
        echo $form->dropDownList($participant, 'topic_id', $data, array('class' => 'value chosen-select')); ?>
        </div>
        </div>
        <?php };?>
        <div class="actions right">
            <?php echo CHtml::submitButton(Yii::t('actions','Save')); ?><br/><br />
            <?php echo CHtml::link(Yii::t('actions','mail to authors'),$this->createUrl('admin/mailing',array('urn'=>$conf->urn(),'participant_id'=>$participant->id)));?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <?php } else if (Yii::app()->authManager->isOwner("Participant", $participant->id)) {?>
        <label><?php echo Yii::t('participants','Status');?></label>
        <?php switch($participant->status){
                case 0: echo Yii::t('participant-status','Discarded'); 
                    $reason = $participant->status_reason();
                    if(!empty($reason)){
                        echo '<label>' . Yii::t('participants', 'Reason for discarding') . '</label>';
                        echo  $participant->status_reason();
                    };
                    break;
                case 1: echo Yii::t('participant-status', 'Approved'); break;     
                case 2: echo Yii::t('participant-status', 'Under consideration'); break;                 
              };
        ?>
   <?php }?>
   <label><?php echo Yii::t('participants','Participation Type');?></label>
   <?php echo $participant->participationType();?>   
   <label><?php echo Yii::t('participants','Authors');?></label>
    <?php foreach ($authors as $author) { 
        $hasInfo = FALSE;
        $author_info = '';
        foreach($aAttributesEnabled as $i => $attribute) { 
            if (in_array($attribute, array('lastname', 'firstname', 'middlename'))) {continue;};
            if ($viewUnpublished || $settings->isAttributePublished($attribute, $wi_paper_mode)) {
                $attribute_title = $settings->label($attribute);
                $value = NULL;
                $attribute_type = $settings->{$attribute . '_type'}; 
                if ($settings->isAdditionalAttribute($attribute)) {
                    if (($attribute_type == FieldType::STRING) || ($attribute_type == FieldType::TEXT)) {
                        $value = $author->value("{$attribute}_value");
                        $author_info .= $attribute_title . ': ' . StringUtils::prepareHtml($value) . '<br />';
                        $hasInfo = $hasInfo || !empty($value);
                    }
                    if ($attribute_type == FieldType::CHECKBOX) {
                        $value = $author->value("{$attribute}_value");
                        $value = ($value?Yii::t('site','Yes'):Yii::t('site','No'));
                        $author_info .= $attribute_title . ': ' . $value . '<br />';
                        $hasInfo = $hasInfo || !empty($value);
                    }
                    if ($attribute_type == FieldType::SELECT) {
                        $item_id = $author->{$attribute .'_value'};
                        $data = $settings->getSelectFieldList($attribute);
                        if(!empty($item_id)){
                            $value = $data[$item_id];
                        };
                        $author_info .= $attribute_title . ': ' . StringUtils::prepareHtml($value) . '<br />';
                        $hasInfo = $hasInfo || !empty($value);
                    }
                    if ($attribute_type == FieldType::FILE) {
                        $file = $author->getFile("${attribute}_files", 0);
                        $author_info .= "<div>";
                        $author_info .= "$attribute_title:";       
                        if( ($file != NULL) && !$file->isEmpty()) {
                            for($j = 0; $j < FilesBehavior::MAX_ATTR_FILES_COUNT; $j++) {
                                $file = $author->getFile("${attribute}_files", $j);
                                if( ($file != NULL) && !$file->isEmpty()) { 
                                    $author_info .= "<div class='ordered'>";
                                    $author_info .= ActiveForm::ViewIndexedFile($author, "${attribute}_files", $j, $file->getNotEmptyLanguages());
                                    $author_info .= "</div>";    
                                }; 
                            }; 
                            $hasInfo = TRUE;
                        };
                        $author_info .= "</div>";
                    }
                } else {
                    if ($attribute == 'image') {
                        $value = $author->getFile('image');
                        if ($value != NULL) { 
                            $author_info .= CHtml::image($value->thumbnail_url(), Yii::t('users','Image'), array('class' => 'img')) . '<br />';
                            $hasInfo = TRUE;
                        };
                    } else {
                        if (in_array($attribute, array('fax', 'email', 'phone'))) {
                            $value = $author->{$attribute};
                        } else {
                            if ($attribute == 'org') { $attribute = 'institution'; };
                            if ($attribute == 'org_address') { $attribute = 'institutionAddress'; };
                            if ($attribute == 'academic_degree') { $attribute = 'academicDegree'; };
                            if ($attribute == 'academic_title') { $attribute = 'academicTitle'; };
                            if ($attribute == 'address') { $attribute = 'homeAddress'; };
                            $value = $author->{$attribute}();
                        };
                        if($attribute == 'email') {
                            $author_info .= 'E-mail: ' . StringUtils::hideEmail($value) . '<br />';
                        } else {
                            $author_info .= $attribute_title . ': ' . StringUtils::prepareHtml($value) . '<br />';
                        }
                        $hasInfo = $hasInfo || !empty($value);
                    }
                };    

            };
        }; // цикл по атрибутам автора 
        if ($viewUnpublished) {
            $langs = $conf->getLanguages();
            if (count($langs) > 1) {
                $value = StringUtils::getLanguageName($author->locale); 
                $author_info .= Yii::t('users', 'Preferred Language') . ': ' . $value . '<br />';
                $hasInfo = TRUE;
            }
        }
        ?>
     <!-- вывод информации об авторе -->
     <?php echo CHtml::encode($author->fullName());?>
     <?php if($hasInfo){ echo Chtml::link(Yii::t('participants', 'more'), '#', array('onclick' => 'showAuthorInfo(' . $author->id . ',this);return false;')) ?>
     <div id="author_info_<?php echo $author->id;?>" class="author-info" >
         <?php echo $author_info; ?>
     </div>   
     <?php }; ?>
     <br /> 
     <!-- конец вывод информации об авторе -->
    <?php }; // цикл по авторам ?>
    <!-- атрибуты заявки --> 
    <?php foreach($pAttributesEnabled as $i => $attribute) { 
            if ($attribute == 'authors') {continue;};
            if ($viewUnpublished || $settings->isAttributePublished($attribute, $wi_paper_mode)) {
                if (($attribute == 'report_title') || ($attribute == 'report_topic')) { continue; };
                $attribute_title = $settings->label($attribute);
                $value = NULL;
                $attribute_type = $settings->{$attribute . '_type'}; 
                if ($settings->isAdditionalAttribute($attribute)) {
                    if (($attribute_type == FieldType::STRING) || ($attribute_type == FieldType::TEXT) ) {
                        $value = $participant->value("{$attribute}_value");
                        if (!empty($value)) {
                            echo '<label>' . $attribute_title . '</label>';
                            echo StringUtils::prepareHtml($value); 
                        }
                    }
                    if ($attribute_type == FieldType::CHECKBOX) {
                        $value = $participant->value("{$attribute}_value");
                        $value = $value?Yii::t('site','Yes'):Yii::t('site','No');
                        echo '<label>' . $attribute_title . '</label>';
                        echo StringUtils::prepareHtml($value); 
                    }
                    if ($attribute_type == FieldType::SELECT) {
                        $item_id = $participant->{$attribute .'_value'};
                        $data = $settings->getSelectFieldList($attribute);
                        if (!empty($item_id)) {
                            $value = $data[$item_id];
                        };
                        if (!empty($value)) {
                            echo '<label>' . $attribute_title . '</label>';
                            echo StringUtils::prepareHtml($value); 
                        };
                    };
                    if ($attribute_type == FieldType::FILE) {
                        $file = $participant->getFile("${attribute}_files", 0);
                        echo '<div>';
                        echo '<label>' . $attribute_title . '</label>'; 
                        if( ($file != NULL) && !$file->isEmpty()) {
                        for ($j = 0; $j < FilesBehavior::MAX_ATTR_FILES_COUNT; $j++) {
                            $file = $participant->getFile("${attribute}_files", $j);
                            if( ($file != NULL) && !$file->isEmpty()) {
                                echo '<div class="ordered">';
                                echo ActiveForm::ViewIndexedFile($participant, "${attribute}_files", $j, $file->getNotEmptyLanguages()); 
                                echo '</div>';    
                            }; 
                        };
                        }
                        echo '</div>';
                    };                    
                } else if ($attribute == 'report_file') {
                    $file = $participant->getFile('content_files',0);
                    if( ($file != NULL) && !$file->isEmpty()) {?>
                        <div>
                            <label><?php echo Yii::t('participants','Files');?></label>       
                            <?php 
                            for($j = 0; $j < FilesBehavior::MAX_ATTR_FILES_COUNT; $j++){
                                $file = $participant->getFile('content_files', $j);
                                if( ($file != NULL) && !$file->isEmpty()) { ?>
                                <div class="ordered">
                                <?php echo ActiveForm::ViewIndexedFile($participant, 'content_files', $j, $file->getNotEmptyLanguages()); ?>
                                </div>    
                            <?php } 
                             }; ?>   
                        </div>
                    <?php }?>
                <?php 
                } else {               
                    if ($attribute == 'classification') {
                        $value = $participant->classification_code;
                    } else if ($attribute == 'report_text') {
                        $value = $participant->content();
                    } else if ($attribute == 'more_info') {
                        $value = $participant->information();
                    } else if ($attribute == 'accommodation') {
                        $value = $participant->is_accommodation_required; 
                        $value = $value?Yii::t('site','Yes'):Yii::t('site','No');
                    } else {
                        $value = $participant->{$attribute}(); 
                    } ;    
                    if (!empty($value)) { ?>
                        <label><?php echo $attribute_title; ?></label>
                        <?php echo $value;?>
                    <?php } ?>
          <?php };?>  
            <?php }; ?>
    <?php }; ?>
    <!-- конец атрибуты заявки --> 
    <br /><hr />
    <p class="note">
    <?php echo Yii::t('participants','Creation Date');?>: <?php echo Yii::app()->locale->dateFormatter->formatDateTime($participant->registration_date,'long','medium');?><br />
    <?php echo Yii::t('participants','Last Update Date');?>: <?php echo Yii::app()->locale->dateFormatter->formatDateTime($participant->last_update_date,'long','medium');?>
    </p>
    
    <?php if($conf->is_commenting_enabled) { ?>
    <div id = "commentedDivId">
    &nbsp;
    </div>
    <?php } ?>
</div>    
