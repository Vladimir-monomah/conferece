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
        Yii::t('confs','General Information')
);
?>
<h2><?php echo Yii::t('confs','General Information'); ?></h2>
<div class="form conf-info" >
    <?php if(Yii::app()->user->hasFlash('confSaved')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('confSaved');?>
    </div>
    <?php }?>
   <?php $logo=$conf->getFile('logo');?>
    <?php if($logo) {?>
    <div class="img" >
            <?php echo CHtml::image($logo->url(),CHtml::encode(Yii::t('confs','Logo')));?>
    </div>
    <?php }?>
    
    <?php if(!empty($conf->start_date)) {?>
    <div class="row" >
            <?php if($conf->start_date==$conf->end_date) {?>
        <div class="label"  ><?php echo CHtml::label(Yii::t('confs','Conference Date'),false);?></div>
        <div class="value" ><?php echo Yii::app()->locale->dateFormatter->formatDateTime($conf->start_date,'long',NULL);?></div>
                <?php }else {?>
        <div class="label" ><?php echo CHtml::label(Yii::t('confs','Conference Dates'),false);?></div>
        <div class="value" ><?php echo Yii::app()->locale->dateFormatter->formatDateTime($conf->start_date,'long',NULL) .' – '.Yii::app()->locale->dateFormatter->formatDateTime($conf->end_date,'long',NULL);?></div>
                <?php } ?>
    </div>
        <?php }?>
    <?php if(!empty($conf->registration_end_date)) {?>
    <div class="row" >
        <div class="label" ><?php echo CHtml::label(Yii::t('confs','Registration Due Date'),false);?></div>
        <div class="value" ><?php echo Yii::app()->locale->dateFormatter->formatDateTime($conf->getRegistrationEndDate(),'long',NULL);?></div>
    </div>
        <?php }?>
    <?php if(!empty($conf->submission_end_date)) {?>
    <div class="row" >
        <div class="label"  ><?php echo CHtml::label(Yii::t('confs','Paper Submission Due Date'),false);?></div>
        <div class="value"  ><?php echo Yii::app()->locale->dateFormatter->formatDateTime($conf->getSubmissionEndDate(),'long',NULL);?></div>
    </div>
        <?php }?>
    <?php $place=$conf->place();
    if(!empty($place)) {?>
    <div class="row" >
        <div class="label"  ><?php echo CHtml::activeLabel($conf,'place');?></div>
        <div class="value" ><?php echo CHtml::encode($place);?>&nbsp;</div>
    </div>
        <?php } ?>
    <?php if(!empty($conf->website)) {?>
    <div class="row" >
        <div class="label"  ><?php echo CHtml::activeLabel($conf,'website');?></div>
        <div class="value"  ><?php echo CHtml::link(CHtml::value($conf,'website'),$conf->website());?>&nbsp;</div>
    </div>
        <?php }?>
    <?php if(!empty($conf->email)) {?>
    <div class="row" >
        <div class="label"  ><?php echo CHtml::activeLabel($conf,'email');?></div>
        <div class="value" ><?php echo StringUtils::hideEmail(CHtml::value($conf,'email'));?>&nbsp;</div>
    </div>
        <?php }?>
    <?php if(!empty($conf->phone)) {?>
    <div class="row" >
        <div class="label"  ><?php echo CHtml::activeLabel($conf,'phone');?></div>
        <div class="value"  ><?php echo CHtml::encode(CHtml::value($conf,'phone'));?>&nbsp;</div>
    </div>
        <?php }?>
    <?php $infoLetter=$conf->getFile('info_letter');?>
    <?php if($infoLetter) {?>
    <div class="row" >
        <div class="label"  ><?php echo CHtml::activeLabel($conf,'infoLetter');?></div>
        <div class="value" ><?php echo CHtml::link(CHtml::encode(Yii::t('actions','download')),$this->createUrl('conf/letter',array('urn'=>$conf->urn())));?><?php echo ' ('.$infoLetter->sizeStr().')'?></div>
    </div>
        <?php }?>
    
    <?php if($orgs=$conf->orgs) {?>
    <div class="row" >
        <br />
        <?php echo CHtml::activeLabel($conf,'orgs');?><br />
        <ul>
                <?php foreach($orgs as $org) {?>
            <li> <?php if($org->isEnabled()) {?>
                <a href="<?php echo $this->createUrl('org/view',array('urn'=>$org->urn()));?>" >
                    <?php $suborg = $org->sub_org(); if(trim($suborg)) { echo $suborg .', '; };?>
                            <?php  echo  $org->name();?>
                    <?php if($org->shortName()) { echo ' ('.$org->shortName() .') '; };?>
                 </a>
                            <?php } else { ?>
            <?php $suborg = $org->sub_org(); if(trim($suborg)) {
                            echo $org->sub_org() .', ';
            };?>
            <?php  echo  $org->name();?>
                <?php if($org->shortName()) { echo ' ('.$org->shortName() .') '; };?>
            </li>
                <?php }
    }
    ?>
        </ul>
    </div>
        <?php }?>
    <?php if($conf->description()) {?>
    <div class="row" >
            <?php echo $conf->description();?>
    </div>
        <?php }?>
    <?php if($conf->fee()) {?>
    <div class="row" >
            <?php echo CHtml::activeLabel($conf,'fee');?><br />
            <?php echo $conf->fee();?>
    </div>
        <?php }?>
<?php if($conf->accommodation()) {?>
    <div class="row" >
    <?php echo CHtml::activeLabel($conf,'accommodation');?><br />
    <?php echo $conf->accommodation();?>
    </div>
    <?php }?>

</div>



