<?php
/**
 *  @var $this   ConfController
 *  @var $conf   Conf
 *  @var $showWithPaperLink boolean
 *  @var $showWOPaperLink boolean
 *  @var $userApplications array of ParticipantView
 *  @var $registrationFinished boolean
 */
?>
<?php include 'header.inc';?>
<?php
    $this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title()) => array('conf/view','urn'=>$conf->urn()),
        Yii::t('confs','Registration')
    );
?>
<h2><?php echo Yii::t('confs','Registration'); ?></h2>
<div class="form participant-application" >
    <?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('success');?>
    </div>
    <?php };?>
    <?php if($registrationFinished) { ?>
    <p><?php echo Yii::t('confs','Registration is closed.'); ?></p>
    <?php } else { ?>
    <h3><?php echo Yii::t('participants','Submit participation request');?></h3>
    <ul>
        <?php if($showWithPaperLink){ ?>
        <li>
        <?php echo CHtml::link(Yii::t('participants','with paper'),$this->createUrl('participant/submitReport',array('urn'=>$conf->urn()))); ?>
        <br>
       </li>
        <?php }; ?>
        <?php if($showWOPaperLink){ ?>
        <li>
        <?php echo CHtml::link(Yii::t('participants','without paper'),$this->createUrl('participant/submitApplication',array('urn'=>$conf->urn()))); ?>
        </li>
        <?php };?>
     </ul>
    <?php } ;?>
    <?php if ( !empty($userApplications) ) { ?>
    <p class="note">
    <?php echo Yii::t('participants','You have already applied to participate in this conference.');?>
    </p>
    <h3><?php echo Yii::t('participants','Your applications');?></h3>
    <table class="table">
        <tr>
            <th ><?php echo Yii::t('participants','Title');?></th>
            <th ><?php echo Yii::t('participants','Authors');?></th>
            <th ><?php echo Yii::t('participants','Participation Type');?></th>
        </tr>
    <?php foreach($userApplications as $i => $participant) {?>
      <tr class="ordered" >
         <td  >
          <?php
            $_conf=$participant->conf();
            if($_conf){
            $titles=array();
            $emptyTitle=true;
            $titlesCount=0;         
            foreach($_conf->getLanguages() as $language => $name) {
            $title=$participant->title($language);
            if(empty($title) || in_array($title, $titles)) {
                continue;
            };
            $emptyTitle=false; 
            array_push($titles, $title);
        ?>
            <?php
            if($titlesCount>0){
                echo '<br />';
            };
            $titlesCount++; ?>
           
         <?php  echo CHtml::link(StringUtils::prepareHtml($title),$this->createUrl('participant/view',array('urn'=>$_conf->urn(),'participant_urn'=>$participant->urn()))); ?>
             
        <?php }?>
             <?php if($emptyTitle===true){?>
               
               <?php echo CHtml::link(Yii::t('participants','Untitled'),$this->createUrl('participant/view',array('urn'=>$_conf->urn(),'participant_urn'=>$participant->urn()))); ?>
                  
            <?php } 
             } else { ?>
             
             <?php
                 $title=$participant->title();
                 echo $title;   ?>
                  
             <?php };?>                  
         </td>
         <td ><?php echo $participant->authorNames();?></td>
         <td ><?php echo $participant->participationType();?></td>        
      </tr>
     <?php }?>
     </table>
    <?php };?>
</div>
