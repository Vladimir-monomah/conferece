<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 *  @var $appForm AppFormSettings
 *  @var $field string
 *  @var $list array of ListItem
 */
?>
<?php include 'header.inc';?>
<?php
$this->pageTitle=Yii::t('site','Editing') . ' - ' . $appForm->value($field.'_name');
$this->breadcrumbs=array(
        StringUtils::cutOnWordConf($conf->title())=>array('conf/view','urn'=>$conf->urn()),
        Yii::t('admin','Administration')=>array('admin/settings','urn'=>$conf->urn()),
        Yii::t('admin','Application Form') => array('admin/form','urn'=>$conf->urn()), 
        $appForm->value($field.'_name')
);
?>
<h2><?php echo $appForm->value($field.'_name'); ?></h2>
<div class="form confadmin-fieldList" >
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('admin/fieldList',array('urn'=>$conf->urn(),'field'=>$field)))); ?>
    <?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php };?>
    <?php echo $form->errorSummary($list); ?>
    <table class="table" >
        <tr>
            <th >&nbsp;</th>
            <th ><?php echo Yii::t('admin','List Item');?></th>
        </tr>
        <?php foreach($list as $i => $item) { ?>
        <tr class="ordered">
            <td class="right top" >
                <?php echo ($i+1);?>
            </td>
            <td >
               <?php echo $form->textFields($item,"[$i]item_value",array('size'=>80,'maxlength'=>200,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages()); ?>
            </td>
        </tr>
        <?php };?>
    </table>
    <div class="actions right">
        <?php echo CHtml::link(Yii::t('actions','return'),$this->createUrl('admin/form',array('urn'=>$conf->urn())), array('class'=>'link'));?>
        <?php echo CHtml::submitButton(Yii::t('actions','Save'),array('name'=>'save')); ?>       
    </div>
    <?php $this->endWidget(); ?>
</div>
