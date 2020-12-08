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
        Yii::t('confs','Conference Proceedings')=>array('conf/proceedings','urn'=>$conf->urn()),
        Yii::t('site','Editing')
);
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['DeleteFileMsg'] = Yii::t('admin','file is marked for deletion, you have to save changes');
    Yii::app()->clientScript->registerScript('js.proceedings.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/common/deleteFile.js?v=1', CClientScript::POS_HEAD); 
?>
<h2><?php echo Yii::t('confs','Conference Proceedings').' - ' .Yii::t('site','Editing');?></h2>
<div class="form conf confedit-proceedings" >
    <p class="note"> <?php echo Yii::t('participants','If loaded, conference proceedings are published in place of report list.')?></p>     
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('confEdit/proceedings',array('urn'=>$conf->urn())),'htmlOptions'=>array('enctype'=>'multipart/form-data'))); ?>
    <?php echo $form->errorSummary($conf); ?>
    <input type="hidden" name="scenario" value="proceedings" />
    <div class="row" >
        <?php echo $form->fileFields($conf,'proceedings');?>
        <span class="fileHint" ><?php echo Yii::t('validators','File formats allowed to upload');?>:&nbsp;<?php echo FileUtils::listStr(Yii::app()->params['fileExts']); ?></span>
        <span class="fileHint" ><?php echo Yii::t('validators','Max file size allowed to upload');?>:&nbsp;<?php echo FileUtils::fileSizeStr(Yii::app()->params['userFileSize']);?></span>
    </div>
    <div class="actions right">
        <?php echo CHtml::link( Yii::t('actions','cancel'),$this->createUrl('conf/'.$action,array('urn'=>$conf->urn())),array('class'=>'link'));?>
        <?php echo CHtml::submitButton(Yii::t('actions','Save')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>


