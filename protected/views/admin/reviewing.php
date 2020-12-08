<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/info','urn'=>$conf->urn()),
        Yii::t('admin','Administration')=>array('admin/settings','urn'=>$conf->urn()),
        Yii::t('admin','Reviewing')
);
?>
<h2><?php echo Yii::t('admin','Mailing'); ?></h2>
<div class="form confadmin-reviewing" >
    Включить рецензирование докладов<br />
    Форма рецензирования<br />
    Рецензенты<br />
</div>
