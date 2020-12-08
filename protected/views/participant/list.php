<?php
/**
 *  @var $this   ConfController
 *  @var $conf   Conf
 *  @var $topicGroups   array of TopicGroups
 *  @var $participantCount integer
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(StringUtils::cutOnWord($conf->title())=>array('participant/list','urn'=>$conf->urn()),
        Yii::t('confs','Participants'));
$baseUrl = '';
if(Yii::app()->theme){
    $baseUrl = Yii::app()->theme->baseUrl;
}
$MAX_LIST_COUNT=ParticipantController::MAX_REPORTS_COUNT;
?>
<h2><?php echo Yii::t('confs','Participants');?></h2>
<div class="form participant-list" >
    <?php
    if (!empty($msg)) {
        echo '<p>' . $msg . '</p>';
    } else {
        if (($participantCount > $MAX_LIST_COUNT)) {
            //  выводим список секций со ссылками    
            //  show list of topics with links
            ?>
            <p>
                <?php echo CHtml::link(Yii::t('participants', 'All participants'), $this->createUrl('participant/all', array('urn' => $conf->urn()))); ?>
            </p>
            
            <?php
            $groupCount = count(array_keys($topicGroups));
            foreach ($topicGroups as $i => $group) {
                $topics = $group['topics'];
                ?>
                    <?php if ($groupCount > 1) {
                        echo '<h3>' . $group['title'] . '</h3>';
                    }; ?>
                <ul class="topics">
            <?php foreach ($topics as $topic) { ?>
                        <li>   
                        <?php echo CHtml::link($topic['topic']->title(), $this->createUrl('participant/topicList', array('urn' => $conf->urn(), 'topic_urn' => $topic['topic']->urn())));
                        echo '&nbsp;(' . $topic['count'] . ')';
                        ?>                                        
                        </li>
                <?php }; ?>
                </ul>
            <?php }; ?>
        <?php } else if ($participantCount <= $MAX_LIST_COUNT) { 
             
            ?>  
            
            <table class="table" >
                <?php
                    $columns=2;
                if($showSpeaker){ 
                    $columns=3;?>
                <tr >
                <th >&nbsp;</th>
                <th ><?php echo Yii::t('participants','Participant');?></th>
                
                <th ><?php echo Yii::t('participants','Speaker');?></th>
                
                </tr>
                <?php };?>
            <?php
                    $sub='';
                    $groupCount = count(array_keys($topicGroups));
                    foreach ($topicGroups as $i => $group) {
                        $topics = $group['topics'];
                        ?>
                        <?php if ($groupCount > 1) { ?>
                          <?php if (!empty($group['title'])) { 
                              $sub='sub';
                           ?>
                            <tr> 
                                <th class="" colspan="<?php echo $columns; ?>"  >
                                <?php echo $group['title']; ?>
                                </th>
                            </tr>    
                          <?php }; ?>
                        <?php } ?>
                        <?php foreach ($topics as $topic) { ?>     
                            <tr> 
                                <th class="<?php echo $sub;?>" colspan="<?php echo $columns; ?>"  >
                                <?php echo $topic['topic']->title(); ?>
                                </th>
                            </tr>  
                           <?php 
                           $place=$topic['topic']->place(); 
                           if(!empty($place)){ ?>
                            <tr>
                                <td class="<?php echo $class;?> place" colspan="<?php echo $columns; ?>" >
                          <?php echo Yii::t('confs','Place');?>:&nbsp;<?php echo $place?>
                                </td>    
                            </tr>
                            <?php };?>
                        
                                <?php
                                $participants = $topic['participants'];
                                
                                for ($i = 0; $i < $topic['count']; $i++) {
                                    $participant = $participants[$i];
                                 
                                    ?>
                                <tr class="ordered">
                                    <td class="list-num" ><?php echo ($i+1).'.';?></td>
                                    <td class="list-participant" >
                                        
                                        <?php
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
              };?> 
                                    <?php                                  
                                    echo $participant->authorNames();                                 
                                    echo '<br /><span class="participation-type" >' . $participant->participationType() . '</span>';
                                    if ($participant->hasFile('content_file')) {
                                        echo '&nbsp;' . CHtml::image($baseUrl . '/images/attachment.gif');
                                    };
                                    ?><br />
                                    <?php
                                    $titles = array();
                                    $emptyTitle = true;
                                    $titlesCount = 0;
                                    foreach ($conf->getLanguages() as $language => $name) {
                                        $pageTitle = $participant->title($language);
                                        if (empty($pageTitle) || in_array($pageTitle, $titles)) {
                                            continue;
                                        };
                                        $emptyTitle = false;
                                        array_push($titles, $pageTitle);
                                        ?>
                                        <?php
                                        $titlesCount++;
                                        if ($showLinks) {
                                            echo CHtml::link(StringUtils::prepareHtml($pageTitle), $this->createUrl('participant/view', array('urn' => $conf->urn(), 'participant_urn' => $participant->urn())));
                                            ?><br />
                                            <?php
                                        } else {
                                            if($participant->isReport()){
                                                echo StringUtils::prepareHtml($pageTitle) . '<br />';
                                            };
                                        }
                                    }
                                    ?>
                    <?php
                    if ($emptyTitle === true) {
                        if ($showLinks) {
                            ?>                               
                                    <?php echo CHtml::link(Yii::t('participants', 'Untitled'), $this->createUrl('participant/view', array('urn' => $conf->urn(), 'participant_urn' => $participant->urn()))); ?>
                            <?php
                            } else {
                                echo Yii::t('participants', 'Untitled');
                            }
                            ?>
                                
                    <?php } ?></td>
                         <?php if($showSpeaker){
                             $speaker=$participant->speaker();
                             if($speaker){
                         ?>
                             <td>
                             <?php
                                $file=$speaker->getFile('image');  
                                if($file && !$file->isEmpty()){
                                    echo '<div class="img">';
                                    echo CHtml::image($file->thumbnail_url(),Yii::t('participants','Speaker`s photo'));
                                    echo '<small>'.$speaker->authorName().'</small></div>';
                             ?>  
                            </td>
                         <?php }}}; ?>          
                    </tr>
                        
                <?php }; ?>
                                            
            <?php }; ?>
            <?php if ($groupCount > 1) { ?></div><?php }; ?>            
        <?php }; ?>
    <?php }; ?> 
                </table>
    <?php }; ?>   
</div>

