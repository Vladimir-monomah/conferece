<?php
/**
 *  @var $this   ConfController
 *  @var $conf   Conf
 *  @var $topics array of Topic
 *  @var $topic    ConfTopics
 *  @var $participants array of Participant
 *  @var $publishedHint
 *  @var $showPublished
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/view','urn'=>$conf->urn()),
        Yii::t('participants','Participants')=>array('participant/list','urn'=>$conf->urn()),
        StringUtils::cutOnWord($topic->title())
);
$baseUrl = '';
if(Yii::app()->theme){ $baseUrl = Yii::app()->theme->baseUrl; };
?>
<?php 
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['HtmlUrl'] = $this->createUrl('export/html',array('urn'=>$conf->urn(),'topic_id'=>$topic->id));
    $jsParams['ExportUrls'] = array(
        'zip' => $this->createUrl('export/zip',array('urn'=>$conf->urn(),'topic_id'=>$topic->id)),
        'excel' => $this->createUrl('export/excel',array('urn'=>$conf->urn(),'topic_id'=>$topic->id)),
        'dspace' => $this->createUrl('export/dspace',array('urn'=>$conf->urn(),'topic_id'=>$topic->id)),
        'program' => $this->createUrl('export/program',array('urn'=>$conf->urn(),'topic_id'=>$topic->id)),
        'authors' => $this->createUrl('export/authors',array('urn'=>$conf->urn(),'topic_id'=>$topic->id))
    );
    $jsParams['ParamsSign'] = '&'; 
    $jsParams['ConfUrn'] = $conf->urn(); 
    $jsParams['MinsMsg'] = Yii::t('participants','mins');;
    $jsParams['SecsMsg'] = Yii::t('participants','secs');;
    $jsParams['DownloadFileMsg'] = Yii::t('participants','Download file');;
    $jsParams['FileIsBeingPreparedMsg'] = Yii::t('participants','File is being prepared, it will take some time ...');;
    $jsParams['ErrorMsg'] = Yii::t('participants','An error occured. Please contact the site administrator.');
    $jsParams['NothingToExportMsg'] = Yii::t('participants','There is nothing to export.'); 
    Yii::app()->clientScript->registerScript('js.participant.admintopiclist.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/participant/export.js?v=5', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/chosen-1.8.2/chosen.jquery.js', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerCssFile('/js/chosen-1.8.2/chosen.css?v=1');
?>
<script type="text/javascript">
  $(function() {       
     $(".chosen-select").chosen({disable_search_threshold: 100});   
  });
</script>
<h2><?php echo $topic->title();?></h2>
<div class="form participant-admintopiclist" >
     <?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php };?>
    
    <div class="row admin-row">
    <h3><?php echo Yii::t('participants','Topic export');?></h3>
    <p>
      <?php
        $options = array('all'=>Yii::t('participants','All'),'published'=>Yii::t('participants','Published'),'accepted'=>Yii::t('participants','Accepted'));
        if(!$showPublished){
            unset($options['published']);
        };
      ?>
      <?php echo CHtml::radioButtonList('export-radio','all',$options,array('separator'=>'&nbsp;','labelOptions'=>array('class'=>'radioLabel')));?>
    </p>
     <p id="export-links">
         <?php echo CHtml::link('html', $this->createUrl('export/html',array('urn'=>$conf->urn(),'topic_id'=>$topic->id)), array('id' => 'html-export','class'=>'link')); ?>
         <?php echo CHtml::link('zip','javascript:void(0);',array('id' => 'zip-export','class'=>'link'));?>
         <?php echo CHtml::link('excel','javascript:void(0);',array('id' => 'excel-export','class'=>'link'));?>
         <?php echo CHtml::link('dspace', 'javascript:void(0);',array('id' => 'dspace-export','class'=>'link'));?>
         <?php echo CHtml::link(Yii::t('participants','program'), 'javascript:void(0);', array('id' => 'program-export','class'=>'link')); ?>
          <?php echo CHtml::link(Yii::t('participants','authors'),'javascript:void(0);',array('id' => 'authors-export','class'=>'link'));?>
     </p>
     <?php if($showPublished){?><span class="hint"><?php echo $publishedHint;?><br/></span><?php };?>
     </div>
    <?php if($topic->id == 0){ ?>
        <p><span class="hint">
        <?php echo Yii::t('admin', 'If you want to publish a list of members, not belonging to any topic, do a special topic (for example, "Attendees") and move them there.');?>
        </span></p>
    <?php };?>
    <?php if(count($participants)==0){
            echo Yii::t('participants','Not found any participant.');
          } else { ?>
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('participant/topicList',array('urn'=>$conf->urn(),'topic_urn'=>$topic->urn())))); ?>
        <div class="row" >
             <?php echo $form->label($topic,'place',array('class'=>'left'));  ?>
              <?php echo $form->textFields($topic,'place',array('size'=>80,'maxlength'=>200,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages());?>
        </div>
        <table class="table" >
            <tr>
                <th class="right" >&nbsp;</th>
                <th class="center" ><?php echo Yii::t('participants','Participant');?></th>
                <th class="center"  ><?php echo Yii::t('participants','Participation Type');?></th>
                <?php if($showSpeaker){?>
                <th class="center" ><?php echo Yii::t('participants','Speaker');?></th>
                <?php }; ?>
                <th class="center" ><?php echo Yii::t('participants','Status');?></th>
                <th class="center" ><?php echo Yii::t('participants','Accommodation');?></th>
                <th class="center" ><?php echo Yii::t('participants','Select');?></th>
            </tr>
        <?php
        
        $dateFormat = DateUtils::JuiDateFormat();
        $timeFormat = DateUtils::JuiTimeFormat();
        Yii::import('application.widgets.CJuiDateTimePicker.CJuiDateTimePicker');
        
        for($i=0; $i< count($participants);$i++) {
            $participant=$participants[$i];
            ?>
            <tr class="ordered">
               <td class="right" ><?php echo ($i+1);?></td>
               <td >                  
        <?php echo $participant->authorNames();
             if($participant->hasFile('content')){
                            echo '&nbsp;' .CHtml::image($baseUrl . '/images/attachment.gif');
                            };
             $user=$participant->user();
             if($user!=NULL) {
                  echo '&nbsp;' . CHtml::link(CHtml::image($baseUrl . '/images/user.jpg','Информация пользователя',array('height'=>'16')),$this->createUrl('user/view',array('id'=>$user->id)));
             }
             ?><br />
        <?php
            $titles=array();
            $emptyTitle=true;
            foreach($conf->getLanguages() as $language => $name) {
            $title=$participant->title($language);
            if(empty($title) || in_array($title, $titles)) {
                continue;
            };
            $emptyTitle=false;
            array_push($titles, $title);
        ?>
            <?php echo CHtml::link(StringUtils::stripTags($title),$this->createUrl('participant/view',array('urn'=>$conf->urn(),'participant_urn'=>$participant->urn()))); ?><br />
        <?php }?>
         <?php if($emptyTitle){?>
                     <?php echo CHtml::link(Yii::t('participants','Untitled'),$this->createUrl('participant/view',array('urn'=>$conf->urn(),'participant_urn'=>$participant->urn()))); ?><br />
         <?php };?>   
         
         <div style="width:14em;padding-top: 1em;">
                      <?php echo $form->hiddenField($participant, "[$i]id");?>
                     <span class="hint" style="font-style:italic; "><?php echo Yii::t('confs','Delivering a report');?></span><br />
                      <span class="hint" >
                          <?php echo Yii::t('confs','Start Date');?></span>&nbsp;                
                 <?php 
              $this->widget('CJuiDateTimePicker',array(
                   'model'=>$participant, //Model object
                   'attribute'=>"[$i]startDate", //attribute name
                   'mode'=>'date', //use "time","date" or "datetime" (default)
                   'language'=> Yii::app()->getLanguage(),
                   'options'=>array(
                       'changeYear'=>true,
                       'dateFormat'=>$dateFormat,
                       'timeFormat' => $timeFormat,
                       'timeText'=> Yii::t('confs','Time'),
		       'hourText' => Yii::t('confs','Hour'),
		       'minuteText' => Yii::t('confs','Minute')),
                   'htmlOptions'=>array('size'=>10, 'maxlength'=>10)
               ));
              ?>  
                   <br />       
                   <div  >
                      <span class="hint" ><?php echo Yii::t('participants','Start Time');?></span>&nbsp;                
                 <?php 
              $this->widget('CJuiDateTimePicker',array(
                   'model'=>$participant, //Model object
                   'attribute'=>"[$i]startTime", //attribute name
                   'mode'=>'time', //use "time","date" or "datetime" (default)
                   'language'=> Yii::app()->getLanguage(),
                   'options'=>array(
                       'changeYear'=>true,
                       'dateFormat'=>$dateFormat,
                       'timeFormat' => $timeFormat,
                       'timeOnlyTitle' => Yii::t('confs','Choose Time'),
                       'currentText' => Yii::t('confs','Now'),
                       'timeText'=> Yii::t('confs','Time'),
		       'hourText' => Yii::t('confs','Hour'),
		       'minuteText' => Yii::t('confs','Minute')),
                   'htmlOptions'=>array('size'=>5, 'maxlength'=>5)
               ));
              ?>    
                    </div>
                      </div>
        </td>
        <td class="center" ><?php echo $participant->participationType();?></td>
         <?php if($showSpeaker){ echo '<td class="center">';
                $speaker=$participant->speaker();
                if($speaker){
              ?>
              
              <?php
                $file=$speaker->getFile('image');  
                if($file && !$file->isEmpty()){
                    echo '<div>';
                    echo CHtml::image($file->thumbnail_url(),Yii::t('participants','Speaker`s photo'));
                    echo '<br /><small>'.$speaker->authorName().'</small></div>';
              ?>  
              
            <?php }} echo '</td>';}; ?> 
        <td class="center" >
            <?php 
            if($participant->status==0) {
                echo CHtml::image($baseUrl . '/images/not_ok.png',Yii::t('participants','discarded'),array('height'=>'16'));
            };
            if($participant->status==2) {
                echo CHtml::image($baseUrl . '/images/xz.png',Yii::t('participants','new'),array('height'=>'16'));
            };
            if($participant->status==1) {
                echo CHtml::image($baseUrl . '/images/go.png',Yii::t('participants','approved'),array('height'=>'16'));
            };

                ?>

        </td>
        <td class="center" >
            <?php if($participant->is_accommodation_required){ echo Yii::t('participants','needed');} else {echo '—';};?>
        </td>
        <td class="center" >
            <?php echo CHtml::checkBox('moved['.$participant->id.']');?>
        </td>
        </tr>
        <?php }?>
        </table>
        
        <div class="actions right">
          <?php echo CHtml::submitButton(Yii::t('actions','Save'),array('name'=>'save')); ?>
        </div>
        
        <div class="row admin-row" >
            <label><?php echo Yii::t('participants','Action on selected items');?></label>
            <br />
       <div class="actions right">
          <?php echo CHtml::submitButton(Yii::t('actions','Delete'),array('name'=>'delete','onclick'=>'return confirm("'.Yii::t('actions','Delete').'?");')); ?>
        </div>
            
           <label><?php echo Yii::t('participants','Move selected to the other topic');?></label><br />
           <?php $data=array();
                    foreach ($topics as $_topic) {
                        if($topic->id==$_topic->id) {continue;};
                        $data[$_topic->urn()]=CHtml::encode($_topic->title());
                    }
                    ?>
                    <?php echo CHtml::dropDownList('new_topic_id','',$data, array('class'=>'value  chosen-select')); ?>

        <div class="actions right">
          <?php echo CHtml::submitButton(Yii::t('actions','Move'),array('name'=>'move')); ?>
        </div>
        </div>
    <?php $this->endWidget(); ?>
            <?php }; ?>   
</div>

