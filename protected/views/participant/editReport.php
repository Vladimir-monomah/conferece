<?php
/**
 *  @var $this   ParticipantController
 *  @var $conf   Conf
 *  $var $topic  ConfTopic
 *  @var $topics   array of ConfTopics
 *  @var $participant    Participant
 *  @var $authors    array of Author
 *  @var $settings   AppFormSettings
 *  @var $submitAction   save or create
 *  @var $create_author_account    boolean
 *  @var $captcha      Captcha
 */
?>
<?php include 'header.inc';?>
<?php
if ($submitAction == 'save') {
    $participantsLinkTitle = Yii::t('participants','Reports');
    if(Yii::app()->user->checkAccess("viewAllParticipants", array('conf_id' => $conf->id))) {
       $participantsLinkTitle = Yii::t('participants','Participants');
    }
    if(Yii::app()->authManager->isOwner('Participant', $participant->id) 
                && !Yii::app()->authManager->isConfAdmin($conf->id) && !Yii::app()->authManager->isAdmin()){
        $this->breadcrumbs = array(StringUtils::cutOnWord($conf->title()) => array('conf/view','urn'=>$conf->urn()));
        $count = ParticipantView::model()->countByAttributes(array('user_id' => Yii::app()->user->id, 'conf_id' => $conf->id));
        if($count > 1){
            $this->breadcrumbs[Yii::t('confs','My applications')] = array('participant/myApplication','urn'=>$conf->urn());
        }; 
        $title = $participant->title();
        if(empty($title)){$title = Yii::t('participants','Untitled');};
        $this->breadcrumbs[StringUtils::cutOnWord($title,25)] = array('participant/view', 'urn' => $conf->urn(),'participant_urn' => $participant->urn());
        array_push($this->breadcrumbs, Yii::t('site','Editing'));
    } else {
        $this->breadcrumbs = array(
            StringUtils::cutOnWord($conf->title()) => array('conf/view','urn'=>$conf->urn()),
            $participantsLinkTitle => array('participant/list', 'urn' => $conf->urn()),
            StringUtils::cutOnWord($topic->title()) => array('participant/topicList', 'urn' => $conf->urn(), 'topic_urn' => $topic->urn()),
            StringUtils::cutOnWord($participant->title(), 25) => array('participant/view', 'urn' => $conf->urn(), 'participant_urn' => $participant->urn()),
            Yii::t('site','Editing')
        );
    };
};
if($submitAction == 'create'){
    $this->breadcrumbs = array(
        StringUtils::cutOnWord($conf->title()) => array('conf/view', 'urn' => $conf->urn()),
        Yii::t('confs','Registration')
    );
};
?> 
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['Language'] = Yii::app()->language;
    $jsParams['AuthorsCount'] = count($authors);
    $jsParams['DefaultLanguage'] = $conf->currentLanguage();
    $jsParams['Languages'] = array_keys($conf->getLanguages());
    $jsParams['NewAuthorMsg'] = Yii::t('participants','New Author',array(), NULL, $conf->currentLanguage());
    $jsParams['RegisterAuthor'] = Yii::app()->user->isGuest;
    $jsParams['FindUserURL'] = $this->createUrl('user/find');
    $jsParams['AuthorizeUserURL'] = $this->createUrl('user/authorize');
    $jsParams['SendPasswordURL'] = $this->createUrl('user/sendpassword');
    $jsParams['DeleteFileLinkMsg'] = Yii::t('actions','delete');
    $jsParams['DeleteFileMsg'] = Yii::t('admin','file is marked for deletion, you have to save changes');
    $jsParams['CheckPasswordMsg'] = Yii::t('participants','There is a check ...');          
    $jsParams['CorrectMsg'] = Yii::t('participants','Correct!');          
    $jsParams['NotCorrectMsg'] = Yii::t('participants','Not correct.');  
    $jsParams['CsrfTokenName'] = Yii::app()->request->csrfTokenName;       
    $jsParams['CsrfToken'] = Yii::app()->request->csrfToken;   
    $jsParams['FilemanagerTitle'] = Yii::t('site','File manager');
    $jsParams['FilemanagerEnabled'] = true;
    $jsParams['FilemanagerAccessKey'] = RFilemanagerUtils::genAccessKey($conf, $participant);        
    Yii::app()->clientScript->registerScript('js.participant.report.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/common/deleteFile.js?v=3', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/participant/authors.js?v=16', CClientScript::POS_HEAD);   
    Yii::app()->clientScript->registerScriptFile('/js/tinymce_4.1.9/tinymce.min.js');
    Yii::app()->clientScript->registerScriptFile('/js/common/attachTinymce.js?v=5', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/chosen-1.8.2/chosen.jquery.js', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerCssFile('/js/chosen-1.8.2/chosen.css?v=1');
?>
<script type="text/javascript">
  $(function() {       
     $(".chosen-select").chosen({disable_search_threshold: 100});  
  });
</script>
<?php 
    $title =  Yii::t('confs','Registration');
    if ($submitAction == 'save') {
       $title = $participant->title() . ' - ' .  Yii::t('site','Editing'); 
    };
?> 
<?php 
    // поля в заявке на участие
    // fields in the application form
      $pAttributesEnabled = $settings->getPAttributes(true);      
    // поля автора  
    // author fields  
      $aAttributesEnabled = $settings->getAAttributes(true);
      $participant->setAppFormSettings($settings);
      foreach($authors as $author){
          $author->setAppFormSettings($settings);
      }
      
      $editLanguage = $participant->editLanguage;
?>
<h2><?php echo $title; ?></h2>
<div class="form participant-edit" >  
    <?php $form = $this->beginWidget('ActiveForm', array('action' => $this->createUrl('participant/' . $submitAction, array('urn' => $conf->urn(), 'participant_urn' => $participant->urn())), 'htmlOptions' => array('enctype' => 'multipart/form-data', 'autocomplete' => 'off'))); ?>

    <!-- сообщения-статусы -->
    <?php if(Yii::app()->user->hasFlash('success')) {?>
    <div class="successSummary">
        <?php echo Yii::app()->user->getFlash('success');?>
    </div>
    <?php }?>
    <?php if (($submitAction == 'create') && (Yii::app()->authManager ->isConfAdmin($conf->id) || Yii::app()->authManager ->isAdmin())){ ?>
        <div style="background-color: #F5F5F5;padding:10px;">      
            <?php 
            echo Yii::t('participants', 'As You are the administrator of the conference You can submit an application on behalf of another author.');
            echo '<br />' . Yii::t('participants', 'Herewith you can create an account for the author and give him the right to edit the application:');
            ?>
            <ul>
            <li><?php echo Yii::t('participants', 'If there are several authors, an account will be created for the first specified author.')?></li>
            <li><?php echo Yii::t('participants', 'If the author is already registered on the site, then the application for participation will be bound to his account.')?></li>
            <li><?php echo Yii::t('participants', 'If you do not put a mark, then the application for participation will be bound to your account and in the future only you or another administrator will be able to edit it.')?></li>
            </ul>
            <?php
            echo CHtml::checkBox('create_author_account', $create_author_account);
            echo CHtml::label(Yii::t('participants', 'Create an account for the author and give him the right to edit the application'), 'create_author_account');
            ?>
        </div>
    <?php }; ?>
    <?php
        $summary = $form->errorSummary2($participant, $authors, $captcha, $settings);
        echo $summary;
    ?>    
    <p class="note">
        <?php echo Yii::t('validators', 'Fields with an asterisk {asterisk} are required.', array('{asterisk}' => '<span class="required">*</span>')); ?>
        <?php if(count($conf->getLanguages()) > 1) {?>
        <br />
        <?php echo Yii::t('validators', 'At least one field in a field group with an asterisk {asterisk} is required.', array('{asterisk}' => '<span class="requiredOne">*</span>'));?>
        <?php }; ?>
    </p>  
    <!-- конец сообщения-статусы -->
    <!-- temp_id -->
    <?php echo $form->hiddenField($participant, 'temp_id'); ?> 
    <!-- конец temp_id -->
    <!-- edit_language -->
    <?php echo $form->hiddenField($participant, 'editLanguage'); ?> 
    <!-- конец edit_language -->
    <!-- форма участия -->
    <?php
        $data = $conf->participation_types_names(ParticipationType::TYPE_PAPER);
        if (count($data) == 0) {
            echo CHtml::hiddenField('Participant[participation_type]', ParticipationType::REPORT);
        } else {
    ?>
    <div class="row" >
        <?php echo $form->label($participant, 'participation_type'); ?><br />
        <?php
            if (count(array_keys($data)) > 1) {
                echo $form->dropDownList($participant, 'participation_type', $data, array('class' => 'value'));
            } else {
                $key = key($data);
                echo CHtml::hiddenField('Participant[participation_type]', $key);
                echo $data[$key];
            };
        ?>
        </div>
    <?php }; ?>
    <!-- конец форма участия -->
    <!-- поля в заявке на участие -->
    <?php foreach($pAttributesEnabled as $i => $attribute) { ?>
        <?php if ($attribute != 'authors') { ?>        
            <?php 
                $htmlOptions = array();
                $visibleLanguages = NULL;
                if($settings->{$attribute . '_wi_paper_mode'} == AppFormSettings::MODE_DISABLED){
                    continue; // пропускаем поле
                };
                if($settings->{$attribute . '_wi_paper_mode'} == AppFormSettings::MODE_MANDATORY_ALL){
                    $htmlOptions['required'] = true;
                };
                if($settings->{$attribute . '_wi_paper_mode'} == AppFormSettings::MODE_MANDATORY_ONE){
                    $htmlOptions['requiredOne'] = true;
                };
                if($settings->{$attribute . '_wi_paper_mode'} == AppFormSettings::MODE_ENABLED_CURRENT){
                    $visibleLanguages = $editLanguage;
                };
                if($settings->{$attribute . '_wi_paper_mode'} == AppFormSettings::MODE_MANDATORY_CURRENT){
                    $htmlOptions['required'] = true;
                    $visibleLanguages = $editLanguage;
                };
                $attribute_type = $settings->{$attribute . '_type'}; 
                $attribute_hint = '';
                if ($settings->isAdditionalAttribute($attribute)) {
                    $attribute_hint = $settings->field_hint($attribute . '_hint');
                } else {    
                    $attribute_hint = $settings->{$attribute . '_hint'}();
                }
            ?>    
            <!-- поле-строка -->
            <?php if ($attribute_type == FieldType::STRING) { 
                if ($attribute == 'classification') {
            ?>        
                <div class="row" >
                <?php echo $form->label($participant, 'classification_code', $htmlOptions);?><br />
                <?php if(!empty($attribute_hint)){ ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint);?></span><?php };?>
                <?php echo $form->textField($participant, 'classification_code', array('size' => 100, 'maxlength' => 200, 'class' => 'value'), 'vertical');?>
                </div>
            <?php } else {          
                if ($settings->isAdditionalAttribute($attribute)) {
                    $attribute .= '_value';
                };
            ?>
            <div class="row" >
                <?php echo $form->label($participant, $attribute, $htmlOptions);?><br />
                <?php if(!empty($attribute_hint)) { ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint);?></span><?php };?>
                <?php echo $form->textFields($participant, $attribute ,array('size' => 100, 'maxlength' => 200, 'class' => 'value'), 'vertical', $conf->getLanguages(), $visibleLanguages);?>
            </div> 
            <?php } ?>
            <?php } ?>
            <!-- конец поле-строка -->
            <!-- поле-текст -->
            <?php if ($attribute_type == FieldType::TEXT) { 
                    $editorClass = 'editor';
                    if ($attribute == 'report_title') {
                        $attribute = 'title' ; 
                        $editorClass = ''; 
                        $attribute_hint = (empty($attribute_hint)?'':$attribute_hint . '<br />') . Yii::t('participants','<i>span, sup</i> and <i>sub</i> tags are allowed');
                    };
                    if ($attribute == 'report_text') {$attribute = 'content' ; };
                    if ($attribute == 'more_info') {$attribute = 'information' ; };
                    if ($settings->isAdditionalAttribute($attribute)) {
                        $attribute .= '_value';
                    };
            ?>
            <div class="row" >
                <?php echo $form->label($participant, $attribute, $htmlOptions);?><br />
                <?php if(!empty($attribute_hint)){ ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint);?></span><?php };?>
                <?php echo $form->textAreas($participant, $attribute, array('cols' => 97, 'rows' => 2, 'class' => $editorClass .' value', 'tableClass' => 'value', 'hintClass' => 'editor-hint'), 'vertical', $conf->getLanguages(), $visibleLanguages);?>
            </div>
            <?php } ?>
            <!-- конец поле-текст -->
            <!-- поле-флажок -->
            <?php if ($attribute_type == FieldType::CHECKBOX) { 
                if ($attribute == 'accommodation') { 
                    $attribute = 'is_' . $attribute . '_required'; 
                } else {
                    $attribute .= '_value'; 
                };
            ?>
            <div class="row" >
                <?php echo $form->checkBox($participant, $attribute);?>
                <?php echo $form->label($participant, $attribute, $htmlOptions);?>
                <?php if(!empty($attribute_hint)){ ?><br /><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint);?></span><?php };?>
            </div>
            <?php } ?>
            <!-- конец поле-флажок -->
            <!-- поле-список -->
            <?php if ($attribute_type == FieldType::SELECT) {
                if ($attribute == 'report_topic') {
                    $data = array();
                    foreach ($topics as $topic) {
                        $topicTitle = $topic->title();
                        if ($topic->id == 0) {
                            $topicTitle = Yii::t('participants', 'Unknown');
                        }
                        $data[$topic->id] = $topicTitle;
                    };
                    $attribute = 'topic';
                    if (count(array_keys($data)) == 1) {
                        $key = key($data);
                        echo CHtml::hiddenField('Participant[topic_id]', $key);
                    };
            ?> 
            <?php if (count(array_keys($data)) > 1) { ?>
            <div class="row" >
                    <?php echo $form->label($participant, 'topic', $htmlOptions); ?><br />
                    <?php if (!empty($attribute_hint)) { ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint); ?></span><?php }; ?>
                    <?php
                    $params = array(
                        'class' => 'Participant',
                        'id' => $participant->id,
                        'owner_attr' => 'user_id',
                        'participant_id' => $participant->id,
                        'user_id' => Yii::app()->user->id);
                    if ($submitAction == 'create' || Yii::app()->user->checkAccess("modifyParticipantTopic")) {
                    ?>
                    <?php echo $form->dropDownList($participant, 'topic_id', $data,array('class'=>'value chosen-select')); ?>
                    <?php
                    } else {
                        echo CHtml::hiddenField('Participant[topic_id]', $participant->topic_id);
                        echo $data[$participant->topic_id];
                    };
                    ?>
            </div>
            <?php } ?>
            <?php } else { // если не 'report_topic' 
                $data = $settings->getSelectFieldList($attribute);
                $attribute .= '_value'; 
            ?>
            <div class="row" >
            <?php echo $form->label($participant, $attribute, $htmlOptions);?><br />
            <?php if(!empty($attribute_hint)){ ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint);?></span><?php };?>
            <?php echo $form->dropDownList($participant, $attribute, $data, array('class' => 'value chosen-select')); ?>
            </div>
            <?php } ?>
            <?php } ?>
            <!-- конец поле-список -->
            <!-- поле-файл -->
            <?php if ($attribute_type == FieldType::FILE) { 
                if ($attribute == 'report_file') {
                    $attribute = 'content_files';
                } else {
                    $attribute .= '_files'; 
                };
                ?>
            <div class="row" >
            <?php echo $form->label($participant, $attribute, $htmlOptions);?><br />
            <?php if(!empty($attribute_hint)){ ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint);?></span><?php };?>
            <input type="hidden" name="MAX_FILE_SIZE" value="0" />    
            <span class="hint" ><?php echo Yii::t('validators','File formats allowed to upload');?>:&nbsp;<?php echo FileUtils::listStr($conf->fileExts); ?></span>
            <span class="hint" ><?php echo Yii::t('validators','Max file size allowed to upload');?>:&nbsp;<?php echo FileUtils::fileSizeStr(Yii::app()->params['userFileSize']);?></span> 
            <?php         
                $max_count = FilesBehavior::MAX_ATTR_FILES_COUNT;
                for ($j = 0; $j < $max_count; $j++) {
                $hidden = 'hidden';
                $file = $participant->getFile($attribute, $j);
                if( (($file != NULL) && !$file->isEmpty()) || ($j == 0)){ 
                    $hidden = '';      
                };
            ?>  
            <div name="<?php echo $attribute;?>_div" class="ordered <?php echo $hidden?>" >
            <?php echo $form->fileFields($participant, $attribute, $j, $conf->getLanguages(), $visibleLanguages);?>
            </div>
            <?php }?>
            <div class="actions right">
            <a onclick="ShowNextFile('<?php echo $attribute;?>');" href="javascript:void(0)"><?php echo Yii::t('actions','add');?></a>
            </div>    
            </div>    
            <?php } ?>
            <!-- конец поле-файл -->
        <?php } else { ?>
        <?php $captchaClass = "row"; ?>
        <!-- поля автора -->
        <div class="row authors-row" >
            <?php echo CHtml::activeLabel($participant,'authors');?><br /><br />
            <!-- добавляем автор-шаблон для создания новых авторов -->
            <?php                
                $author = new Author();
                $author->id = 'new';
                $author->locale = $conf->currentLanguage();
                $author->appFormSettings = $settings;
                $authors['Template'] = $author;
            ?>
            <!-- конец автор-шаблон -->
            <!-- переключатели авторов -->
            <?php foreach ($authors as $i => $author) { ?>
            <div id="authorLinkDiv<?php echo $i ?>" <?php
            if ($i === 'Template') {
                echo 'class="hidden-switch"';
            } else {
                echo 'class="shown-switch"';
            };
            ?> > 
            <a id="authorName<?php echo $i ?>" href="javascript:void(0)" class="author-link <?php if($author->hasErrors()) {echo ' error';};?>" onclick="selectAuthor(<?php echo $i ?>);" ><?php echo $author->authorName(); ?></a>
            &nbsp;
            <a id="deleteAuthor<?php echo $i ?>" href="javascript:void(0)" onclick="deleteAuthor(<?php echo $i ?>);" ><?php $baseUrl=''; if(Yii::app()->theme) {$baseUrl = Yii::app()->theme->baseUrl;}; echo CHtml::image($baseUrl . '/images/delete.gif', Yii::t('actions', 'delete')); ?></a>
            &nbsp;
            </div> 
            <?php }; ?>
            &nbsp;
            <a href="javascript:void(0)"  onclick="createAuthor();"><?php echo Yii::t('actions', 'add'); ?></a>
            <!-- конец переключатели авторов -->
            <?php foreach ($authors as $i => $author) { ?>
            <div id="authorDiv<?php echo $i; ?>" class="<?php if($i!==0){ echo 'author-hidden';}else {echo 'author-shown';}; ?>" >
                <!-- идентификатор автора -->
                <?php echo $form->hiddenField($author, "[$i]id"); ?>
                <!-- конец идентификатор автора -->              
                <?php foreach($aAttributesEnabled as $k => $attribute) { 
                    $htmlOptions = array();
                    $visibleLanguages = NULL;
                    if($settings->{$attribute . '_wi_paper_mode'} == AppFormSettings::MODE_DISABLED){
                        continue; // пропускаем поле
                    };
                    if($settings->{$attribute . '_wi_paper_mode'} == AppFormSettings::MODE_MANDATORY_ALL){
                        $htmlOptions['required'] = true;
                    };
                    if($settings->{$attribute . '_wi_paper_mode'} == AppFormSettings::MODE_MANDATORY_ONE){
                        $htmlOptions['requiredOne'] = true;
                    };
                    if($settings->{$attribute . '_wi_paper_mode'} == AppFormSettings::MODE_ENABLED_CURRENT){
                        $visibleLanguages = $editLanguage;
                    };
                    if($settings->{$attribute . '_wi_paper_mode'} == AppFormSettings::MODE_MANDATORY_CURRENT){
                        $htmlOptions['required'] = true;
                        $visibleLanguages = $editLanguage;
                    };
                    $attribute_type = $settings->{$attribute . '_type'}; 
                    $attribute_hint = '';
                    if ($settings->isAdditionalAttribute($attribute)) {
                        $attribute_hint = $settings->field_hint($attribute . '_hint');                       
                    } else {    
                        $attribute_hint = $settings->{$attribute . '_hint'}();
                    };
                ?>
                <!-- e-mail и пароль -->
                <?php if ( ($attribute_type == FieldType::STRING) && ($attribute == 'email')) { ?>
                    <div class="row">
                        <div class="label" id="author_email_label_<?php echo $i;?>_id" name="author_email_label_<?php echo $i;?>">
                            <?php echo $form->label($author, 'email', $htmlOptions); ?>
                            <?php if (!empty($attribute_hint)) { ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint); ?></span><?php }; ?>
                        </div>
                        <div class="value">                           
                            <?php echo $form->textField($author, "[$i]email", array('maxlength' => 200, 'class' => 'value','id' => "author_{$i}_email")); ?>                    
                        </div>
                    </div>
                <?php
                   $class = "hidden-row";                  
                   //Для вернувшейся формы показываем для первого автора, если пользователь с таким email существует
                   $email = $author->email;
                   if( ($i === 0) && (!empty($email)) && (Yii::app()->user->isGuest)){
                      $user = User::model()->findByEmail($email);
                      if ($user) {  
                         $class = "row";
                         $captchaClass = "hidden-row";
                      };
                   };   
                ?>
                <div id="div_<?php echo $i;?>_existed_author_password_id" name="div_<?php echo $i;?>_new_author_password" class="<?php echo $class;?>">
                        <div class="label">
                            <?php echo $form->label($author, 'password', array('required'=>true)); ?>
                        </div>
                        <div class="value">
                            <span class="warning"><?php echo Yii::t('participants','You are already registered on the website. Fill in password, please.');?></span><br />
                            <?php echo $form->passwordField($author, "[$i]password", array('size' => 30,'maxlength' => 50,'class' => 'short-value')); ?>
                            &nbsp;<input type="button" value="<?php echo Yii::t('actions','Check');?>" id="<?php echo $i;?>_authorize_user_id" name="<?php echo $i;?>_authorize_user" onclick="authorizeUser(this);"></input> 
                            &nbsp;<span id="<?php echo $i;?>_authorize_result_id" name="<?php echo $i;?>_authorize_result" class="warning"></span>
                            <br />
                            <?php echo Yii::t('participants','Forgot your password?');?>&nbsp;<input type="button" value="<?php echo Yii::t('participants','Send new password');?>" id="<?php echo $i;?>_send_password_id" name="<?php echo $i;?>_send_password" onclick="sendPassword(this);"></input>
                            <br />
                            <span id="send_password_msg_<?php echo $i;?>_id" name="send_password_msg_<?php echo $i;?>" class="hint warning hidden"><?php echo Yii::t('participants','A new password has been sent to your E-mail.');?></span>
                        </div>
                </div>
                <?php } ?>
                <!-- конец e-mail и пароль -->  
                <!-- телефон и факс -->
                <?php if ( ($attribute_type == FieldType::STRING) && in_array($attribute, array('phone', 'fax'))) { ?>
                <div class="row">
                        <div class="label">
                            <?php echo $form->label($author, $attribute, $htmlOptions); ?>
                            <?php if (!empty($attribute_hint)) { ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint); ?></span><?php }; ?>
                        </div>
                        <div class="value">
                            <table class="value"><tr><td>
                                        <?php echo $form->textField($author, "[$i]${attribute}", array('maxlength' => 200, 'class' => 'value')); ?>
                            </td></tr></table>            
                        </div>
                 </div>
                <?php } ?>
                <!-- конец телефон и факс -->
                <!-- поле-строка -->
                <?php if ( ($attribute_type == FieldType::STRING) && !in_array($attribute, array('email', 'phone', 'fax')) ) { 
                    if ($settings->isAdditionalAttribute($attribute)) {
                        $attribute .= '_value';
                    };
                    if ($attribute == 'org') { 
                        $attribute = 'institution';                        
                    };
                    if ($attribute == 'org_address') { 
                        $attribute = 'institution_address';                        
                    };    
                    if ($attribute == 'address') { 
                        $attribute = 'home_address';
                    };
                ?>
                    <div class="row" >
                        <div class="label">
                            <?php echo $form->label($author, "[$i]${attribute}", $htmlOptions); ?>
                            <?php if (!empty($attribute_hint)) { ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint); ?></span><?php }; ?>
                        </div>
                        <div class="value" >
                            <?php echo $form->textFields($author, "[$i]${attribute}", array('maxlength' => 200, 'class' => 'value', 'tableClass' => 'value'), 'vertical', $conf->getLanguages(), $visibleLanguages); ?>
                        </div>
                    </div> 
                <?php } ?>      
               <!-- конец поле-строка -->
               <!-- поле-текст -->
               <?php if ($attribute_type == FieldType::TEXT) {
                   if ($settings->isAdditionalAttribute($attribute)) {
                       $attribute .= '_value';
                   }
                   if ($attribute == 'address') { 
                        $attribute = 'home_address';                        
                   };
               ?>
                    <div class="row">
                        <div class="label">
                            <?php echo $form->label($author, "[$i]${attribute}", $htmlOptions); ?>
                            <?php if (!empty($attribute_hint)) { ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint); ?></span><?php }; ?>
                        </div>
                        <div class="value">                  
                            <?php echo $form->textAreas($author, "[$i]${attribute}", array('cols' => 57, 'rows' => 3, 'class' => 'mceNoEditor value', 'tableClass' => 'value', 'hintClass' => 'hint'), 'vertical', $conf->getLanguages(), $visibleLanguages); ?>
                        </div>
                    </div>
               <!-- конец поле-текст -->
               <?php }; ?>
               <!-- поле-флажок -->
               <?php if ($attribute_type == FieldType::CHECKBOX) {
                   if ($settings->isAdditionalAttribute($attribute)) {
                       $attribute .= '_value';
                   }
               ?>
               <div class="row">
                    <div class="label">
                    <?php echo $form->label($author, "[$i]{$attribute}", $htmlOptions); ?>
                    <?php if (!empty($attribute_hint)) { ?><br /><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint); ?></span><?php }; ?>
                    </div>
                    <div class="value">
                    <?php echo $form->checkBox($author, "[$i]{$attribute}"); ?>
                    </div>
               </div>
               <?php } ?>
               <!-- конец поле-флажок-->
               <!-- поле-список -->
               <?php if ($attribute_type == FieldType::SELECT) {
                   $data = array();
                   if ($settings->isAdditionalAttribute($attribute)) {
                       $data = $settings->getSelectFieldList($attribute);
                       $attribute .= '_value';
                   }
               ?>
               <div class="row">
                    <div class="label">
                    <?php echo $form->label($author, "[$i]${attribute}", $htmlOptions); ?>
                    <?php if (!empty($attribute_hint)) { ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint); ?></span><?php }; ?>
                    </div>
                    <div class="value">
                    <?php echo $form->dropDownList($author, "[$i]{$attribute}", $data, array('class' => 'value')); ?>
                    </div>
               </div>
               <?php } ?>
               <!-- конец поле-список -->   
               <!-- поле-файл -->
                <?php if ($attribute_type == FieldType::FILE) {
                   if ($settings->isAdditionalAttribute($attribute)) {
                       $attribute .= '_files';
                   }
               ?>
               <?php if($attribute == 'image') { ?>
                <div class="row">
                    <div class="label">
                    <?php echo $form->label($author, "[$i]image", $htmlOptions); ?>
                    </div>
                    <div class="value">
                    <?php if (!empty($attribute_hint)) { ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint); ?></span><?php }; ?>    
                    <span class="hint" ><?php echo Yii::t('validators', 'File formats allowed to upload'); ?>: <?php echo FileUtils::listStr(Yii::app()->params['logoExts']); ?></span>
                    <span class="hint" ><?php echo Yii::t('validators', 'Max file size allowed to upload'); ?>: <?php echo FileUtils::fileSizeStr(Yii::app()->params['userFileSize']); ?></span>                              
                    <input type="hidden" name="MAX_FILE_SIZE" value="0" />
                    <?php echo $form->imgFields($author, "[$i]image"); ?>
                    </div>
                </div>
               <?php } else {?>
               <div class="row" >
                  <div class="label">
                  <?php echo $form->label($author, "[$i]${attribute}", $htmlOptions);?>
                  </div>    
                  <div class="value" style="padding-right:14px;">
                  <?php if(!empty($attribute_hint)){ ?><span class="hint"><?php echo StringUtils::prepareHtml($attribute_hint);?></span><?php };?>
                  <input type="hidden" name="MAX_FILE_SIZE" value="0" />    
                  <span class="hint" ><?php echo Yii::t('validators','File formats allowed to upload');?>:&nbsp;<?php echo FileUtils::listStr($conf->fileExts); ?></span>
                  <span class="hint" ><?php echo Yii::t('validators','Max file size allowed to upload');?>:&nbsp;<?php echo FileUtils::fileSizeStr(Yii::app()->params['userFileSize']);?></span> 
                  <?php         
                    $max_count = FilesBehavior::MAX_ATTR_FILES_COUNT;
                    for ($j = 0; $j < $max_count; $j++) {
                       $hidden = 'hidden';
                       $file = $author->getFile($attribute, $j);
                       if( (($file != NULL) && !$file->isEmpty()) || ($j == 0)){ 
                         $hidden = '';      
                       };
                  ?>  
                  <div name="<?php echo $attribute;?>_author_<?php echo $i?>_div" class="ordered <?php echo $hidden?>" >
                  <?php echo $form->fileFields($author, "[$i]${attribute}", $j, $conf->getLanguages(), $visibleLanguages);?>
                  </div>
                  <?php }?>
                  <div class="actions right">
                  <a name="<?php echo $attribute . '_author_' . $i . '_link';?>" onclick="ShowNextFile('<?php echo $attribute . '_author_' . $i;?>');" href="javascript:void(0)"><?php echo Yii::t('actions','add');?></a>
                  </div>  
                  </div>
            </div>  
               <?php } ?>
               <?php } ?>
               <!-- конец поле-файл -->
                <?php }; // цикл по атрибутам ?>
                <!-- предпочтительный язык -->
                <?php 
                   $langs = $conf->getLanguages();
                   $locales = Yii::app()->params['languages']; 
                   $_locales = array();
                   foreach($locales as $locale => $title){
                      if(isset($langs[$locale])){
                          $_locales[$locale]=$title;
                      }; 
                   };   
                   $locales = $_locales;
                   if (count($locales) > 1) {
                ?>
                <div class="row">
                    <div class="label">
                        <?php echo $form->label($author, 'locale'); ?>
                        <span class="hint"><?php echo Yii::t('participants','Language for messages on status of the application');?></span>
                    </div>
                    <div class="value">
                        <?php echo $form->radioButtonList($author, "[$i]locale", $locales, array('separator' => '', 'labelOptions' => array('class' => 'radioLabel')));
                        ?>
                    </div>
                </div>
                   <?php } else { 
                       $author->locale = current(array_keys($locales));
                       echo $form->hiddenField($author, "[$i]locale");
                   }; ?>
                <!-- конец предпочтительный язык -->
            </div>
            <?php }; //цикл по авторам ?>
            <br class="clear"/>
        </div>
        <!-- конец поля автора -->
        <?php }; ?>
    <?php } ?>
    <!-- конец поля в завке на участие -->
    
    <!-- капча -->
    <?php if(CCaptcha::checkRequirements() && Yii::app()->user->isGuest):?>
    <div id="captcha_id" class="<?php echo $captchaClass;?>">
        <?php echo $form->label($captcha, 'verifyCode',array('required' => true));?><br />
        <?php echo CHtml::activeTextField($captcha, 'verifyCode')?><br />
        <?php $this->widget('CCaptcha', array('buttonOptions' => array('class'=>'new-code-link'))); ?>  
    </div>
    <?php endif?>
    <!-- конец капча -->
  
    <?php echo $form->honeypot($participant, 'ukazhite_e_mail');?>
    
    <!-- кнопки -->
    <div class="actions right">
        <?php if ($submitAction == 'save') { ?>
            <?php echo CHtml::link(Yii::t('actions','cancel'), $this->createUrl('participant/view', array('urn' => $conf->urn(), 'participant_urn' => $participant->urn())), array('class' => 'link'));?>
            <?php echo CHtml::submitButton(Yii::t('actions', 'Save')); ?>
        <?php } else { ?>
            <?php echo CHtml::submitButton(Yii::t('actions', 'Send')); ?>
        <?php } ?>
    </div>
    <!-- конец кнопки  -->

    <?php $this->endWidget(); ?>
</div>
