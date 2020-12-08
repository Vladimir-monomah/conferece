<?php
/**
 *  @var $this   ConfController
 *  @var $conf   Conf
 *  @var $count  integer
 *  @var $userApplications array of ParticipantView
 */
?>
<?php include 'header.inc';?>
<?php
    $this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title()) => array('conf/view','urn'=>$conf->urn()),
        Yii::t('confs','My applications')
    );
?>
<h2><?php echo Yii::t('confs','My applications'); ?></h2>
<div class="form participant-myApplications" >
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
</div>

