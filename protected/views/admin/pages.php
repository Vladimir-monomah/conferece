<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 *  @var $conf_pages ConfPage
 *  @var $menu_items Array( (urn,title) )
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title()) => array('conf/info', 'urn' => $conf->urn()),
        Yii::t('admin','Administration') => array('admin/settings', 'urn' => $conf->urn()),
        Yii::t('admin','Pages')
);
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['DeleteObjectMsg'] = Yii::t('admin','object is marked for deletion, you have to save changes');
    $jsParams['RevertMsg'] = Yii::t('actions','revert');
    $jsParams['PagesCount'] = count($conf_pages);  
    Yii::app()->clientScript->registerScript('js.pages.params', 'var jsParams=' . CJSON::encode($jsParams) . ';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/admin/pages.js?v=1', CClientScript::POS_HEAD);   
?>
<h2><?php echo Yii::t('admin','Pages');?></h2>
<div class="form confadmin-sections" >    
    <?php $form = $this->beginWidget('ActiveForm',array('action'=>$this->createUrl('admin/pages',array('urn'=>$conf->urn())))); ?>
    <?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php };?>
    <p>
        <?php echo Yii::t('admin','Here you can create additional pages for the conference. After you create a page, it will appear in the menu of the conference. Go to this menu item to enter text on the page.');?>       
    </p>
    <p class="note"><?php echo Yii::t('validators', 'Fields with an asterisk {asterisk} are required.',
    array('{asterisk}'=>'<span class="required">*</span>'));?><br />
<?php echo Yii::t('validators', 'At least one field in a field group with an asterisk {asterisk} is required.',
    array('{asterisk}'=>'<span class="requiredOne">*</span>'));?></p>
    
    <?php echo $form->errorSummary($conf_pages); ?>
    <?php foreach($conf_pages as $i => $conf_page) {
       $num=$i; if('EmptyId'==$conf_page->id){$num='$num';}
     ?>
    <div class="ordered <?php if('EmptyId'==$conf_page->id) {?>hidden<?php }?>" id="div<?php echo $conf_page->id;?>"  >
        <div class="row" >
            <div class="label" ><?php echo $form->label($conf_page, 'title', array('requiredOne'=>true));?></div>
            <div class="value" ><?php echo $form->textFields($conf_page, "[$num]title", array('size'=>60, 'maxlength' => 100, 'class' => 'value', 'tableClass' => 'value'), 'vertical', $conf->getLanguages());?></div>
        </div>

        <div class="row" >
            <div class="label" ><?php echo $form->label($conf_page, 'urn', array('required' => true));?></div>
            <div class="value" ><?php echo $this->createAbsoluteUrl('conf/view', array('urn' => $conf->urn())).'/';?>&nbsp;<?php echo $form->textField($conf_page, "[$num]urn", array('class'=>'urn-value'));?></div>
        </div>

        <div class="row" >
            <div class="label" ><?php echo CHtml::activeLabel($conf_page,'next_urn', false);?></div>
            <div class="value" >
                    <?php $data = array();
                    $data[''] = '[' . Yii::t('admin','after all') . ']';
                    foreach ($menu_items as $item) {
                        if($conf_page->urn != $item['urn']) {
                            $data[$item['urn']] = StringUtils::cutOnWord($item['title'],60);
                        }
                    }
                    ?>
                    <?php echo $form->dropDownList($conf_page, "[$num]next_urn", $data); ?>
            </div>
        </div>       
            <?php echo $form->hiddenField($conf_page, "[$num]id");?>
            <?php echo $form->hiddenField($conf_page, "[$num]state", array('id' => 'state' . $conf_page->id));?>
            <?php echo $form->hiddenField($conf_page, "[$num]oldstate", array('id' => 'oldstate' . $conf_page->id));?>
        <div class="actions right">
            <a href="javascript:void(0)" onclick="hideListObject(this);" ><?php echo Yii::t('actions','delete')?></a>
        </div>
    </div><?php }?>
    <div class="actions right">
        <a href="javascript:void(0)" onclick="createListObject();" class="link" ><?php echo Yii::t('actions','add')?></a>
        <?php 
            echo CHtml::submitButton(Yii::t('actions','Save'), array('onclick' => "this.disabled=true;this.form.submit();")); 
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>