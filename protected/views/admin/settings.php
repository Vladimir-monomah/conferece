<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
       StringUtils::cutOnWord($conf->title())=>array('conf/info','urn'=>$conf->urn()),
       Yii::t('admin','Administration')=>array('admin/settings','urn'=>$conf->urn()),
       Yii::t('admin','Settings')
);
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCssFile( Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
    $jsParams=array();
    $jsParams['FileExts'] = Yii::app()->params['fileExts'];           
    Yii::app()->clientScript->registerScript('js.files.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/admin/fileExts.js', CClientScript::POS_HEAD);    
?>
<h2><?php echo Yii::t('admin','Settings');?></h2>
<div class="form confadmin-settings" >
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('admin/settings',array('urn'=>$conf->urn())))); ?> 
    <?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php };?>
    <?php echo $form->errorSummary($conf); ?>
    <div class="row" >
    <div class="label" ><?php echo CHtml::label(Yii::t('confs','Creation Date'),false);?></div>
    <div class="value" ><?php echo Yii::app()->locale->dateFormatter->formatDateTime($conf->creation_date,'long','medium');?>&nbsp;</div>
    </div>
    <div class="row" >
     <div class="label"  ><?php echo CHtml::label(Yii::t('confs','Last Update Date of Informational Pages'),false);?></div>
     <div class="value" ><?php echo Yii::app()->locale->dateFormatter->formatDateTime($conf->last_update_date,'long','medium');?>&nbsp;</div>
    </div>
    <?php if(Yii::app()->user->checkAccess("enableConf")){ ?>
    <div class="row" >
    <div class="label" ><?php echo $form->label($conf,'is_enabled');?></div>
    <div class="value" ><?php echo $form->checkBox($conf,'is_enabled'); ?></div>
    </div>
    <?php }?>
    <div class="row" >
    <div class="label" ><?php echo CHtml::label(Yii::t('admin','Conference Languages'),false);?></div>
    <div class="value" ><?php echo $form->checkBoxList($conf,'conf_languages',Yii::app()->params['languages'],array('separator'=>'&nbsp;','labelOptions'=>array('class'=>'radioLabel'))); ?></div>
    </div>
    <div class="row" >
    <div class="label" ><?php echo $form->label($conf,'is_registration_enabled');?></div>
    <div class="value" ><?php echo $form->checkBox($conf,'is_registration_enabled'); ?></div>
    </div>    
    <div class="row" >
    <div class="label" ><?php echo $form->label($conf,'is_guestbook_enabled');?></div>
    <div class="value" ><?php echo $form->checkBox($conf,'is_guestbook_enabled'); ?></div>
    </div>
    <div class="row" >
    <div class="label"  ><?php echo $form->label($conf,'is_commenting_enabled');?></div>
    <div class="value" ><?php echo $form->checkBox($conf,'is_commenting_enabled'); ?></div>
    </div>
    <?php  $dateFormat = DateUtils::JuiDateFormat();  ?>
    <div class="row" >
        <div class="label" > 
           <?php echo $form->label($conf,'publication_date');?>
           <span class="hint"><?php echo Yii::t('confs','after end date of the conference by default');?></span>
        </div>
        <div class="value" >
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$conf,
                    'attribute'=>'publicationDateStr',
                    'language'=> Yii::app()->getLanguage(),
                    'options'=>array('changeYear'=>true,'dateFormat'=>$dateFormat),
                    'htmlOptions'=>array('size'=>10, 'maxlength'=>10))); ?>
        </div>
    </div> 
    <br class="br-clear"/>
    <div class="row">
        <?php echo $form->label($conf,'participant_editing_option'); ?><br />
        <?php echo $form->radioButtonList($conf,'participant_editing_option',ParticipantEditingOption::getOptionList(),array('separator'=>'<br />','labelOptions'=>array('class'=>'radioLabel')));?>
    </div>
    <div class="row">
        <?php echo $form->label($conf,'participant_publishing_option'); ?><br />
        <?php echo $form->radioButtonList($conf,'participant_publishing_option',ParticipantPublishingOption::getOptionList(),array('separator'=>'<br />','labelOptions'=>array('class'=>'radioLabel')));?>
    </div>
    <div class="row">
        <?php echo $form->label($conf,'show_all_participants'); ?>        <br />
           <?php 
              $data=array(
                  0=>Yii::t('participants','Show reports only'),
                  1=>Yii::t('participants','Show all participants')
              );
              echo $form->radioButtonList($conf,'show_all_participants',$data,array('separator'=>'<br />','labelOptions'=>array('class'=>'radioLabel')));
           ?>      
    </div>
    <div class="row" >
        <?php echo $form->checkBox($conf,'show_images'); ?>
        <?php echo $form->label($conf,'show_images');?>
    </div>
    <br class="clear"/>
    <div class="row" >
    <?php echo CHtml::label(Yii::t('participants','Participation Types'),false,array('class'=>'left'));?><br>
    <table class="settings-participation-types" >
        <tr class="settings-participation-types" >
            <td><?php echo Yii::t('admin','with paper');?></td>
            <td><?php echo Yii::t('admin','without paper');?></td>
        </tr>
        <tr>
        <td>
    <?php echo $form->checkBoxList($conf,'participation_paper_types',ParticipationType::participation_types(ParticipationType::TYPE_PAPER),array('separator'=>'<br />','labelOptions'=>array('class'=>'radioLabel'))); ?>
        </td>
        <td>
    <?php echo $form->checkBoxList($conf,'participation_wo_paper_types',ParticipationType::participation_types(ParticipationType::TYPE_WO_PAPER),array('separator'=>'<br />','labelOptions'=>array('class'=>'radioLabel'))); ?>
        </td>
        </tr>
     </table>
    </div>
    <div class="row">
           <?php echo $form->label($conf,'file_exts',array('for'=>'file_types_id'));?><br />
           <?php echo Yii::t('admin','types of files that are allowed to upload when making application to the conference');?><br />
           <?php echo $form->textField($conf,'file_exts',array('id'=>'file_types_id','size'=>89,'maxlength'=>200,'class'=>'value'));?><br />
           <span class="value-hint"><?php echo Yii::t('admin','a list of file extensions from the list, separated by commas');?></span>
    </div>
    <div class="row">
           <?php echo $form->label($conf,'menu_title');?><br />
           <?php echo $form->textFields($conf,"menu_title",array('size'=>60,'maxlength'=>100,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages()); ?>
    </div>
    <div class="actions right">
        <?php echo CHtml::submitButton(Yii::t('actions','Save')); ?>
    </div>
    <?php $this->endWidget(); ?>
    <hr />
    <h3><?php echo Yii::t('admin','Delete Conference');?></h3>
     <?php echo Yii::t('admin','This option is available for conferences in which no applications accepted.');?>
     <br /><br />
     <?php if(!$conf->hasApprovedParticipants()){?>
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('admin/delete',array('urn'=>$conf->urn())))); ?>
     <div class="actions right">
         <?php echo CHtml::submitButton(Yii::t('actions','Delete'),array('onclick'=>'return confirm("'.Yii::t('actions','Delete').'?");')); ?>
     </div>
    <?php $this->endWidget(); ?>
    <?php }?>
</div>
