<?php
/**
 *  @var $this SiteController 
 *  @var $page SitePage 
 */

$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - '.Yii::t('site','About');
$this->breadcrumbs=array(
        Yii::t('site','About'),
);
?>
<?php if(Yii::app()->user->checkAccess("admin")) { ?>
<div class="edit-link">
    <?php echo CHtml::link(Yii::t('actions','edit'),$this->createUrl('site/editAbout'));?>
</div>
<?php }; ?>
<h1><?php echo $page->title();?></h1>
<div class="site-about">
    <?php if(Yii::app()->user->hasFlash('saved')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('saved');?>
    </div>
    <?php }?>
    <?php echo $page->content();?>  
</div>    




