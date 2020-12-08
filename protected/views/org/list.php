<?php
/**
 *  @var $this OrgController
 *  @var $orgs list of Org 
 */
$this->pageTitle=Yii::t('site',Yii::app()->name) . ' - '.Yii::t('orgs','Organizations');
$this->breadcrumbs=array(
        Yii::t('orgs','Organizations'),
);
?>
<h1><?php echo Yii::t('orgs','Organization List');?></h1>
<table class="table">
    <tr>
        <th >&nbsp;</th>
        <th ><?php
            $sortt='namea';
            if($sort=='namea'){
                $sortt='named';
            };
            $sorte='enableda';
            if($sort=='enableda'){
                $sorte='enabledd';
            };
            $sortn='numbera';
            if($sort=='numbera'){
                $sortn='numberd';
            };
            echo CHtml::link(Yii::t('orgs','Name'), array('org/list','sort'=>$sortt));
           ?></th>
        <th class="center" ><?php 
            echo CHtml::link(Yii::t('orgs','Enabled'), array('org/list','sort'=>$sorte));
            ?></th>
        <th class="center" ><?php 
            echo CHtml::link(Yii::t('orgs','Conferences Number'), array('org/list','sort'=>$sortn));
           ?></th>
    </tr>
    <?php foreach($orgs as $i => $org) {?>
    <tr class="ordered" >
        <td class="right"><?php echo ($i+1)?></td>
        <td><?php $name=CHtml::encode($org->name()); if(empty($name)){$name=Yii::t('actions','view');};echo CHtml::link($name, array('org/view','urn'=>$org->urn())) ;?></td>
        <td class="center"><?php echo CHtml::encode($org->isEnabledStr());?></td>
        <td class="center"><?php echo $org->confCount;?></td>        
    </tr>
    <?php }?>
</table>


