<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 *  @var $mailing MailingForm
 *  $var $tasks MailTask
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/info','urn'=>$conf->urn()),
        Yii::t('admin','Administration')=>array('admin/settings','urn'=>$conf->urn()),
        Yii::t('admin','Mailing')
);
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['Language'] = Yii::app()->language;
    $jsParams['MediaEnabled'] = false;
    Yii::app()->clientScript->registerScript('js.mailing.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/tinymce_4.1.9/tinymce.min.js');
    Yii::app()->clientScript->registerScriptFile('/js/common/attachTinymce.js?v=6', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/admin/mailing.js?v=1', CClientScript::POS_HEAD); 
?>
<h2><?php echo Yii::t('admin','Mailing'); ?></h2>
<div class="form confadmin-mailing" > 
    <p class="note" >
      <ul>  
      <?php echo Yii::t('admin','Notes:'); ?>
        <?php if ($mailing->participant == NULL) { ?>
      <li><?php echo Yii::t('admin','The message will be sent within a day after the form is submitted (depending on the number of E-mails).');?></li>
        <?php }; ?>
      <li><?php echo Yii::t('admin', 'A common letter is sent to the authors of one application for participation.');?></li> 
      <li><?php echo Yii::t('admin', 'Authors who do not have an E-mail address or a specified address is not correct will be excluded from the mailing list.');?></li>  
      <li><?php echo Yii::t('admin','See the message status in the mailing queue below.');?></li>
      </ul>
    </p>     
    <?php 
        $params = array('urn' => $conf->urn());
        if ($mailing->participant != NULL) {
               $params['participant_id'] = $mailing->participant->id; 
        };
        $form = $this->beginWidget('ActiveForm',array('action'=>$this->createUrl('admin/mailing', $params))); 
    ?>
    <?php echo $form->errorSummary($mailing); ?>
    <?php if ($mailing->participant == NULL) {?>
    <div class="row" >
            <?php echo $form->label($mailing,'recipients',array('class'=>'left'));?><br >
            <?php
              $data = array();
              $data[MailingForm::RECIPIENTS_ALL] = Yii::t('admin','all authors');
              $data[MailingForm::RECIPIENTS_APPROVED] = Yii::t('admin','authors of the approved applications for participation');
              $data[MailingForm::RECIPIENTS_SELECTIVE] = Yii::t('admin','selective mailing') . '&nbsp;(' . CHtml::link(Yii::t('admin','select recipients'), $this->createUrl('admin/recipients', array('urn'=>$conf->urn())), array('class'=>'link recipients-link')) . ')'; 
            ?>
            <?php echo $form->radioButtonList($mailing, 'recipients', $data, array('separator'=>'<br />','labelOptions'=>array('class'=>'radioLabel')));?><br>
    </div>
    <?php } else { ?>
    <div class="row" >
            <?php 
                $mailing->recipients = MailingForm::RECIPIENTS_ONE;
                echo $form->hiddenField($mailing, 'recipients'); 
            ?> 
            <?php echo $form->label($mailing,'recipients',array('class'=>'left'));?><br >
            <?php echo Yii::t('admin', 'authors of the application for participation');?> "<?php echo CHtml::link(Yii::t('actions', $mailing->participant->shownTitle()), $this->createUrl('participant/view',array('urn'=>$conf->urn(),'participant_urn'=>$mailing->participant->urn())));?>":<br />
            <?php echo $mailing->getParticipantRecipients();?>
    </div>        
    <?php }; ?>
    <div class="row">
        <?php echo $form->label($mailing,'emailFrom');?><br >
        <?php echo $mailing->emailFrom; ?>
    </div>
    <div class="row">
        <?php echo $form->label($mailing,'subject');?><br >
        <?php echo $form->textField($mailing,'subject',array('size'=>'100','class'=>'value'));?>
    </div>
    <div class="row">
        <?php echo $form->label($mailing,'message');?><br >
        <?php echo $form->textArea($mailing,'message',array('cols'=>'76','rows'=>'6','class'=>'editor value'));?>
    </div>
    <div class="actions right">
        <?php echo CHtml::submitButton(Yii::t('actions','Send'),array('name'=>'send','onclick'=>'return confirm("'.Yii::t('actions','Send').'?");')); ?>
    </div>
    <?php $this->endWidget(); ?>
   
   <?php if(count($tasks)>0){?>
   <hr />
   <h3><?php echo Yii::t('admin','Mailing queue');?></h3>
   <?php foreach($tasks as $task){ ?>
   <div class="row ordered" >    
       <label><?php echo Yii::t('admin','Subject');?>:</label>&nbsp;<?php echo $task->subject ;?><br >
       <label><?php echo Yii::t('admin','Message');?>:</label>
       <p><?php echo $task->body ;?></p>    
       <label><?php echo $form->label($mailing,'emailFrom');?>:</label>&nbsp;<?php echo $mailing->emailFrom; ?><br />
       <label><?php echo Yii::t('admin','Recipients');?>:</label>&nbsp;
           <?php 
            echo $task->recipientsStr(); 
                $detailed = $task->recipientsDetailedStr();
                if ($detailed) {
           ?> 
            &nbsp;<?php echo CHtml::link(Yii::t('admin', 'detailed'), '#', array('onclick' => 'showHideDiv("' . 'task_info_' . $task->id . '",this);return false;')); ?>
            <div id="task_info_<?php echo $task->id?>" style="display: none"><?php echo $detailed;?></div>
           <?php } ?><br /> 
       <?php if($task->status==MailTask::STATUS_COMPLETED){?> 
       <?php 
            $detailed = $task->recipientsResultStatisticsHtml(); 
            if ($detailed) {
       ?>
       <label><?php echo Yii::t('admin','Mailing statistics');?>:</label>    
            &nbsp;<?php echo CHtml::link(Yii::t('actions', 'show'), '#', array('onclick' => 'showHideDiv("' . 'mail_stat_info_' . $task->id . '",this);return false;')); ?>
            <div id="mail_stat_info_<?php echo $task->id?>" style="display: none"><?php echo $detailed;?></div>  
       <?php } ?>  
       <br />    
       <?php }?>
       <label><?php echo Yii::t('admin','Status');?>:</label>&nbsp;<?php echo Yii::t('admin',$task->status) ;?><br />
       <label><?php echo Yii::t('admin','Creation Date');?>:</label>&nbsp;
        <?php 
        if(empty($task->creation_date)){
           echo '&nbsp;';
        }else {
           echo Yii::app()->locale->dateFormatter->formatDateTime($task->creation_date,'long','medium'); 
        };
       ;?><br />
       <label><?php echo Yii::t('admin','Completion Date');?>:</label>&nbsp;
        <?php 
        if(empty($task->completion_date)){
           echo '&nbsp;';
        }else {
           echo Yii::app()->locale->dateFormatter->formatDateTime($task->completion_date,'long','medium'); 
        };
       ?><br />
       <?php if($task->status==MailTask::STATUS_NEW){?> 
        <?php 
            $params = array('urn' => $conf->urn());
            if ($mailing->participant != NULL) {
               $params['participant_id'] = $mailing->participant->id; 
            };
            $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('admin/mailing', $params))); ?>  
        <?php echo $form->hiddenField($task,'id'); ?>
        <div class="actions right">
          <?php echo CHtml::submitButton(Yii::t('actions','Delete'),array('name'=>'delete','onclick'=>'return confirm("'.Yii::t('actions','Delete').'?");')); ?>
        </div>
        <?php $this->endWidget(); ?> 
        <?php };?>
   </div>
  <?php }?>
  <?php };?> 
</div>
