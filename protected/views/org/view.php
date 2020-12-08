<?php
/**
 *  @var $this OrgController
 *  @var $org a Org 
 */
$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - ' . CHtml::encode($org->name());
$this->breadcrumbs=array(
        Yii::t('orgs','Organizations')=>array('org/list'), 
        StringUtils::cutOnWord($org->name())
);
?>
<?php if(Yii::app()->user->checkAccess("modifyOrg")){?>
<div class="edit-link" >
    <?php echo CHtml::link(Yii::t('actions','edit'), array('org/edit','urn'=>$org->urn()));?>
</div>
<?php }; ?>
<h1><?php echo CHtml::encode($org->name());?></h1>
<div class="form org-view" >
    <?php if(Yii::app()->user->hasFlash('saved')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('saved');?>
    </div>
    <?php }?>
    <?php $logo=$org->getFile('logo');?>
    <?php if($logo) {?>
    <div class="img" >
            <?php echo CHtml::image($logo->url(),CHtml::encode(Yii::t('orgs','Logo')),array('width'=>150));?>
    </div>
    <?php }?>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($org,'address');?></div>
        <div class="value"><?php echo CHtml::encode($org->address());?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($org,'website');?></div>
        <div class="value" ><?php echo CHtml::link(CHtml::value($org,'website'),CHtml::value($org,'website'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($org,'email');?></div>
        <div class="value"><?php echo StringUtils::hideEmail(CHtml::value($org,'email'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($org,'phone');?></div>
        <div class="value" ><?php echo CHtml::encode(CHtml::value($org,'phone'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($org,'fax');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($org,'fax'));?>&nbsp;</div>
    </div>      
</div>
<br class="clear" />
<div class="actions right">
    <?php if(($org->confCount==0) && (Yii::app()->user->checkAccess("modifyOrg"))){?>
        <?php echo CHtml::beginForm($this->createUrl('org/delete',array('urn'=>$org->urn()))); ?>
        <?php echo CHtml::submitButton(Yii::t('actions','Delete'),array('name'=>'delete','onclick'=>'return confirm("'.Yii::t('actions','Delete').'?");')); ?>
        <?php echo CHtml::endForm(); ?>
    <?php }?>
</div>
<?php if($confs=$org->currentConfs) {?>
<div class="form org-view" >
       <h2><?php echo Yii::t('confs','Current Conferences');?></h2>
        <?php foreach($confs as $conf){?>
        <div class="row" >
            <span class="conf-name" ><?php echo CHtml::link(CHtml::encode($conf->title()), array('conf/view','urn'=>$conf->urn()));?></span><br />
            <?php  $subject=trim($conf->subject());
            if(!empty($subject)) {
                echo CHtml::encode($subject).'<br />';
            }
            ?>
            <?php echo Yii::app()->locale->dateFormatter->formatDateTime($conf->start_date,'long',NULL);
            if($conf->end_date && $conf->end_date!=$conf->start_date) {
                echo ' – ' . Yii::app()->locale->dateFormatter->formatDateTime($conf->end_date,'long',NULL);
            }?><br />
        </div>
         <?php }?>
</div>       
<?php }?>
<?php if($confs=$org->recentConfs) {?>
<div class="form org-view" >
<h2><?php echo Yii::t('confs','Past Conferences');?></h2>
        <?php foreach($confs as $conf){?>
        <div class="row" >
        <span class="conf-name"><?php echo CHtml::link(CHtml::encode($conf->title()), array('conf/view','urn'=>$conf->urn()));?></span><br />
            <?php  $subject=trim($conf->subject());
            if(!empty($subject)) {
                echo CHtml::encode($subject).'<br />';
            }
            ?>
            <?php echo Yii::app()->locale->dateFormatter->formatDateTime($conf->start_date,'long',NULL);
            if($conf->end_date && $conf->end_date!=$conf->start_date) {
                echo ' – ' . Yii::app()->locale->dateFormatter->formatDateTime($conf->end_date,'long',NULL);
            }?><br />
        </div>
        <?php }?>
</div>
<?php }?>

