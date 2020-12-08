<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 *  @var $appForm AppFormSettings
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/info','urn'=>$conf->urn()),
        Yii::t('admin','Administration')=>array('admin/settings','urn'=>$conf->urn()),
        Yii::t('admin','Application Form')
);
?>
<?php
    $pAttributesEnabled = $appForm->getPAttributes(true);
    $pAttributesDisabled = $appForm->getPAttributes(false);

    $pAttributesOptions = array();
    $pStandardOptions = array();
    $pAdditionalOptions = array();

    foreach($pAttributesDisabled as $attr){
        if ($appForm->isAdditionalAttribute($attr)) {
            $attr_title = FieldType::name($appForm->{$attr.'_type'});
            $attr_title = StringUtils::firstUCharString($attr_title);
            if (!in_array($attr_title, $pAdditionalOptions)) {
                $pAdditionalOptions[$attr] = $attr_title;
            }         
        } else {
            $pStandardOptions[$attr] = $appForm->getAttributeLabel($attr);
        }
    }
    if (!empty($pStandardOptions)) {
        $pAttributesOptions[Yii::t('admin', 'Standard fields')] = $pStandardOptions;
    }
    if (!empty($pAdditionalOptions)) {
        $pAttributesOptions[Yii::t('admin', 'Additional fields')] = $pAdditionalOptions;
    }
    
    $aAttributesEnabled = $appForm->getAAttributes(true);
    $aAttributesDisabled = $appForm->getAAttributes(false);

    $aAttributesOptions = array();
    $aStandardOptions = array();
    $aAdditionalOptions = array();

    foreach($aAttributesDisabled as $attr){
        if ($appForm->isAdditionalAttribute($attr)) {
            $attr_title = FieldType::name($appForm->{$attr.'_type'});
            $attr_title = StringUtils::firstUCharString($attr_title);
            if (!in_array($attr_title, $aAdditionalOptions)) {
                $aAdditionalOptions[$attr] = $attr_title;
            }         
        } else {
            $aStandardOptions[$attr] = $appForm->getAttributeLabel($attr);
        }
    }
    if (!empty($aStandardOptions)) {
        $aAttributesOptions[Yii::t('admin', 'Standard fields')] = $aStandardOptions;
    }
    if (!empty($aAdditionalOptions)) {
        $aAttributesOptions[Yii::t('admin', 'Additional fields')] = $aAdditionalOptions;
    }
    
    $lang_count = count($conf->getLanguages());
     
    $modeOptionsAll= array();
    $modeOptionsAll[AppFormSettings::MODE_DISABLED] = Yii::t('admin', 'Off');
    
    if ($lang_count > 1) {
        $modeOptionsAll[AppFormSettings::MODE_ENABLED_CURRENT] = Yii::t('admin', 'Enabled in the language of application');
        $modeOptionsAll[AppFormSettings::MODE_ENABLED] = Yii::t('admin', 'Enabled in all languages');
        $modeOptionsAll[AppFormSettings::MODE_MANDATORY_CURRENT] = Yii::t('admin', 'Required in the language of application');
        $modeOptionsAll[AppFormSettings::MODE_MANDATORY_ONE] = Yii::t('admin', 'Required in one language');
        $modeOptionsAll[AppFormSettings::MODE_MANDATORY_ALL] = Yii::t('admin', 'Required in all languages');
    } else {
        $modeOptionsAll[AppFormSettings::MODE_ENABLED] = Yii::t('admin', 'On (optional)');
        $modeOptionsAll[AppFormSettings::MODE_MANDATORY] = Yii::t('admin', 'Required');
    }
    
    $modeOptionsYesNo = array();
    $modeOptionsYesNo[AppFormSettings::MODE_DISABLED] = Yii::t('admin', 'Off');
    $modeOptionsYesNo[AppFormSettings::MODE_ENABLED] = Yii::t('admin', 'On (optional)');
    $modeOptionsYesNo[AppFormSettings::MODE_MANDATORY] = Yii::t('admin', 'Required');
    
    $modeOptionsEmail = array();
    $modeOptionsEmail[AppFormSettings::MODE_ENABLED] = Yii::t('admin', 'Required for the first author');
    $modeOptionsEmail[AppFormSettings::MODE_MANDATORY] = Yii::t('admin', 'Required');
    
    $modeOptionsFIO = array();
    
    if ($lang_count > 1) {
        $modeOptionsFIO[AppFormSettings::MODE_ENABLED_CURRENT] = Yii::t('admin', 'Enabled in the language of application');
        $modeOptionsFIO[AppFormSettings::MODE_ENABLED] = Yii::t('admin', 'Enabled in all languages');
        $modeOptionsFIO[AppFormSettings::MODE_MANDATORY_CURRENT] = Yii::t('admin', 'Required in the language of application');
        $modeOptionsFIO[AppFormSettings::MODE_MANDATORY_ONE] = Yii::t('admin', 'Required in one language');
        $modeOptionsFIO[AppFormSettings::MODE_MANDATORY_ALL] = Yii::t('admin', 'Required in all languages');
    } else {
        $modeOptionsFIO[AppFormSettings::MODE_ENABLED] = Yii::t('admin', 'On (optional)');
        $modeOptionsFIO[AppFormSettings::MODE_MANDATORY] = Yii::t('admin', 'Required');
    }

