<?php
/**
 *  @var $this OrgController
 *  @var $org a Org 
 */
$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - ' . Yii::t('site','Editing');
$this->breadcrumbs=array(
       Yii::t('orgs','Organizations')=>array('org/list'),
       StringUtils::cutOnWord($name)=>array('org/view','urn'=>$org->urn()),
       Yii::t('site','Editing')
);
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['DeleteFileMsg'] = Yii::t('admin','file is marked for deletion, you have to save changes');
    Yii::app()->clientScript->registerScript('js.org.edit.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/common/deleteFile.js?v=1', CClientScript::POS_HEAD); 
?>
<h1><?php echo CHtml::encode($name).' - ' . Yii::t('site','Editing');?></h1>
<div class="form org-edit" >
<?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('org/save',array('urn'=>$org->urn())),'htmlOptions'=>array('enctype'=>'multipart/form-data'))); ?>
<p class="note">
<?php echo Yii::t('validators', 'At least one field in a field group with an asterisk {asterisk} is required.',
    array('{asterisk}'=>'<span class="requiredOne">*</span>'));?>
</p>
<?php echo $form->errorSummary($org); ?>
<div class="row" >
    <div class="label">
     <?php echo $form->label($org,'is_enabled');?>
    </div>
    <div class="value">
     <?php echo CHtml::radioButtonList('Org[is_enabled]',$org->is_enabled,array('1'=>Yii::t('site','Yes'),'0'=>Yii::t('site','No')),array('separator'=>'','labelOptions'=>array('class'=>'radioLabel')));?>
    </div>
</div>
<div class="row" >
    <div class="label">
    <?php echo $form->label($org,'urn'); ?>
    </div>
    <div class="value">
    <?php echo Yii::app()->getBaseUrl('true').'/';?>
    <?php echo $form->textField($org,'urn',array('size'=>30,'maxlength'=>30)); ?>
    </div>    
</div>
<div class="row" >
    <div class="label">
    <?php echo $form->label($org,'name',array('requiredOne'=>true)); ?>
    </div>
    <div class="value">
    <?php echo $form->textFields($org,'name',array('size'=>100,'maxlength'=>400,'class'=>'value','tableClass'=>'value' ),'vertical'); ?>
    </div>    
</div>
<div class="row" >
    <div class="label">
    <?php echo $form->label($org,'shortname'); ?>
    </div>
    <div class="value">
    <?php echo $form->textFields($org,'shortname',array('size'=>30,'maxlength'=>40,'class'=>'short-value','tableClass'=>'value')); ?>
    </div>    
</div>
<div class="row" >
    <div class="label">
    <?php echo $form->label($org,'address'); ?>
    </div>
    <div class="value">
    <?php echo $form->textFields($org,'address',array('size'=>100,'maxlength'=>200,'class'=>'value','tableClass'=>'value'),'vertical'); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($org,'website'); ?>
    </div>
    <div class="value">
    <?php echo $form->textField($org,'website', array('size'=>40,'maxlength'=>100)); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($org,'email'); ?>
    </div>
    <div class="value">
    <?php echo $form->textField($org,'email', array('size'=>40,'maxlength'=>100)); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($org,'phone'); ?>
    </div>    
    <div class="value">
    <?php echo $form->textField($org,'phone', array('size'=>100,'maxlength'=>100,'class'=>'value','tableClass'=>'value')); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($org,'fax'); ?>
    </div>
    <div class="value">
    <?php echo $form->textField($org,'fax', array('size'=>40,'maxlength'=>40)); ?>
    </div>    
</div>
<div class="row">
       <div class="label">
        <?php echo $form->label($org,'logo'); ?>
       </div>    
       <div class="value">
          <?php echo $form->imgFields($org,'logo');?>
        <span class="fileHint" ><?php echo Yii::t('validators','File formats allowed to upload');?>:&nbsp;<?php echo FileUtils::listStr(Yii::app()->params['logoExts']); ?></span>
        <span class="fileHint" ><?php echo Yii::t('validators','Max file size allowed to upload');?>:&nbsp;<?php echo FileUtils::fileSizeStr(Yii::app()->params['userFileSize']);?></span>
       </div>
</div>
<div class="actions right"> 
     <?php echo CHtml::link(Yii::t('actions','cancel'),array('org/view','urn'=>$org->urn()),array('class'=>'link'));?>
     <?php echo CHtml::submitButton(Yii::t('actions','Save')); ?>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->


