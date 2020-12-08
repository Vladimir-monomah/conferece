<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 */
$this->pageTitle = Yii::t('site', Yii::app()->name) . ' - ' . CHtml::encode($conf->title());
?>
<div class="conf-header">
<h3><?php echo CHtml::encode($conf->subject()) ?></h3>
<h1><?php echo CHtml::encode($conf->title()) ?></h1>
<?php if(Yii::app()->user->checkAccess('modifyConf',array('conf_id' => $conf->id))){?>
<?php $action=Yii::app()->controller->action->id;
     if(in_array($action, array('participants', 'application', 'view'))){
         $action = 'info';
     }
     if ($action == 'page') {
         $action = $confPage->urn;
     }
     if ($action != 'guestbook') {
?>
<div class="edit-link" >
    <?php echo CHtml::link(Yii::t('actions','edit'), $this->createUrl('confEdit/' . $action, array('urn' => $conf->urn())));?>
</div>
<?php
     }}
?>
<hr />
</div>
