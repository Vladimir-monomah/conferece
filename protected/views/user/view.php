<?php
/**
 *  @var $this UserController
 *  @var $user a User
 *  @var $myConfs array of Conf
 *  @var $myApplications array of Participant
 */
$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - ' . CHtml::encode($user->fullName());
$this->breadcrumbs=array(
         Yii::t('users','Users')=>array('user/list'), 
        StringUtils::cutOnWord($user->fullName()),
);
?>
<div class="edit-link">
    <?php echo CHtml::link(Yii::t('actions','edit'), array('user/edit','id'=>$user->id));?>
</div>
<h1><?php echo CHtml::encode($user->fullName());?></h1>
<div class="form user-view" >   
    <?php if(Yii::app()->user->hasFlash('saved')){?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('saved');?>
    </div>
    <?php }?>
    <?php if(Yii::app()->user->hasFlash('error')){?>
    <div class="errorSummary">
        <?php echo Yii::app()->user->getFlash('error');?>
    </div>
    <?php }?>
    <?php 
        //  для администратора или если загружено изображение
        //  for administrator of if an image is uploaded
        $viewColumn2=Yii::app()->user->checkAccess('assignUserRole'); 
        $image=$user->getFile('image');      
        if($image){
          $viewColumn2=true;
        };
    ?>   
    <div class="column <?php if($viewColumn2){echo 'column-left';}; ?>" >
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'email');?></div>
        <div class="value"><?php echo StringUtils::hideEmail(CHtml::value($user,'email'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'phone');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'phone'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'fax');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'fax'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'locale');?></div>
        <div class="value"><?php echo CHtml::encode(Yii::t('users',Yii::app()->params['languages'][$user->locale]));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'country');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'country'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'city');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'city'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'home_address');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'home_address'));?>&nbsp;</div>      
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'institution');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'institution'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'institution_address');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'institution_address'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'position');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'position'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'academic_degree');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'academic_degree'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'academic_title');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'academic_title'));?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'supervisor');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'supervisor'));?>&nbsp;</div>
    </div>
    </div>
    
    
    <?php if($viewColumn2){ ?>
    <div class="column-right" >
    <?php 
    if($image) { ?>
        <div class="row right"  >
         <?php echo CHtml::image($image->url(),Yii::t('users','Image'),array('class'=>'img ')); ?>
          <br /><br />  
        </div>    
    <?php };?>
    <?php if(Yii::app()->user->checkAccess('assignUserRole')){ ?>    
    <div class="user-role">
    <div class="row" >
        <div class="label">
            <?php echo CHtml::activeLabel($user,'registration_date');?>
        </div>
        <div class="value"><?php echo Yii::app()->locale->dateFormatter->formatDateTime($user->registration_date);?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'last_date');?></div>
        <div class="value"><?php echo Yii::app()->locale->dateFormatter->formatDateTime($user->last_date);?>&nbsp;</div>
    </div>
    <div class="row" >
        <div class="label"><?php echo CHtml::activeLabel($user,'last_ip');?></div>
        <div class="value"><?php echo CHtml::encode(CHtml::value($user,'last_ip'));?>&nbsp;</div>
    </div>
       
    <div class="row" >
        <?php echo CHtml::beginForm($this->createUrl('user/role',array('id'=>$user->id))); ?>
        <div class="label">
            <?php echo CHtml::activeLabel($user,'role');?>
        </div>
        <div class="value" >
            <?php if(!$user->isLastAdmin()){ ?> 
            <?php echo CHtml::radioButtonList('role',$user->role,array('user'=>Yii::t('users','User'),'admin'=>Yii::t('users','Admin')),array('separator'=>'<br />','labelOptions'=>array('class'=>'radioLabel')));
            echo '<br/>' .CHtml::submitButton(Yii::t('actions','Apply'));?>
             <?php } else { ?>  
            <?php echo ($user->role=='admin'?Yii::t('users','Admin'):Yii::t('users','User')); ?>
             <?php }; ?>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
        
    </div>
<?php } ?>
   </div>
    <?php }; // viewColumn2?>
   <br class="clear" />
