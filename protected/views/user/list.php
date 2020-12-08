<?php
/**
 *  @var $this UserController
 *  @var $users list of User 
 *  @var searchUser User
 *  @var currentPage Integer 
 *  @var pageSize Integer
 *  @var itemCount Integer
 */
$this->pageTitle = Yii::t('site',Yii::app()->name) . ' - '.Yii::t('users','Users');
$this->breadcrumbs = array(
        Yii::t('users','Users'),
);
?>
<h1><?php echo Yii::t('users','User List');?></h1>
<div class="user-list">
    
    <h3><?php echo Yii::t('users','Search Users');?></h3>
    <?php if(Yii::app()->user->hasFlash('searchResult')){  ?>
    <p class="errorSummary">
        <?php echo Yii::app()->user->getFlash('searchResult');?>
    </p>
    <?php };?>
    <div class='form' style='xbackground-color: red;xmargin-left: 200px;margin-right: 300px'>
    <?php $form = $this->beginWidget('ActiveForm',array('action'=>$this->createUrl('user/list'))); ?>
    <div class="row">
        <div class="label">
            <?php echo $form->label($searchUser,'email');?>
        </div>
        <div class="value">
            <?php echo $form->textField($searchUser,'email', array('size'=>40,'maxlength'=>100)); ?>
        </div>
    </div>
    <div class="row">
        <div class="label">
            <?php echo $form->label($searchUser,'lastname');?>
        </div>
        <div class="value">
            <?php echo $form->textFields($searchUser,'lastname',array('size'=>30,'maxlength'=>30),'',array(Yii::app()->language=>Yii::app()->language)); ?>
        </div>
    </div>
    <div class="row">
        <div class="label">
            <?php echo $form->label($searchUser,'firstname');?>
        </div>
        <div class="value">
             <?php echo $form->textFields($searchUser,'firstname',array('size'=>30,'maxlength'=>30),'',array(Yii::app()->language=>Yii::app()->language)); ?>
        </div>
    </div>
    <div class="actions" style='margin-left:210px'>
        <?php echo CHtml::submitButton(Yii::t('actions','Search'),array('name'=>'add'));?>
    </div>
    <?php $this->endWidget(); ?>
    </div>
    
<div style='text-align: center; width:100%;margin: 20px'>
 <?php $this->widget('CLinkPager', array(
	    'currentPage'=>$currentPage,
	    'itemCount'=>$itemCount,
	    'pageSize'=>$pageSize,
	    'maxButtonCount'=>10,
            'cssFile' => Yii::app()->theme->baseUrl . '/css/pager.css?v=2',
	    //'nextPageLabel'=>'My text >',
	    'header'=>'',
            'htmlOptions'=>array('class'=>'yiiPager'),
	));
 ?>
</div>      
    
<table class="table">
    <tr>
        <th>&nbsp;</th>
        <th >
            E-mail
        </th>
        <th>
            <?php echo Yii::t('users','Name');?>
        </th>       
    </tr>
    <?php
        $p = $currentPage * $pageSize;
        foreach($users as $i => $user) {?>
    <tr class="ordered">
        <td class="right"><?php echo ($i+1+$p)?></td>
        <td><?php echo CHtml::link($user->email, array('user/view','id'=>$user->id)); ?></td>
        <td><?php echo CHtml::link($user->fullName(), array('user/view','id'=>$user->id)); ?></td>
    </tr>
    <?php }?>
</table>
 
<div style='text-align: center; width:100%;margin: 20px'>
 <?php $this->widget('CLinkPager', array(
	    'currentPage'=>$currentPage,
	    'itemCount'=>$itemCount,
	    'pageSize'=>$pageSize,
	    'maxButtonCount'=>10,
            'cssFile' => Yii::app()->theme->baseUrl . '/css/pager.css?v=2',
	    //'nextPageLabel'=>'My text >',
	    'header'=>'',
            'htmlOptions'=>array('class'=>'yiiPager'),
	));
 ?>
</div>     

</div>    


