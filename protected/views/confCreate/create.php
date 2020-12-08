<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 */
?>
<?php
$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - '. Yii::t('confs','New Conference');
$this->breadcrumbs=array(Yii::t('confs','Add Conference'));

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile('/js/confCreate/adjustTranslations.js', CClientScript::POS_HEAD);   
?>
<h1><?php echo Yii::t('confs','New Conference'); ?></h1>
<div class="form confCreate-create">
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('confCreate/create'),'htmlOptions'=>array('enctype'=>'multipart/form-data'))); ?>   
    <p class="note"><?php echo Yii::t('validators', 'Fields with an asterisk {asterisk} are required.',
        array('{asterisk}'=>'<span class="required">*</span>'));?></p>
    <?php echo $form->errorSummary($conf); ?>
    <div class="row" >
        <div class="label">
        <?php echo CHtml::label(Yii::t('admin','Conference Languages'),false);?>
        </div>
        <div class="value">
        <?php echo $form->checkBoxList($conf,'conf_languages',Yii::app()->params['languages'],array('separator'=>'&nbsp;','labelOptions'=>array('class'=>'radioLabel'))); ?>
        </div>    
    </div>
    <?php  $dateFormat = DateUtils::JuiDateFormat();  ?>
    <div class="row" >
        <div class="label"  ><?php echo $form->label($conf,'start_date',array('required'=>true));?></div>
        <div class="value" >
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$conf,
                    'attribute'=>'startDateStr',
                    'language'=> Yii::app()->getLanguage(),
                    'options'=>array('changeYear'=>true,'dateFormat'=>$dateFormat),
                    'htmlOptions'=>array('size'=>10, 'maxlength'=>10))); ?>
        </div>
    </div>
    <div class="row" >
        <div class="label" ><?php echo $form->label($conf,'end_date',array('required'=>true));?></div>
        <div class="value" >
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$conf,
                    'attribute'=>'endDateStr',
                    'language'=> Yii::app()->getLanguage(),
                    'options'=>array('changeYear'=>true,'dateFormat'=>$dateFormat),
                    'htmlOptions'=>array('size'=>10, 'maxlength'=>10))); ?>
        </div>
    </div>
    <div class="row" >
        <?php echo $form->label($conf,'subject',array('class'=>'left'));?><br />
        <span class="hint"><?php echo Yii::t('confs','e.g. International Conference');?></span>
        <?php echo $form->textFields($conf,'subject',array('size'=>137,'maxlength'=>200,'class'=>'value', 'tableClass'=>'value'),'vertical',Yii::app()->params['languages'],$conf->getLanguages());?>
    </div>
    <div class="row" >
        <?php echo $form->label($conf,'title',array('class'=>'left','required'=>true));?><br />
        <?php echo $form->textFields($conf,'title',array('size'=>137,'class'=>'value','tableClass'=>'value'),'vertical',Yii::app()->params['languages'],$conf->getLanguages());?>
    </div>
    <div class="actions right" >
        <?php echo CHtml::submitButton(Yii::t('actions','Add')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>