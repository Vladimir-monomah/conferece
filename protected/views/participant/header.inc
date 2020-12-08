<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 */
$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - ' . CHtml::encode($conf->title());
?>

<div class="conf-header">
<h3><?php echo CHtml::encode($conf->subject()) ?></h3>
<h1><?php echo CHtml::encode($conf->title()) ?></h1>
<?php
    $action=Yii::app()->controller->action->id;   
    if(in_array($action,array('view'))){
     $params=array(
            "conf_id"=>Yii::app()->getRequest()->getQuery("id"),
            "participant_id"=>Yii::app()->getRequest()->getQuery("participant_id"),
            "class"=>"Participant",
            "id"=>Yii::app()->getRequest()->getQuery("participant_id"),
            "owner_attr" => "user_id",
            "user_id"=>Yii::app()->user->id
        );
     $editAllowed=Yii::app()->user->checkAccess('modifyParticipant',$params);
    if($editAllowed){?>
        <div class="edit-link" >
            <?php echo CHtml::link(Yii::t('actions','edit'),$this->createUrl('participant/edit',array('urn'=>$conf->urn(),'participant_urn'=>$participant->urn())));?>
        </div>
<?php }} ?>
<hr />
</div>
