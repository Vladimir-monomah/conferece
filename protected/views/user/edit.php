<?php
/**
 *  @var $this UserController
 *  @var $user a User 
 */
$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - ' . Yii::t('site','Editing');
$this->breadcrumbs=array(
       Yii::t('users','Users')=>array('user/list'), 
       StringUtils::cutOnWord($fullName)=>array('user/view','id'=>$user->id),
       Yii::t('site','Editing'),
);
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['DeleteFileMsg'] = Yii::t('admin','file is marked for deletion, you have to save changes');
    Yii::app()->clientScript->registerScript('js.user.edit.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/common/deleteFile.js?v=1', CClientScript::POS_HEAD); 
?>
<h1><?php echo CHtml::encode($fullName). ' - ' . Yii::t('site','Editing');?></h1>
<div class="form user-edit" >
<?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('user/save',array('id'=>$user->id)),'htmlOptions'=>array('autocomplete'=>'off','enctype'=>'multipart/form-data'))); ?>
<p class="note"><?php echo Yii::t('validators', 'Fields with an asterisk {asterisk} are required.',
    array('{asterisk}'=>'<span class="required">*</span>'));?><br />
<?php echo Yii::t('validators', 'At least one field in a field group with an asterisk {asterisk} is required.',
    array('{asterisk}'=>'<span class="requiredOne">*</span>'));?>
</p>
<?php echo $form->errorSummary($user); ?>
<div class="row">
    <div class="label">
    <?php echo $form->label($user,'email',array('required'=>true)); ?>
    </div>
    <div class="value">
    <?php echo $form->textField($user,'email', array('size'=>40,'maxlength'=>100)); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($user,'password1'); ?>
    </div>
    <div class="value">
    <?php echo CHtml::passwordField('User[password1]','', array('size'=>30,'maxlength'=>50)); ?>&nbsp;
    <?php echo CHtml::passwordField('User[password2]','', array('size'=>30,'maxlength'=>50,'placeholder'=>Yii::t('users','password confirmation'))); ?>
    </div>
</div>
<div class="row" >
        <div class="label" >
        <?php echo $form->label($user,'image');?>
        </div>
        <div class="value" >
        <input type="hidden" name="MAX_FILE_SIZE" value="0" />
        <?php echo $form->imgFields($user,'image');?>
        <span class="fileHint" ><?php echo Yii::t('validators','File formats allowed to upload');?>:&nbsp;<?php echo FileUtils::listStr(Yii::app()->params['logoExts']); ?></span>
        <span class="fileHint" ><?php echo Yii::t('validators','Max file size allowed to upload');?>:&nbsp;<?php echo FileUtils::fileSizeStr(Yii::app()->params['userFileSize']);?></span> 
        </div>
</div>
<div class="row" >
    <div class="label">
    <?php echo $form->label($user,'lastname',array('requiredOne'=>true)); ?>
    </div>
    <div class="value">
    <?php echo $form->textFields($user,'lastname',array('size'=>30,'maxlength'=>30,'class'=>'value','tableClass'=>'value'),'vertical'); ?>
    </div>    
</div>
<div class="row" >
    <div class="label">
    <?php echo $form->label($user,'firstname',array('requiredOne'=>true)); ?>
    </div>
    <div class="value">
    <?php echo $form->textFields($user,'firstname',array('size'=>30,'maxlength'=>30,'class'=>'short-value','tableClass'=>'value')); ?>
    </div>    
</div>
<div class="row" >
    <div class="label">
    <?php echo $form->label($user,'middlename'); ?>
    </div>
    <div class="value">
    <?php echo $form->textFields($user,'middlename',array('size'=>30,'maxlength'=>30,'class'=>'value','tableClass'=>'value'),'vertical'); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
     <?php echo $form->label($user,'phone'); ?>
     <span class="hint"><?php echo Yii::t('users','+1 555 123-4567');?></span>
    </div>
    <div class="value">
    <?php echo $form->textField($user,'phone', array('size'=>100,'maxlength'=>100,'class'=>'short-value')); ?>   
    </div>    
</div>
<div class="row">
    <div class="label">
     <?php echo $form->label($user,'fax'); ?>
    </div>
    <div class="value">
  <?php echo $form->textField($user,'fax', array('size'=>40,'maxlength'=>40,'class'=>'short-value')); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
  <?php echo $form->label($user,'locale'); ?>
    </div>
    <div class="value">
  <?php echo $form->radioButtonList($user,'locale', Yii::app()->params['languages'],
          array('separator'=>'','labelOptions'=>array('class'=>'radioLabel'))); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
  <?php echo $form->label($user,'country'); ?>
    </div>
    <div class="value">
  <?php echo $form->textField($user,'country', array('size'=>100,'maxlength'=>100,'class'=>'value')); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
  <?php echo $form->label($user,'city'); ?>
    </div>
    <div class="value">
  <?php echo $form->textField($user,'city', array('size'=>100,'maxlength'=>100,'class'=>'value')); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($user,'home_address'); ?>
    </div>
    <div class="value">
     <?php echo $form->textField($user,'home_address', array('size'=>100,'maxlength'=>150,'class'=>'value')); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($user,'institution'); ?>
    </div>
    <div class="value">
    <?php echo $form->textarea($user,'institution', array('cols'=>74,'rows'=>2,'maxlength'=>300,'class'=>'value')); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($user,'institution_address'); ?>
    </div>
    <div class="value">
    <?php echo $form->textField($user,'institution_address', array('size'=>100,'maxlength'=>150,'class'=>'value')); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($user,'position'); ?>
    </div>
    <div class="value">
    <?php echo $form->textField($user,'position', array('size'=>100,'maxlength'=>150,'class'=>'value')); ?>
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($user,'academic_degree'); ?>
    <span class="hint"><?php echo Yii::t('users','Ph.D. (Cambridge)'); ?></span>
    </div>
    <div class="value">
    <?php echo $form->textField($user,'academic_degree', array('size'=>100,'maxlength'=>100,'class'=>'value')); ?>
    
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($user,'academic_title'); ?>
    <span class="hint"><?php echo Yii::t('users','Professor'); ?></span> 
    </div>
    <div class="value">
    <?php echo $form->textField($user,'academic_title', array('size'=>100,'maxlength'=>100,'class'=>'value')); ?>
       
    </div>    
</div>
<div class="row">
    <div class="label">
    <?php echo $form->label($user,'supervisor'); ?>
    <span class="hint"><?php echo Yii::t('users','Dr. John J. Smith, Ph.D. (Cambridge)'); ?></span> 
    </div>
    <div class="value">
    <?php echo $form->textField($user,'supervisor', array('size'=>100,'maxlength'=>200,'class'=>'value')); ?>      
    </div>    
</div>
<div class="actions right">
    <?php echo CHtml::link(Yii::t('actions','cancel'),array('user/view','id'=>$user->id),array('class'=>'link'));?>
    <?php echo CHtml::submitButton(Yii::t('actions','Save')); ?>
</div>
<?php $this->endWidget(); ?>
</div>


