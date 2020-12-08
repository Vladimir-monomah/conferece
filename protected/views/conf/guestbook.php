<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 *  @var $guestbooks array of Guestbook
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/info','urn'=>$conf->urn()),
        Yii::t('confs','Guestbook')
);
$accessParams=array(
            "conf_id"=>$conf->id,
            "user_id"=>Yii::app()->user->id
        );
?>
<?php 
    Yii::app()->clientScript->registerCoreScript('jquery'); 
    $jsParams=array();
    $jsParams['Language'] = Yii::app()->language;
    Yii::app()->clientScript->registerScript('js.guestbook.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/tinymce_4.1.9/tinymce.min.js');
    Yii::app()->clientScript->registerScriptFile('/js/common/attachTinymce.js?v=5', CClientScript::POS_HEAD); 
?>
<h2><?php echo Yii::t('confs','Guestbook');?></h2>
<div class="form conf-guestbook">
    <?php if(Yii::app()->user->isGuest){?>
    <p class="note"><?php echo Yii::t('confs','Only registered users are allowed to post messages to guestbook.');?></p>
    <?php }?>
    <?php foreach($guestbooks as $guestbook){ ?>
    <div class="row ordered" >
        <h3><?php echo Yii::app()->locale->dateFormatter->formatDateTime($guestbook->date,'long','medium').'<br />'. $guestbook->name;?></h3>
         <?php echo $guestbook->message;?>
         <?php if(Yii::app()->user->checkAccess("editGuestbook", $accessParams)){?>
         <div class="actions right">
            <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('conf/deleteGuestbook',array('urn'=>$conf->urn(),'guestbook_id'=>$guestbook->id)))); ?>
            <?php echo CHtml::submitButton(Yii::t('actions','Delete'),array('onclick'=>'return confirm("'.Yii::t('actions','Delete').'?");')); ?>
            <?php $this->endWidget(); ?>
         </div>
         <?php }?>
     </div>
    <?php }?>

    <?php 
        $guestbook=new Guestbook();
        if(Yii::app()->user->checkAccess("postGuestbook", $accessParams)){?>
       <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('conf/postGuestbook',array('urn'=>$conf->urn())),'htmlOptions'=>array('autocomplete'=>'off'))); ?>
        <div class="row" >
        <?php echo $form->label($guestbook,'message');?>
        <br />
        <?php echo $form->textArea($guestbook,'message',array('cols'=>80,'rows'=>2,'class'=>'editor value'),'<br />' );?>
        </div>
        <div class="actions right">
        <?php echo CHtml::submitButton(Yii::t('actions','Send')); ?>
        </div>
       <?php $this->endWidget(); ?>
    <?php }?>    
</div>
