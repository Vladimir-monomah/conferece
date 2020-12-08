<?php
/**
 *  @var $this ConfController
 *  @var $confs list of New Conferences
 */
$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - '.Yii::t('confs','New Conferences');
$this->breadcrumbs=array(
        Yii::t('confs','New Conferences'),
);
?>
<h1><?php echo Yii::t('confs','New Conferences');?></h1>
<div class="confs-new">
    <?php foreach($confs as $i => $conf) {?>
      <div class="row" >
        <?php $linkName=CHtml::encode($conf->title());
         if(empty($linkName)){$linkName=Yii::t('confs','Untitled');};?>
        <span class="conf-name"><?php echo CHtml::link($linkName, array('conf/view','urn'=>$conf->urn()));?></span><br />
        <?php  $subject=trim($conf->subject());
           if(!empty($subject)){
            echo CHtml::encode($subject).'<br />';}
        ?>
        <?php if($conf->start_date){?>
        <?php echo Yii::app()->locale->dateFormatter->formatDateTime($conf->start_date,'long',NULL);
         if($conf->end_date && $conf->end_date!=$conf->start_date){ echo ' – ' . Yii::app()->locale->dateFormatter->formatDateTime($conf->end_date,'long',NULL);}?><br />
         <?php }?>
      </div>
     <?php }?>
</div>




