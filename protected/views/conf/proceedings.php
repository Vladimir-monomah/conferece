<?php
/**
 *  @var $this ConfController
 *  @var $conf ConfView
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/info','urn'=>$conf->urn()),
        Yii::t('confs','Conference Proceedings')
);
$file=$conf->getFile('proceedings');
?>
<h2><?php echo Yii::t('confs','Conference Proceedings'); ?></h2>
<div class="form conf-proceedings" >
    <?php if(Yii::app()->user->hasFlash('confSaved')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('confSaved');?>
    </div>
    <?php }?>
    <?php if($file && !$file->isEmpty()) {?>
    <div class="row" >
        <?php echo  CHtml::link(Yii::t('confs','Download proceedings'),Yii::app()->getBaseUrl(true).$file->url());?>       
    </div>
    <?php }else { ?>
    <div class="admin-note"><?php echo Yii::t('confs','The page is empty now and is visible to the conference administrator only.');?></div>
    <?php }?>
</div>

