<?php
/**
 *  @var $this SiteController
 *  @var $page SitePage
 */
?>
<?php
$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - '.Yii::t('site','About'). ' - ' . Yii::t('site','Editing');
$this->breadcrumbs=array(
        Yii::t('site','About')=>array('site/about'),
        Yii::t('site','Editing')
);
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['Language'] = Yii::app()->language;
    //  дополнительные блоки форматирования
    //  additional formatting blocks
    $jsParams['BlockFormats'] = 'Header 2=h2;';
    Yii::app()->clientScript->registerScript('js.about.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/tinymce_4.1.9/tinymce.min.js');
    Yii::app()->clientScript->registerScriptFile('/js/common/attachTinymce.js?v=5', CClientScript::POS_HEAD); 
?>
<h1><?php echo Yii::t('site','About'). ' - ' . Yii::t('site','Editing'); ?></h1>
<div class="form site-editAbout" >
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('site/editAbout'))); ?>
    <?php echo $form->errorSummary($page); ?>
    <div class="row" >
    <?php echo $form->textAreas($page,'content',array('cols'=>118,'rows'=>5,'class'=>'editor value','tableClass'=>'value','hintClass'=>'editor-hint'),'vertical',Yii::app()->params['languages']);?>
    </div>
    <div class="actions right">
        <?php echo CHtml::link(Yii::t('actions','cancel'),$this->createUrl('site/about'),array('class'=>'link'));?>
        <?php echo CHtml::submitButton(Yii::t('actions','Save')); ?>        
    </div>
    <?php $this->endWidget(); ?>
</div>

