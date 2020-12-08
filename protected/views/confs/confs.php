<?php
/**
 *  @var $this ConfsController
 *  @var $confs list of Conferences
 *  @var $start_year
 *  @var $end_year
 *  @var $year
 */
$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - '.Yii::t('site','Home');
 if('current'!==$year) {
    $this->breadcrumbs=array(
        $year
    );
 };
?>
<?php if('current'===$year) { ?>
<h1><?php echo Yii::t('confs','Current Conferences');?></h1>
<?php };?>
<div class="confs-confs">
    <?php
    for ($iYear = $end_year; $iYear >= $start_year; $iYear--) {
        if($iYear==$year) {
            echo "<span class='current-year link'>" .$year . '</span>';
        }else {
            echo "<span class='year link'>" . CHtml::link($iYear,array('confs/confs','year'=>$iYear)) . '</span>';
        }
    }
  ?>
</div>
<div class="confs-confs">
    <?php if(empty($confs) && ('current'!==$year)) {
        echo '<p>' . Yii::t('confs','There is no conference held that year.') . '</p>';
    }?>
    <?php if(empty($confs) && ('current'===$year)) {
        echo '<p>' . Yii::t('confs','There are no current conferences.') . '</p>';
    }?>
    <?php foreach($confs as $i => $conf) {?>
    <div class="row" >
        <span class="conf-name" ><?php echo CHtml::link(CHtml::encode($conf->title()), array('conf/view','urn'=>$conf->urn()));?></span><br />
            <?php  $subject=trim($conf->subject());
            if(!empty($subject)) {
                echo CHtml::encode($subject).'<br />';
            }
            ?>
            <?php echo Yii::app()->locale->dateFormatter->formatDateTime($conf->start_date,'long',NULL);
            if($conf->end_date && $conf->end_date!=$conf->start_date) {
                echo ' – ' . Yii::app()->locale->dateFormatter->formatDateTime($conf->end_date,'long',NULL);
            }?><br />           
    </div>
    <?php }?>
</div>

