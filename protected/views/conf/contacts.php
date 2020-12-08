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
        Yii::t('confs','Contacts')
);
?>
<h2><?php echo Yii::t('confs','Contacts'); ?></h2>
<div class="form conf-contacts" >
    <?php if(Yii::app()->user->hasFlash('confSaved')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('confSaved');?>
    </div>
    <?php }?>
    <?php $content = $conf->address() . $conf->phone . $conf->fax . $conf->email . $conf->contacts() ;?>
    <?php if(!empty($content)){?>
    <?php if($conf->address()) {?>
    <div class="row" >
        <div class="label"  ><?php echo CHtml::activeLabel($conf,'address');?></div>
        <div class="value"  ><?php echo CHtml::encode($conf->address());?>&nbsp;</div>
    </div>
    <?php }?>
    <?php if(!empty($conf->phone)) {?>
    <div class="row" >
        <div class="label"  ><?php echo CHtml::activeLabel($conf,'phone');?></div>
        <div class="value"  ><?php echo CHtml::encode(CHtml::value($conf,'phone'));?>&nbsp;</div>
    </div>
        <?php }?>
    <?php if(!empty($conf->fax)) {?>
    <div class="row" >
        <div class="label"  ><?php echo CHtml::activeLabel($conf,'fax');?></div>
        <div class="value" ><?php echo CHtml::encode(CHtml::value($conf,'fax'));?>&nbsp;</div>
    </div>
        <?php }?>
    <?php if(!empty($conf->email)) {?>
    <div class="row" >
        <div class="label"  ><?php echo CHtml::activeLabel($conf,'email');?></div>
        <div class="value" ><?php echo StringUtils::hideEmail(CHtml::value($conf,'email'));?>&nbsp;</div>
    </div>
    <?php }?>
    <?php if($conf->contacts()) {?>
    <div class="row" >
      <?php echo StringUtils::prepareHtml($conf->contacts());?>
    </div>
    <?php } ?>
    <?php } else { ?>
    <div class="admin-note"><?php echo Yii::t('confs','The page is empty now and is visible to the conference administrator only.');?></div>
    <?php }?>
</div>
