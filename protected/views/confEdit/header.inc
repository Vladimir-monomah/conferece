<?php
/**
 *  @var $this ConfEditController
 *  @var $conf Conf
 */
$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - ' . CHtml::encode($conf->title());
?>
<?php if(!in_array(Yii::app()->controller->action->id,array('info','languages'))){?>
<div class="conf-header">
    <h3><?php echo CHtml::encode($conf->subject()) ?></h3>
    <h1><?php echo CHtml::encode($conf->title()) ?></h1>
    <?php if(Yii::app()->user->checkAccess('modifyConf',array('conf_id' => $conf->id))) {
        $action=Yii::app()->controller->action->id;
        if($action=='page'){
            $action = $confPage->urn;
        }
        ?>
    <?php /*?><div class="edit-link"><?php echo CHtml::link( Yii::t('actions','cancel editing'),$this->createUrl('conf/'.$action,array('urn'=>$conf->urn())));?><br /></div> <?php */?>
        <?php }?>
    <hr />
</div>
<?php }?>
