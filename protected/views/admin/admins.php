<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 *  @var $admins ConfAdmin
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/info','urn'=>$conf->urn()),
        Yii::t('admin','Administration')=>array('admin/settings','urn'=>$conf->urn()),
        Yii::t('admin','Administrators')
);
?>
<h2><?php echo Yii::t('admin','Administrators');?></h2>
<div class="form confadmin-admins" >
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('admin/admins',array('urn'=>$conf->urn())))); ?>
    <?php foreach($admins as $admin) { ?>
        <div class="row">   
            <div class="label">
               <?php echo CHtml::label($admin->fullName(),'chbx'.$admin->id);?> 
            </div>
             <div class="value">
            <?php echo CHtml::checkBox('admin['.$admin->id.']',false,array('id'=>'chbx'.$admin->id));?>&nbsp;
            <?php echo CHtml::link(Yii::t('actions','view'), array('user/view','id'=>$admin->urn()));?>
            </div>
        </div>
    <?php }?>
    <div class="actions right">
           <?php echo CHtml::submitButton(Yii::t('actions','Delete'),array('name'=>'delete','onclick'=>'return confirm("'.Yii::t('actions','Delete').'?");'));?>
    </div>
    <?php $this->endWidget(); ?>
    <hr />
    <h3><?php echo Yii::t('admin','New administrator');?></h3>
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('admin/admins',array('urn'=>$conf->urn())))); ?>
    <?php echo Yii::t('admin','To add a new administrator, input E-mail registered on the site.');?><br />
    <div class="row">
        <div class="label">
    <?php echo Chtml::label('E-mail','email_id');?>
            </div>
        <div class="value">
        <?php echo CHtml::textField('email','',array('size'=>40,'maxlength'=>100,'id'=>'email_id'));?>
        </div>    
    </div>    
        <div class="actions right">
        <?php echo CHtml::submitButton(Yii::t('actions','Add'),array('name'=>'add'));?>
        </div>    
    <?php $this->endWidget(); ?>
    <hr />
    <h3><?php echo Yii::t('admin','Search user');?></h3>
    <?php if(Yii::app()->user->hasFlash('searchResult')){  ?>
    <p class="errorSummary">
        <?php echo Yii::app()->user->getFlash('searchResult');?>
    </p>
    <?php };?>
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('admin/admins',array('urn'=>$conf->urn())))); ?>
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
    <div class="row">
        <div class="label">
            <?php echo $form->label($searchUser,'middlename');?>
        </div>
        <div class="value">
             <?php echo $form->textFields($searchUser,'middlename',array('size'=>30,'maxlength'=>30),'',array(Yii::app()->language=>Yii::app()->language)); ?>
        </div>        
    </div>
    <div class="actions right">
        <?php echo CHtml::submitButton(Yii::t('actions','Search'),array('name'=>'add'));?>
    </div>
    <?php $this->endWidget(); ?>

    <?php if(count($users)>0){?>
    <table class="table" >
    <tr>
        <th>&nbsp;</th>
        <th>E-mail</th>
        <th><?php echo Yii::t('users','Name')?></th>
    </tr>

    <?php foreach($users as $i => $user) { ?>
    <tr class="ordered">
        <td class="right" ><?php echo ($i+1)?></td>
        <td><?php echo CHtml::link($user->email, array('user/view','id'=>$user->id));?></td>
        <td><?php echo $user->fullName();?></td>
    </tr>
    <?php }?>
    </table>
    <?php } ?>
        
    
</div>
