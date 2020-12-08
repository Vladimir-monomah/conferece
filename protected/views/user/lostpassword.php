<?php
/**
 *  @var $this UserController 
 */

$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - ' . Yii::t('users','Password recovery');
$this->breadcrumbs=array(
        Yii::t('users','Password recovery'),
);
?>
<h1><?php echo Yii::t('users','Password recovery')?></h1>
<div class="form user-lostpassword" >   
    <?php if(Yii::app()->user->hasFlash('passwordSent')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('passwordSent');?>
    </div>
    <?php }else { ?>
    <?php if(Yii::app()->user->hasFlash('emailNotFound')){?>
    <div class="errorSummary">
        <?php echo Yii::app()->user->getFlash('emailNotFound');?>
    </div>
    <?php }; ?>
     <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('user/lostpassword'))); ?>
    <p class="note">
    <?php echo Yii::t('users','New password will be sent to Your E-mail.');?>
    </p>
    <div class="row">
        <?php echo CHtml::label('E-mail',''); ?>
        <?php echo CHtml::textField('email','', array('size'=>40,'maxlength'=>100)); ?>
        <?php $model = new LoginForm; echo $form->honeypot($model, 'ukazhite_e_mail'); ?>
        &nbsp;<?php echo CHtml::submitButton(Yii::t('actions','Send')); ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php }?>  
</div>