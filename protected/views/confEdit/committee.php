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
        Yii::t('confs','Organizing Committee')=>array('conf/committee','urn'=>$conf->urn()),
        Yii::t('site','Editing')
);
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['Language'] = Yii::app()->language;
    $jsParams['FilemanagerTitle'] = Yii::t('site','File manager');
    $jsParams['FilemanagerEnabled'] = true;
    $jsParams['FilemanagerAccessKey'] = RFilemanagerUtils::genAccessKey($conf);
    Yii::app()->clientScript->registerScript('js.committee.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/tinymce_4.1.9/tinymce.min.js');   
    Yii::app()->clientScript->registerScriptFile('/js/common/attachTinymce.js?v=5', CClientScript::POS_HEAD); 
?>
<h2><?php echo Yii::t('confs','Organizing Committee').' - ' .Yii::t('site','Editing'); ?></h2>
<div class="form conf confedit-committee" > 
    <p><?php echo Yii::t('confs','List of persons responsible for carrying out the conference.');?></p>
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('confEdit/committee',array('urn'=>$conf->urn())),'htmlOptions'=>array('enctype'=>'multipart/form-data'))); ?>
    <?php echo $form->errorSummary($conf); ?>
    <div class="row" >
        <?php echo $form->textAreas($conf,'committee',array('cols'=>80,'rows'=>5,'class'=>'editor value','tableClass'=>'value','hintClass'=>'editor-hint'),'vertical',$conf->getLanguages() );?>
    </div>
    <div class="actions right" >
        <?php echo CHtml::link( Yii::t('actions','cancel'),$this->createUrl('conf/'.$action,array('urn'=>$conf->urn())),array('class'=>'link'));?>
        <?php echo CHtml::submitButton(Yii::t('actions','Save')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>


