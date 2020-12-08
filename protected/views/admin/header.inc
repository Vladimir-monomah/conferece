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
<hr />
</div>