?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams = array();
    $jsParams['DeleteFieldMsg'] = Yii::t('admin', 'The field is marked for deletion, you have to save changes.');
    $jsParams['RevertMsg'] = Yii::t('actions','revert');           
    Yii::app()->clientScript->registerScript('js.form.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/admin/form.js?v=1', CClientScript::POS_HEAD); 
?>
<h2><?php echo Yii::t('admin','Application Form');?></h2>
<div class="form confadmin-form" >
    <p class="note">
        <?php echo Yii::t('admin','Notes:'); ?>
        <ul>  
        <li><?php echo Yii::t('admin', 'Customization of the application form includes addition of needed fields, removing of superfluous ones, adjusting the order of the fields and their settings.');?></li>    
        <li><?php echo Yii::t('admin', 'The list of topics and sessions is to be populated through a special item of the administrative menu. On a page "Participants" all recieved application forms are distributed by topics that helps organizing commitee to process them.'); ?></li>  
        <li><?php echo Yii::t('admin', 'Hint is an optional short text that is shown near the title of the field in an application form.')?></li>
        <li><?php echo Yii::t('admin', 'The label "Published" for a field means that the information filled in the field will be available for reading by every visitor of the website after all application forms are published. Otherwise nor field nor information in it becomes publicly available.'); ?></li>
        </ul>
    </p>
    <?php $form = $this->beginWidget('ActiveForm',array('action'=>$this->createUrl('admin/form',array('urn'=>$conf->urn())))); ?>

    <?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
        <?php if(Yii::app()->user->hasFlash('NewFieldAdded')) {?>
            <br /><?php echo Yii::app()->user->getFlash('NewFieldAdded'); ?>
        <?php };?>
    </div>
    <?php };?>
     
    <?php if(Yii::app()->user->hasFlash('EmptyFieldName')) {?>
    <div class="errorSummary"><?php echo Yii::app()->user->getFlash('EmptyFieldName'); ?></div>
    <?php };?>
    <?php echo $form->errorSummary($appForm); ?>

    <h3><?php echo Yii::t('admin','Fields in the Application Form');?></h3>
    <table class="table">
        <tr>          
            <th class="center" width='33%'>
                <?php echo Yii::t('participants','Field');?>
                <br/><span class="ihint"><?php echo Yii::t('admin','field type');?></span>
            </th>
            <th class="center" width='33%'><?php echo Yii::t('participants','Hint');?></th>
            <th class="center" width='33%'><?php echo Yii::t('admin','Settings');?></th>
        </tr>
        <?php 
            $count = count($pAttributesEnabled);
            $is_first_tr = true;
            $is_last_tr = false;
        ?>
        <?php foreach($pAttributesEnabled as $i => $attribute) {
            if ($i > 0) { $is_first_tr = false; };
            if ($i == ($count - 1)) { $is_last_tr = true; };
        ?>
        <tr class="ordered">        
          <td class="top">
              <?php 
                if ($attribute == 'authors') {
                    echo $form->hiddenField($appForm, $attribute . '_order');
                    echo Yii::t('admin', 'Authors') . '<br />';
                } else if (!$appForm->isAdditionalAttribute($attribute)) {
                    echo $form->hiddenField($appForm, 'is_' . $attribute . '_enabled');
                    echo $appForm->getAttributeLabel($attribute) . '<br />';
                } else {
                    echo $form->hiddenField($appForm, 'is_' . $attribute . '_enabled');
                    echo $form->textFields($appForm, $attribute.'_name',array('size'=>30,'maxlength'=>200,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages());
                }; 
              ?>              
              <?php if ($attribute == 'authors') { ?>
                 <span class="ihint" >
                    <?php echo Yii::t('admin', 'unit of authors') . '<br />' . Yii::t('admin', 'author`s fields are customized below'); ?>
                 </span>
                 <div class='actions'><a href="javascript:void(0)" onclick="upField(this);" class="link <?php echo $is_first_tr?'disabled':'';?>" name="up"><?php echo Yii::t('actions', 'move up'); ?></a>&nbsp;<a href="javascript:void(0)" onclick="downField(this);" class="link <?php echo $is_last_tr?'disabled':'';?>" name="down"><?php echo Yii::t('actions', 'move down'); ?></a></div>
              <?php  } else { ?>
                  <span class="ihint" >
                   <?php echo FieldType::name($appForm->{$attribute.'_type'}); ?>
                  </span> 
                  <?php if ($appForm->isAdditionalAttribute($attribute) && ($appForm->{$attribute . '_type'} == FieldType::SELECT)) { 
                    echo CHtml::submitButton(Yii::t('admin','Edit list'),array('name'=>$attribute, 'onclick'=>"return confirm('".Yii::t('admin','Save the form and switch to editing the list?')."');")); 
                  }?> 
                  <div class='actions'><a href="javascript:void(0)" onclick="upField(this);" class="link <?php echo $is_first_tr?'disabled':'';?>" name="up"><?php echo Yii::t('actions', 'move up'); ?></a>&nbsp;<a href="javascript:void(0)" onclick="downField(this);" class="link <?php echo $is_last_tr?'disabled':'';?>" name="down"><?php echo Yii::t('actions', 'move down'); ?></a>&nbsp;<a href="javascript:void(0)" onclick="deleteField(this);" class="link" ><?php echo Yii::t('actions', 'delete'); ?></a></div>                 
              <?php } ?>               
          </td>
          <td class="top">
              <?php 
                if ($attribute != 'authors') {
                    echo $form->textFields($appForm, $attribute.'_hint',array('size'=>30,'maxlength'=>200,'class'=>'hint-value','tableClass'=>'value'),'vertical',$conf->getLanguages()); 
                }; 
              ?>
          </td>
          <td class="top">
              <?php  if ($attribute != 'authors') { ?>
              <span class='header'><?php echo Yii::t('admin', 'For an application with paper');?></span>
              <?php
                    $modeOptions = $modeOptionsYesNo;
                    if ($appForm->modeOptionsType($attribute) == AppFormSettings::MODE_OPTIONS_ALL) {
                        $modeOptions = $modeOptionsAll;
                    };
                    echo $form->dropDownList($appForm, $attribute . "_wi_paper_mode", $modeOptions); 
                    echo '<br />' . $form->checkBox($appForm, 'is_' . $attribute . '_wi_paper_published') . '&nbsp;' . $form->label($appForm, 'is_' . $attribute . '_wi_paper_published', array('label' => Yii::t('admin','Published')));
              ?>
              <br /><br />
              <?php
                $htmlOptions = array();
                if (in_array($attribute, array('annotation', 'report_title', 'report_text', 'report_file', 'classification'))){
                    $appForm->{$attribute . "_wo_paper_mode"} = AppFormSettings::MODE_DISABLED;
                    $appForm->{'is_' . $attribute . '_wo_paper_published'} = FALSE;
                    $htmlOptions['disabled'] = 'disabled';
                }
              ?>
              <span class='header'><?php echo Yii::t('admin', 'For an application without paper');?></span>
              <?php
                    echo $form->dropDownList($appForm, $attribute . "_wo_paper_mode", $modeOptions, $htmlOptions); 
                    echo '<br />' . $form->checkBox($appForm, 'is_' . $attribute . '_wo_paper_published', $htmlOptions) . '&nbsp;' . $form->label($appForm, 'is_' . $attribute . '_wo_paper_published', array('label' => Yii::t('admin','Published')));;
              ?>
              <?php } ?>
          </td>
        </tr>
        <?php } ?>
    </table>    
    
    <table class='actions'>
    <tr>
        <td style="text-align:left">
            <?php foreach($pAttributesDisabled as $i => $attribute) { 
                    echo $form->hiddenField($appForm, 'is_' . $attribute . '_enabled', array('value' => '0'));
                };
            ?>
            <?php if (!empty($pAttributesOptions)) { ?>
            <?php echo $form->dropDownList($appForm, "new_pattribute", $pAttributesOptions, array('prompt' => Yii::t('admin', 'New field') . ' ...')); ?>
            <?php echo CHtml::submitButton(Yii::t('actions','Add'), array('name'=>'addAttribute')); ?>   
            <?php }; ?>
        </td>
        <td style="text-align:right">
          <?php echo CHtml::submitButton(Yii::t('actions','Save'), array('name'=>'save')); ?>          
        </td>
    </tr>
    </table>
    
    <br />
    <h3><?php echo Yii::t('admin',"Author's Fields");?></h3>
    <table class="table">
        <tr>          
            <th class="center" width='33%'>
                <?php echo Yii::t('participants','Field');?>
                <br/><span class="ihint"><?php echo Yii::t('admin','field type');?></span>
            </th>
            <th class="center" width='33%'><?php echo Yii::t('participants','Hint');?></th>
            <th class="center" width='33%' ><?php echo Yii::t('admin', 'Settings');?></th>
        </tr>
        <?php 
            $count = count($aAttributesEnabled);
            $is_first_tr = true;
            $is_last_tr = false;
        ?>        
        <?php foreach($aAttributesEnabled as $i => $attribute) { 
            if ($i > 0) { $is_first_tr = false; };
            if ($i == ($count - 1)) { $is_last_tr = true; };
        ?>
        <tr class="ordered">        
          <td class="top">
              <?php 
                echo $form->hiddenField($appForm, 'is_' . $attribute . '_enabled');
                if (!$appForm->isAdditionalAttribute($attribute)) {
                    echo $appForm->getAttributeLabel($attribute) . '<br />';
                } else {
                    echo $form->textFields($appForm, $attribute.'_name',array('size'=>30,'maxlength'=>200,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages());
                }; 
              ?>             
              <span class="ihint"  >
                  <?php echo FieldType::name($appForm->{$attribute.'_type'}); ?>
              </span>      
              <?php if ($appForm->isAdditionalAttribute($attribute) && ($appForm->{$attribute . '_type'} == FieldType::SELECT)) { 
                    echo CHtml::submitButton(Yii::t('admin','Edit list'),array('name'=>$attribute, 'onclick'=>"return confirm('".Yii::t('admin','Save the form and switch to editing the list?')."');")); 
              }?>
              <div class='actions'>
                  <a href="javascript:void(0)" onclick="upField(this);" class="link <?php echo $is_first_tr?'disabled':'';?>" name="up"><?php echo Yii::t('actions', 'move up'); ?></a>&nbsp;
                  <a href="javascript:void(0)" onclick="downField(this);" class="link <?php echo $is_last_tr?'disabled':'';?>" name="down"><?php echo Yii::t('actions', 'move down'); ?></a>&nbsp;
                  <?php if (!in_array($attribute, array('lastname', 'firstname', 'middlename', 'email'))) { ?><a href="javascript:void(0)" onclick="deleteField(this);" class="link" ><?php echo Yii::t('actions', 'delete'); ?></a><?php }; ?>
              </div>
          </td>
          <td class="top">
              <?php 
                    echo $form->textFields($appForm, $attribute.'_hint',array('size'=>30,'maxlength'=>200,'class'=>'hint-value','tableClass'=>'value'),'vertical',$conf->getLanguages()); 
              ?>
          </td>
          <td class="top">
              <span class='header'><?php echo Yii::t('admin', 'For an application with paper');?></span>
              <?php
                    $modeOptions = $modeOptionsYesNo;
                    if ($appForm->modeOptionsType($attribute) == AppFormSettings::MODE_OPTIONS_ALL) {
                        $modeOptions = $modeOptionsAll;
                    };
                    if ($attribute == 'email') {
                        $modeOptions = $modeOptionsEmail;
                    };
                    if(in_array($attribute, array('lastname', 'firstname', 'middlename'))) {
                        $modeOptions = $modeOptionsFIO;
                    };
                    $htmlOptions = array();
                    if (in_array($attribute, array('lastname', 'firstname', 'middlename'))){
                        $appForm->{'is_' . $attribute . '_wi_paper_published'} = TRUE;
                        $appForm->{'is_' . $attribute . '_wo_paper_published'} = TRUE;
                        $htmlOptions['disabled'] = 'disabled';
                    };
                    echo $form->dropDownList($appForm, $attribute . "_wi_paper_mode", $modeOptions); 
                    echo '<br />' . $form->checkBox($appForm, 'is_' . $attribute . '_wi_paper_published', $htmlOptions) . '&nbsp;' . $form->label($appForm, 'is_' . $attribute . '_wi_paper_published', array('label' => Yii::t('admin','Published')));
              ?>
              <br /><br />
              <span class='header'><?php echo Yii::t('admin', 'For an application without paper')?></span>
              <?php
                    echo $form->dropDownList($appForm, $attribute . "_wo_paper_mode", $modeOptions); 
                    echo '<br />' . $form->checkBox($appForm, 'is_' . $attribute . '_wo_paper_published', $htmlOptions) . '&nbsp;' . $form->label($appForm, 'is_' . $attribute . '_wo_paper_published', array('label' => Yii::t('admin','Published')));
              ?>
          </td>
        </tr>
        <?php } ?>
    </table>    
    
    <table class='actions'>
    <tr>
        <td style="text-align:left">
            <?php foreach($aAttributesDisabled as $i => $attribute) { 
                    echo $form->hiddenField($appForm, 'is_' . $attribute . '_enabled', array('value' => '0'));
                };
            ?>
            <?php if (!empty($aAttributesOptions)) { ?>
            <?php echo $form->dropDownList($appForm, "new_aattribute", $aAttributesOptions, array('prompt' => Yii::t('admin', 'New field') . ' ...')); ?>
            <?php echo CHtml::submitButton(Yii::t('actions','Add'), array('name'=>'addAttribute')); ?>   
            <?php }; ?>
        </td>
        <td style="text-align:right">
          <?php echo CHtml::submitButton(Yii::t('actions','Save'), array('name'=>'save')); ?>          
        </td>
    </tr>
    </table>
    
    <?php $this->endWidget(); ?> 
</div>