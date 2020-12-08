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
        Yii::t('confs','Conference Report')
);
?>
<h2><?php echo Yii::t('confs','Conference Report'); ?></h2>
<div class="form conf-report">
    <?php if(Yii::app()->user->hasFlash('confSaved')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('confSaved');?>
    </div>
    <?php }?>
    <?php if($conf->report()) {?>
    <div class="row" >
       <?php echo $conf->report();?>
    </div>
    <?php } else {?>
    <div class="admin-note"><?php echo Yii::t('confs','The page is empty now and is visible to the conference administrator only.');?></div>
    <?php }?>
</div>
