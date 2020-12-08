<?php
/**
 *  @var $this   ConfController
 *  @var $conf   Conf
 *  @var $participants array of Participant
 *  @var $showSpeaker
 *  @var $publishedHint
 *  @var $showPublished
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/view','urn'=>$conf->urn()),
        Yii::t('participants','Participants')=>array('participant/list','urn'=>$conf->urn()),
        Yii::t('participants','All participants')
);
$baseUrl = '';
if (Yii::app()->theme) { $baseUrl = Yii::app()->theme->baseUrl;};
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['HtmlUrl'] = $this->createUrl('export/html',array('urn'=>$conf->urn()));
    $jsParams['ExportUrls'] = array(
        'zip' => $this->createUrl('export/zip',array('urn'=>$conf->urn())),
        'excel' => $this->createUrl('export/excel',array('urn'=>$conf->urn())),
        'dspace' => $this->createUrl('export/dspace',array('urn'=>$conf->urn())),
        'program' => $this->createUrl('export/program',array('urn'=>$conf->urn())),
        'authors' => $this->createUrl('export/authors',array('urn'=>$conf->urn()))
    );
    $jsParams['ParamsSign'] = '?'; 
    $jsParams['ConfUrn'] = $conf->urn(); 
    $jsParams['MinsMsg'] = Yii::t('participants','mins');
    $jsParams['SecsMsg'] = Yii::t('participants','secs');
    $jsParams['DownloadFileMsg'] = Yii::t('participants','Download file');
    $jsParams['FileIsBeingPreparedMsg'] = Yii::t('participants','File is being prepared, it will take some time ...');
    $jsParams['ErrorMsg'] = Yii::t('participants','An error occured. Please contact the site administrator.');
    $jsParams['NothingToExportMsg'] = Yii::t('participants','There is nothing to export.'); 
    Yii::app()->clientScript->registerScript('js.participant.adminall.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/participant/export.js?v=5', CClientScript::POS_HEAD); 
?>
<h2><?php echo Yii::t('participants','All participants');?></h2>
<div class="form participant-adminall" >
    <?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php };?>
    <?php 
        $file=$conf->getFile('proceedings');
        $isProceedingsFileEmpty=(($file==NULL) || $file->isEmpty());    
        if(!$isProceedingsFileEmpty){?>
       <div class="admin-note"><?php echo Yii::t('confs','This page is only visible to the administrator, because conference proceedings are uploaded.');?></div>
    <?php }?>
    
    <div class="row admin-row" >
    <h3><?php echo Yii::t('participants','Export');?></h3>    
    <p>
      <?php
        $options = array('all'=>Yii::t('participants','All'),'published'=>Yii::t('participants','Published'),'accepted'=>Yii::t('participants','Accepted'));
        if(!$showPublished){
            unset($options['published']);
        };
      ?>
      <?php echo CHtml::radioButtonList('export-radio','all',$options ,array('separator'=>'&nbsp;','labelOptions'=>array('class'=>'radioLabel')));?>
    </p>
    <p id="export-links">
         <?php echo CHtml::link('html', $this->createUrl('export/html',array('urn'=>$conf->urn())), array('id' => 'html-export', 'class'=>'link')); ?>
         <?php echo CHtml::link('zip','javascript:void(0);',array('id' => 'zip-export','class'=>'link'));?>
         <?php echo CHtml::link('excel','javascript:void(0);',array('id' => 'excel-export','class'=>'link'));?>
         <?php echo CHtml::link('dspace', 'javascript:void(0);',array('id' => 'dspace-export', 'class'=>'link'));?>
         <?php echo CHtml::link(Yii::t('participants','program'), 'javascript:void(0);', array('id' => 'program-export','class'=>'link')); ?>
         <?php echo CHtml::link(Yii::t('participants','authors'),'javascript:void(0);',array('id' => 'authors-export','class'=>'link'));?>
     </p>   
     <?php if($showPublished){ ?><span class="hint"><?php echo $publishedHint;?></span><br /><?php };?>
     </div>
     <?php if (($conf->topicCount==0)&& (Yii::app()->user->checkAccess("accessApplicationPage", array('conf_id' => $conf->id, 'user_id' => Yii::app()->user->id)))) { ?> 
       <p>
        <?php echo CHtml::link(Yii::t('participants','Add participant'), $this->createUrl('participant/application',array('urn'=>$conf->urn()))); ?>
       </p>    
     <?php };?>
    
    
    
  <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('participant/all',array('urn'=>$conf->urn())))); ?>
        <table class="table" >
            <tr>
                <th >&nbsp;</th>
                <th class="center" ><?php echo Yii::t('participants','Participant');?></th>
                <th class="center" ><?php echo Yii::t('participants','Participation Type');?></th>
                <?php if($showSpeaker){?>
                <th class="center" ><?php echo Yii::t('participants','Speaker');?></th>
                <?php };?>
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
               <td class="top">
                      
        <?php echo $participant->authorNames();
             if($participant->hasFile('content')){
                            echo '&nbsp;' .CHtml::image($baseUrl . '/images/attachment.gif');
                            };
             $user_id=$participant->user_id;
             if(!empty($user_id)) {               
                  echo '&nbsp;' . CHtml::link(CHtml::image($baseUrl . '/images/user.jpg',Yii::t('participants','User Info'),array('height'=>'16')),$this->createUrl('user/view',array('id'=>$user_id)));
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
            <?php if ($emptyTitle) {?>
               <?php echo CHtml::link(Yii::t('participants','Untitled'),$this->createUrl('participant/view',array('urn'=>$conf->urn(),'participant_urn'=>$participant->urn()))); ?><br />
            <?php };?>
               
               <?php if($conf->topicCount==0){?>   
               
                <div style="width:14em;padding-top: 1em;">
                      <?php echo $form->hiddenField($participant, "[$i]id");?>
                      <span class="hint" style="font-style:italic; "><?php echo Yii::t('confs','Delivering a report');?></span><br />
                      <span class="hint" ><?php echo Yii::t('confs','Start Date');?></span>&nbsp;                
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
                   <div >
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
                <?php }; ?> 
        </td>
        <td class="center" ><?php echo $participant->participationType();?></td>
         <?php if($showSpeaker){  
                 echo '<td>'; 
                $file=$participant->speakerPhoto();  
                if($file && !$file->isEmpty()){
                    echo '<div>';
                    echo CHtml::image($file->thumbnail_url(),Yii::t('participants','Speaker`s photo'));
                    echo '<br /><small>'.$participant->speakerName().'</small></div>';
                }; 
                echo '</td>';
             };?>
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

       <?php if($conf->topicCount==0){?> 
       <div class="actions right">
           <?php echo CHtml::submitButton(Yii::t('actions','Save'),array('name'=>'save')); ?>
       </div>
       <?php }?>
       
       <div class="row admin-row" >
            <h3><?php echo Yii::t('participants','Action on selected items');?></h3>
            <div class="actions right">
              <?php echo CHtml::submitButton(Yii::t('actions','Delete'),array('name'=>'delete','onclick'=>'return confirm("'.Yii::t('actions','Delete').'?");')); ?>
            </div>
       </div>
    <?php $this->endWidget(); ?>
</div>


