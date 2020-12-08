<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 *  @var $confPage ConfPage
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/' . $confPage->urn, 'urn' => $conf->urn()),
        $confPage->title()
);
?>
<h2><?php echo  $confPage->title(); ?></h2>
<div class="form conf-section" >
    <?php if(Yii::app()->user->hasFlash('confSaved')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('confSaved');?>
    </div>
    <?php }?>
    <?php if($confPage->content()) {?>
    <div class="row" >
            <?php echo $confPage->content();?>
    </div>
    <?php }else { ?>
    <div class="admin-note"><?php echo Yii::t('confs','The page is empty now and is visible to the conference administrator only.');?></div>
    <?php }?>
</div>

