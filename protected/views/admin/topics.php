<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 *  @var $topics ConfTopic
 *  @var $scientific_areas
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/info','urn'=>$conf->urn()),
        Yii::t('admin','Administration')=>array('admin/settings','urn'=>$conf->urn()),
        Yii::t('admin','Topics and Sessions')
);
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['DeleteTopicMsg'] = Yii::t('admin','topic is marked for deletion, you have to save changes');
    $jsParams['RevertMsg'] = Yii::t('actions','revert');           
    $jsParams['TopicsCount'] = count($topics);          
    Yii::app()->clientScript->registerScript('js.topics.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/admin/topics.js?v=1', CClientScript::POS_HEAD); 
?>
<h2><?php echo Yii::t('admin','Topics and Sessions'); ?></h2>
<div class="form confadmin-topics" >
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('admin/topics',array('urn'=>$conf->urn())))); ?>
    <?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php };?>
    <p>
       <?php echo Yii::t('admin','Notes:');?>
        <ul>
    <li><?php echo Yii::t('admin','when you delete a topic/session, applications for participation of it are not removed and stored as "no topic"'); ?>;</li>
    <li><?php echo Yii::t('admin','when displaying a list of participants, topics/sessions are grouped by scientific area in the order specified on this page')?>;</li>
    <li><?php echo Yii::t('admin','when displaying a list of participants, those marked as "no topic" are visible to administartors only')?>.</li>
    </ul>
    </p>
    <p class="note"><?php echo Yii::t('validators', 'Fields with an asterisk {asterisk} are required.',
        array('{asterisk}'=>'<span class="required">*</span>'));?></p>

    <?php echo $form->errorSummary($topics); ?>
    <?php 
    foreach($topics as $i => $topic) {
        $num=$i;
        if('EmptyId'==$topic->id) {
            $num='$num';
        };
    ?>
    <div class="ordered <?php if('EmptyId'==$topic->id) {?>hidden<?php }?>" id="div<?php echo $topic->id;?>"  >
        <div class="row">
            <div class="label" ><?php echo $form->label($topic,'title',array('required'=>true,'class'=>'topicsLabel'));?></div>
            <div class="value" ><?php echo $form->textAreas($topic,"[$num]title",array('rows'=>3,'cols'=>52,'class'=>'value','tableClass'=>'value','hintClass'=>'hint'),'vertical',$conf->getLanguages());?></div>
            </div>
        <div class="row">
            <div class="label" ><?php echo $form->label($topic,'scientific_area',array('class'=>'topicsLabel'));?></div>
            <div class="value" ><?php echo $form->textFields($topic,"[$num]scientific_area",array('size'=>70,'maxlength'=>700,'class'=>'value','tableClass'=>'value','hintClass'=>'hint'),'vertical',$conf->getLanguages());?></div>
            </div>
    <?php echo $form->hiddenField($topic,"[$num]id");?>
    <?php echo $form->hiddenField($topic,"[$num]state",array('id'=>'state' . $topic->id));?>
        <div class="actions right">
            <a href="javascript:void(0)" onclick="hideTopic(this);"  class="link"><?php echo Yii::t('actions','delete')?></a>
            <a href="javascript:void(0)" onclick="moveUpTopic(this);" class="link" ><?php echo Yii::t('actions','move up')?></a>
        </div>
    </div>
    <?php }?>
    <div class="actions right">
        <a href="javascript:void(0)" onclick="createTopic();" class="link"><?php echo Yii::t('actions','add')?></a>
        <?php echo CHtml::submitButton(Yii::t('actions','Save'),array('onclick' => "this.disabled=true;this.form.submit();")); ?>
    </div>
<?php $this->endWidget(); ?>
</div>