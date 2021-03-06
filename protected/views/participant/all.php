<?php
/**
 *  @var $this   ConfController
 *  @var $conf   Conf
 *  @var $participants array of Participant
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/view','urn'=>$conf->urn()),
     Yii::t('confs','Reports')=>array('participant/list','urn'=>$conf->urn()),
    Yii::t('participants','All participants')
    );
$baseUrl = '';
if(Yii::app()->theme){
    $baseUrl = Yii::app()->theme->baseUrl;
}
?>
<h2><?php echo Yii::t('participants','All participants'); ?></h2>
<div class="form participant-all" >
        <?php if(!empty($msg)){ 
            echo '<p>'.$msg.'</p>';
        }else { 
            ?>
        <table class="table">
            <tr>
                <th class="right" >&nbsp;</th>
                <th class="center" ><?php echo Yii::t('participants','Participant');?></th>
                <?php if($showSpeaker){?>
                <th ><?php echo Yii::t('participants','Speaker');?></th>    
                <?php };?>
            </tr>
        <?php
        for($i=0; $i< count($participants);$i++) {
            $participant=$participants[$i];
            ?>
                <tr class="ordered" >
                    <td class="right" ><?php echo ($i+1);?></td>
                    <td class="top" >                      
                        <?php 
                        if($conf->topicCount==0){
               $startDate=$participant->getStartDate();
               $startTime=$participant->getStartTime();
               
               if(!empty($startDate) || !empty($startTime) ){
                   $dateStr=Yii::app()->locale->dateFormatter->formatDateTime($participant->start_date,'long',NULL);
                   if(!empty($startTime)){
                       if(!empty($dateStr)){
                            $dateStr.=',&nbsp;'.$startTime;
                       }else{
                           $dateStr=$startTime;
                       }
                   }
                   echo '<div class="start-time" ><span class="start-time" >'. Yii::t('participants','Date and time of the report').':&nbsp;'. $dateStr  .'</span></div>';
                        };};?> 
                        
        <?php 
             echo $participant->authorNames();            
             echo '<br /><span class="participation-type" >' . $participant->participationType() .'</span>'; ?>
             <?php if($participant->hasFile('content_file')){
                            echo '&nbsp;' .CHtml::image($baseUrl . '/images/attachment.gif');}; ?><br />
        <?php
            $titles=array();
            $emptyTitle=true;
            $titlesCount=0;
            foreach($conf->getLanguages() as $language => $name) {
            $title=$participant->title($language);
            if(empty($title) || in_array($title, $titles)) {
                continue;
            };
            $emptyTitle=false;
            array_push($titles, $title);
        ?>
            <?php            
            $titlesCount++;
            if($showLinks){
               echo CHtml::link(StringUtils::prepareHtml($title),$this->createUrl('participant/view',array('urn'=>$conf->urn(),'participant_urn'=>$participant->urn()))).'<br />';
            }else {
                if($participant->isReport()){
                    echo StringUtils::prepareHtml($title) .'<br />';
                };
            };
         }?>
            <?php if($emptyTitle===true){?>
               <?php 
                 if($showLinks){
                   echo CHtml::link(Yii::t('participants','Untitled'),$this->createUrl('participant/view',array('urn'=>$conf->urn(),'participant_urn'=>$participant->urn()))); 
                 } else {
                   echo Yii::t('participants','Untitled');  
                 };
               ?>
           <?php }?>
             </td>
             <?php if($showSpeaker){  
                 echo '<td >'; 
                $file=$participant->speakerPhoto();  
                if($file && !$file->isEmpty()){
                    echo '<div >';
                    echo CHtml::image($file->thumbnail_url(),Yii::t('participants','Speaker`s photo'));
                    echo '<small>'.$participant->speakerName().'</small></div>';                   
                }; 
                echo '</td>';
             };?>
             </tr>
        
        <?php }?>
        </table>
        <?php };?>   
</div>