</div>
<?php if(!$user->isLastAdmin()){ ?>  
<div class="actions right" >         
        <?php echo CHtml::beginForm($this->createUrl('user/delete',array('id'=>$user->id))); ?>
        <?php echo CHtml::submitButton(Yii::t('actions','Delete'),array('name'=>'delete','onclick'=>'return confirm("'.Yii::t('actions','Delete').'?");')); ?>
        <?php echo CHtml::endForm(); ?>
</div>
<?php }; ?>
<hr />
<h2><?php echo Yii::t('confs','Conferences where I am an administrator');?></h2>
<div class="user-view">
    <table class="table" >
        <tr>
            <th ><?php echo Yii::t('confs','Title');?></th>
            <th ><?php echo Yii::t('confs','Dates');?></th>
            <th ><?php echo Yii::t('participants','New applications');?></th>
            <th ><?php echo Yii::t('participants','Approved');?></th>
            <th ><?php echo Yii::t('confs','Enabled');?></th>
        </tr>
    <?php foreach($myConfs as $i => $conf) {?>
      <tr class="ordered" >
          <td >
        <?php $linkName=CHtml::encode($conf->title());
         if(empty($linkName)){$linkName=Yii::t('confs','Untitled');};?>
        <?php echo CHtml::link($linkName, array('conf/view','urn'=>$conf->urn()));?><br />
        <?php  $subject=trim($conf->subject());
           if(!empty($subject)){
            echo CHtml::encode($subject).'<br>';}
        ?>
        </td>
            <td >
        <?php if($conf->start_date){?>
        <?php echo Yii::app()->locale->dateFormatter->formatDateTime($conf->start_date,'long',NULL);
         if($conf->end_date && $conf->end_date!=$conf->start_date){ echo ' – ' . Yii::app()->locale->dateFormatter->formatDateTime($conf->end_date,'long',NULL);}?>
         <?php }?>
         </td>
         <td class="center"><?php $participants=$conf->newParticipants; echo $participants;?></td>
         <td class="center"><?php $participants=$conf->approvedParticipants; echo $participants;?></td>
         <td class="center"><?php echo ($conf->is_enabled?Yii::t('site','Yes'):Yii::t('site','No'));?></td>
      </tr>
     <?php }?>
     </table>
</div>
<br />
<hr />
<h2><?php echo Yii::t('users','My applications');?></h2>
<?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('user/deleteParticipants',array('id'=>$user->id)),'htmlOptions'=>array('autocomplete'=>'off'))); ?>
<div class="form user-view">
    <table class="table">
        <tr>
            <th ><?php echo Yii::t('participants','Title');?></th>
            <th ><?php echo Yii::t('participants','Authors');?></th>
            <th ><?php echo Yii::t('participants','Participation Type');?></th>
            <th ><?php echo Yii::t('confs','Conference');?></th>
            <th ><?php echo Yii::t('participants','Status');?></th>
            <th ><?php echo Yii::t('actions','Delete');?></th>
        </tr>
    <?php foreach($myApplications as $i => $participant) {?>
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
                if($titlesCount>0){
                    echo '<br />';
                };
            $titlesCount++; 
             ?>
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
         <td >
             <?php echo $participant->authorNames();?>
             <?php 
                $creatorName = $participant->creatorName();
                echo empty($creatorName)?'':'<br/><i>' . Yii::t('participants', 'Created by') .':&nbsp' . $creatorName . '</i>';
             ?>
         </td>
         <td ><?php echo $participant->participationType();?></td>
         <td >
             <?php
             $_conf=$participant->conf();
             $confTitle='';
                 if($_conf){
                     $confTitle=$_conf->title();
                 }
             $linkName=CHtml::encode($confTitle);
         if(empty($linkName)){$linkName=Yii::t('confs','Untitled');};?>
        <?php if($_conf) {echo CHtml::link($linkName, array('conf/view','urn'=>$_conf->urn()));}
        else{ echo Yii::t('site','No');};?><br />
        <?php 
         $subject='';
        if($_conf){
            $subject=trim($_conf->subject());
        }
           if(!empty($subject)){
            echo CHtml::encode($subject);}
        ?>
         </td>
         <td ><?php echo $participant->statusStr();?></td>
         <td class="center"> <?php echo CHtml::checkBox('deleted['.$participant->id.']');?></td>
      </tr>
     <?php }?>
     </table>
</div>
<?php if(count($myApplications)>0){?>
<div class="actions right">
        <?php echo CHtml::submitButton(Yii::t('actions','Delete'),array('name'=>'delete','onclick'=>'return confirm("'.Yii::t('actions','Delete').'?");')); ?>
</div>
<?php };?>
<?php $this->endWidget(); ?>

