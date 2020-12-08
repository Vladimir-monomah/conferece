<?php
/**
 *  @var $this   ConfController
 *  @var $conf   Conf
 *  @var $topicGroups    array of TopicGroups
 *  @var $publishedHint
 *  @var $showPublished
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('participant/list','urn'=>$conf->urn()),
        Yii::t('participants','Participants')
);
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
    $jsParams['MinsMsg'] = Yii::t('participants','mins');;
    $jsParams['SecsMsg'] = Yii::t('participants','secs');;
    $jsParams['DownloadFileMsg'] = Yii::t('participants','Download file');;
    $jsParams['FileIsBeingPreparedMsg'] = Yii::t('participants','File is being prepared, it will take some time ...');;
    $jsParams['ErrorMsg'] = Yii::t('participants','An error occured. Please contact the site administrator.');
    $jsParams['NothingToExportMsg'] = Yii::t('participants','There is nothing to export.'); 
    Yii::app()->clientScript->registerScript('js.participant.adminlist.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/participant/export.js?v=5', CClientScript::POS_HEAD); 
?>
<h2><?php echo Yii::t('participants','Participants');?></h2>
<div class="form participant-adminlist" >
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
      <?php echo CHtml::radioButtonList('export-radio','all',$options,array('separator'=>'&nbsp;','labelOptions'=>array('class'=>'radioLabel')));?>
    </p>
    <p id="export-links">
         <?php echo CHtml::link('html', $this->createUrl('export/html',array('urn'=>$conf->urn())),array('id' => 'html-export','class'=>'link')); ?>
         <?php echo CHtml::link('zip','javascript:void(0);',array('id' => 'zip-export','class'=>'link'));?>
         <?php echo CHtml::link('excel','javascript:void(0);',array('id' => 'excel-export','class'=>'link'));?>
         <?php echo CHtml::link('dspace', 'javascript:void(0);', array('id' => 'dspace-export','class'=>'link')); ?>
         <?php echo CHtml::link(Yii::t('participants','program'), 'javascript:void(0);', array('id' => 'program-export','class'=>'link')); ?>
         <?php echo CHtml::link(Yii::t('participants','authors'),'javascript:void(0);',array('id' => 'authors-export','class'=>'link'));?>
     </p>
     <?php if($showPublished){ ?><span class="hint"><?php echo $publishedHint;?></span><?php };?>
     </div>
     <?php if(Yii::app()->user->hasFlash('success')){?>
     <div class="success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
     <?php };?>
     <p>
        <?php echo CHtml::link(Yii::t('participants','All participants'), $this->createUrl('participant/all',array('urn'=>$conf->urn())),array('class'=>'link')); ?>
        <?php if (Yii::app()->user->checkAccess("accessApplicationPage", array('conf_id' => $conf->id, 'user_id' => Yii::app()->user->id))) { ?> 
            <?php echo CHtml::link(Yii::t('participants','Add participant'), $this->createUrl('participant/application',array('urn'=>$conf->urn()))); ?>
        <?php };?>
     </p>
        
     <?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="successSummary"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php };?>
    
     <p><?php echo Yii::t('participants','Note: when a topic is deleted, reports are stored without topic.'); ?></p>
    
     <?php
      $totalNew=0;
      $totalApproved=0;
      $totalDiscarded=0;
     ?>
    <table class="table" >
            <tbody >
            <tr >
                <th class="center" ><?php echo Yii::t('participants','Topic');?></th>
                <th class="center" ><?php echo Yii::t('participants','New');?></th>
                <th class="center" ><?php echo Yii::t('participants','Approved');?></th>
                <th class="center" ><?php echo Yii::t('participants','Discarded');?></th>
                <th class="center" >&nbsp</th>
            </tr>

    <?php
    $groupCount=count(array_keys($topicGroups));
    foreach($topicGroups as $i => $topicGroup) {
        $topics=$topicGroup['topics'];
        ?>
        <?php if($groupCount>1) {?>
            <tr class="sub"  >
                <th class="sub" colspan="5"  >
                    
            <?php if(!empty($topicGroup['title'])){?>
            <?php echo $topicGroup['title'];?>
            <?php } else { echo '&nbsp;';};?>
                        
                </th>
            </tr>
        <?php }?>   
            <?php
            if(count($topics)>0){
            foreach($topics as $topic) {
               ?>


        <tr class="ordered" >
            <td >
             <?php echo CHtml::link($topic['topic']->title(), $this->createUrl('participant/topicList',array('urn'=>$conf->urn(),'topic_urn'=>$topic['topic']->urn()))); ?>
            </td>
            <td class="center">
             <?php echo $topic['newCount']; $totalNew+=$topic['newCount']; ?>
            </td>
            <td class="center" >
                <?php echo $topic['approvedCount']; $totalApproved+=$topic['approvedCount'];?>
            </td>
            <td class="center">
                <?php echo $topic['discardedCount']; $totalDiscarded+=$topic['discardedCount']; ?>
            </td>
            <td class="center">
                <?php if($topic['topic']->id!=0){
                    echo CHtml::link(Yii::t('actions','delete'), '#', array("submit"=>$this->createUrl('participant/deleteTopic',array('urn'=>$conf->urn(),'topic_urn'=>$topic['topic']->urn())), 'confirm' => Yii::t('actions','Delete').'?', 'csrf'=>true)); 
                } else {?>
                &nbsp;
                <?php };?>
            </td>
         </tr>
        <?php };

        } else {?>
         <?php };?>
         <?php };
          
         ?>
           <tr class="ordered" >
           <td class="right" >
            <?php echo Yii::t('participants','Total');?>
           </td>
            <td class="center">
               <?php echo $totalNew; ?>
            </td>
            <td class="center">
                <?php echo $totalApproved; ?>
            </td>
            <td class="center">
                 <?php echo $totalDiscarded; ?>
            </td>
            <td class="center">
                &nbsp;
            </td>
            </tr>
        </tbody>
 </table>      
</div>

