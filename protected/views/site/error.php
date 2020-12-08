<?php
/**
 *  @var $this SiteController 
 * @var $error array 
 */

$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - '.Yii::t('site','Error');
$this->breadcrumbs=array(
	Yii::t('site','Error'),
);
?>
<h1><?php echo Yii::t('site','Error').' '.$code; ?></h1>
<div class="site-error">
    <p>
<?php echo CHtml::encode(Yii::t('site',$message)); ?>
    </p>    
</div>