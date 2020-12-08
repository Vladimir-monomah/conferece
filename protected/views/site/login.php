<?php
/**
 *  @var $this SiteController 
 *  @var $model LoginForm 
 *  @var $form CActiveForm  
 */

$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - ' . Yii::t('users','Login');
$this->breadcrumbs=array(
        Yii::t('users','Login'),
);
?>
<h1><?php echo Yii::t('users','Login');?></h1>
<div class="form site-login">
    <?php $form=$this->beginWidget('ActiveForm', array('id'=>'login-form')); ?>

    <?php if(Yii::app()->user->hasFlash('passwordSent')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('passwordSent');?>
    </div>
    <?php }; ?>
    
    <p class="note"><?php echo Yii::t('validators', 'Fields with an asterisk {asterisk} are required.',
        array('{asterisk}'=>'<span class="required">*</span>'));?></p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="row">
        <div class="label">
        <?php echo $form->labelEx($model,'email'); ?>
        </div>
        <div class="value">
        <?php echo $form->textField($model,'email',array('size'=>100,'maxlength'=>100,'class'=>'value')); ?>
        </div>    
    </div>

    <div class="row">
        <div class="label">
        <?php echo $form->labelEx($model,'password'); ?>
        </div>
        <div class="value">
        <?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>50)); ?>
        </div>    
    </div>

    <?php echo $form->honeypot($model, 'ukazhite_e_mail'); ?>
    
    <div class="actions right">
                <?php echo CHtml::submitButton(Yii::t('actions','Login')); ?>            
    </div>

    <?php $this->endWidget(); ?>
</div>
