<?php
/**
 *  @var $this ConfController
 *  @var $conf Conf
 *  @var $confOrgs array of ConfOrg
 *  @var $enabledOrgs array of Org
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/info','urn'=>$conf->urn()),
        Yii::t('confs','General Information')=>array('conf/info','urn'=>$conf->urn()),
        Yii::t('site','Editing')
);
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    $jsParams=array();
    $jsParams['Language'] = Yii::app()->language;
    $jsParams['DeleteFileMsg'] = Yii::t('admin','file is marked for deletion, you have to save changes');
    $jsParams['DeleteObjectMsg'] = Yii::t('admin','object is marked for deletion, you have to save changes');
    $jsParams['RevertMsg'] = Yii::t('actions','revert');          
    $jsParams['OrgsCount'] = count($confOrgs);  
    $jsParams['FilemanagerTitle'] = Yii::t('site','File manager');
    $jsParams['FilemanagerEnabled'] = true;
    $jsParams['FilemanagerAccessKey'] = RFilemanagerUtils::genAccessKey($conf);
    Yii::app()->clientScript->registerScript('js.confedit.info.params', 'var jsParams=' . CJSON::encode($jsParams).';', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/common/deleteFile.js?v=1', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/confEdit/orgs.js?v=1', CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScriptFile('/js/tinymce_4.1.9/tinymce.min.js');
    Yii::app()->clientScript->registerScriptFile('/js/common/attachTinymce.js?v=5', CClientScript::POS_HEAD); 
?>
<h2><?php echo Yii::t('confs','General Information').' - '.Yii::t('site','Editing');?></h2>
<div class="form conf confedit-info">
  
    <?php $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('confEdit/info',array('urn'=>$conf->urn())),'htmlOptions'=>array('enctype'=>'multipart/form-data'))); ?>

    <p class="note"><?php echo Yii::t('validators', 'Fields with an asterisk {asterisk} are required.',
    array('{asterisk}'=>'<span class="required">*</span>'));?><br >
    <?php echo Yii::t('validators', 'At least one field in a field group with an asterisk {asterisk} is required.',
    array('{asterisk}'=>'<span class="requiredOne">*</span>'));?></p>

    <?php $allObjects=array_merge(array($conf), $confOrgs); ?>
    <?php echo $form->errorSummary($allObjects); ?>
    
    <div class="row" >
        <?php echo $form->label($conf,'subject');?><br />
        <?php echo $form->textFields($conf,'subject',array('size'=>104,'maxlength'=>200,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages());?>
    </div>

    <div class="row" >
        <?php echo $form->label($conf,'title',array('required'=>true));?><br />
        <?php echo $form->textFields($conf,'title',array('size'=>104,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages());?>
    </div>
     
   <?php  $dateFormat = DateUtils::JuiDateFormat();  ?>
    <div class="row" >           
        <div class="label" ><?php echo $form->label($conf,'start_date',array('required'=>true));?></div>
        <div class="value" >
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$conf,
                    'attribute'=>'startDateStr',
                    'language'=> Yii::app()->getLanguage(),
                    'options'=>array('changeYear'=>true,'dateFormat'=>$dateFormat),
                    'htmlOptions'=>array('size'=>10, 'maxlength'=>10))); ?>
        </div>              
    </div>
    <div class="row" >
        <div class="label" ><?php echo $form->label($conf,'end_date',array('required'=>true));?></div>
        <div class="value" >
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$conf,
                    'attribute'=>'endDateStr',
                    'language'=> Yii::app()->getLanguage(),
                    'options'=>array('changeYear'=>true,'dateFormat'=>$dateFormat),
                    'htmlOptions'=>array('size'=>10, 'maxlength'=>10))); ?>
        </div>
    </div>
    <div class="row" >
        <div class="label" >
            <?php echo $form->label($conf,'registration_end_date');?>
            <span class="hint" ><?php echo Yii::t('confs','till Start Date by default');?></span>
        </div>
        <div class="value" >
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$conf,
                    'attribute'=>'registrationEndDateStr',
                    'language'=> Yii::app()->getLanguage(),
                    'options'=>array('changeYear'=>true,'dateFormat'=>$dateFormat),
                    'htmlOptions'=>array('size'=>10, 'maxlength'=>10))); ?>
        </div>
    </div>
    <div class="row" >
        <div class="label"  >
            <?php echo $form->label($conf,'submission_end_date');?>
            <span class="hint"><?php echo Yii::t('confs','Registration Due Date by default');?></span>
        </div>
        <div class="value" >
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$conf,
                    'attribute'=>'submissionEndDateStr',
                    'language'=> Yii::app()->getLanguage(),
                    'options'=>array('changeYear'=>true,'dateFormat'=>$dateFormat),
                    'htmlOptions'=>array('size'=>10, 'maxlength'=>10))); ?>
        </div>
    </div>
  
    <div class="row" >
        <?php echo $form->label($conf,'place');?><br />
        <?php echo $form->textFields($conf,'place',array('size'=>104,'maxlength'=>200,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages());?>
    </div>
    <div class="row" >
        <div class="label" ><?php echo CHtml::activeLabel($conf,'website');?></div>
        <div class="value" ><?php echo $form->textField($conf,'website',array('size'=>40,'maxlength'=>100));?></div>
    </div>
    <div class="row" >
        <div class="label" ><?php echo CHtml::activeLabel($conf,'email');?></div>
        <div class="value" ><?php echo $form->textField($conf,'email',array('size'=>40,'maxlength'=>100));?></div>
    </div>

    <div class="row" >
        <div class="label" ><?php echo CHtml::activeLabel($conf,'phone');?></div>
        <div class="value" ><?php echo $form->textField($conf,'phone',array('size'=>40,'maxlength'=>100));?></div>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($conf,'info_letter');?><br />
        <span class="fileHint" ><?php echo Yii::t('validators','File formats allowed to upload');?>:&nbsp;<?php echo FileUtils::listStr(Yii::app()->params['fileExts']); ?></span>
        <span class="fileHint" ><?php echo Yii::t('validators','Max file size allowed to upload');?>:&nbsp;<?php echo FileUtils::fileSizeStr(Yii::app()->params['userFileSize']);?></span>   
        <?php echo $form->fileFields($conf,'info_letter',-1,$conf->getLanguages());?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($conf,'logo');?><br />
        <span class="fileHint" ><?php echo Yii::t('validators','File formats allowed to upload');?>:&nbsp;<?php echo FileUtils::listStr(Yii::app()->params['logoExts']); ?></span>
        <span class="fileHint" ><?php echo Yii::t('validators','Max file size allowed to upload');?>:&nbsp;<?php echo FileUtils::fileSizeStr(Yii::app()->params['userFileSize']);?></span>
        <?php echo $form->imgFields($conf,'logo');?>
    </div>

        
    <?php $data=array();
          foreach ($enabledOrgs as $org) {
               $data[$org->id]=StringUtils::cutOnWord($org->name(),70);
          };
    ?>
    <div class="conf-orgs">
       <?php echo CHtml::activeLabel($conf,'orgs',array('class'=>'left'));?><br />
       <?php foreach($confOrgs as $i => $confOrg) {
          $num=$i; if('EmptyId'==$confOrg->id){$num='$num';}; $org=$confOrg->org;
       ?>
    <div class="ordered <?php if('EmptyId'==$confOrg->id) {echo 'hidden';};?>" id="div<?php echo $confOrg->id;?>"  >
        <div class="row"  >
            <div class="label" ><?php echo $form->label($confOrg,'name',array('requiredOne'=>true));?></div>
            <div class="value"  >
                   <?php if($confOrg->isEnabled()){ ?>
                    <?php echo $form->dropDownList($confOrg,"[$num]org_id",$data,array('class'=>'value')); ?>
                <?php }else{?>
                <?php echo $form->textFields($confOrg,"[$num]name",array('size'=>70,'maxlength'=>400,'class'=>'value','tableClass'=>'value','hintClass'=>'hint'),'vertical',$conf->getLanguages());?>
                <?php }?>      
            </div>         
        </div>
        <div class="row"  >
            <div class="label"  ><?php echo $form->label($confOrg,'sub_org');?></div>
            <div class="value" >
                <?php echo $form->textFields($confOrg,"[$num]sub_org",array('size'=>70,'maxlength'=>150,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages());?>              
            </div>
        </div>     
            <?php echo $form->hiddenField($confOrg,"[$num]id");?>
            <?php echo $form->hiddenField($confOrg,"[$num]state",array('id'=>'state' . $confOrg->id));?>
            <?php echo $form->hiddenField($confOrg,"[$num]oldstate",array('id'=>'oldstate' . $confOrg->id));?>
        <div class="actions right" ><a href="javascript:void(0)" onclick="hideListObject(this);" ><?php echo Yii::t('actions','delete')?></a></div>
    </div><?php }?>
    <!-- Template for selected organization-->
    <?php $confOrg=new ConfOrg();?>
    <div class="ordered hidden" id="divSelectEmptyId"  >
        <div class="row" >
            <div class="label"  ><?php echo $form->label($confOrg,'name',array('requiredOne'=>true));?></div>
            <div class="value" >
                <?php echo $form->dropDownList($confOrg,'[$num]org_id',$data,array('class'=>'value')); ?>
              </div>
        </div>
        <div class="row"  >
            <div class="label"  ><?php echo $form->label($confOrg,'sub_org');?></div>
            <div class="value" >
                <?php echo $form->textFields($confOrg,'[$num]sub_org',array('size'=>70,'maxlength'=>150,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages());?>
            </div>
        </div>
          <?php echo CHtml::hiddenField('ConfOrg[$num][id]','EmptyId');?>
          <?php echo CHtml::hiddenField('ConfOrg[$num][state]','new',array('id'=>'stateEmptyId'));?>
          <?php echo CHtml::hiddenField('ConfOrg[$num][oldstate]','new',array('id'=>'stateEmptyId'));?>
       <div class="actions right" ><a href="javascript:void(0)" onclick="hideListObject(this);" ><?php echo Yii::t('actions','delete')?></a></div> 
    </div>
    <!-- Template for new organization-->
    <?php $confOrg=new ConfOrg();?>
    <div class="ordered hidden" id="divEmptyId" >
        <div class="row" >
            <div class="label"  ><?php echo $form->label($confOrg,'name',array('requiredOne'=>true));?></div>
            <div class="value" >
               <?php echo $form->textFields($confOrg,'[$num]name',array('size'=>70,'maxlength'=>400,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages());?>
            </div>
        </div>
        <div class="row"  >
            <div class="label"  ><?php echo $form->label($confOrg,'sub_org');?></div>
            <div class="value" >
                <?php echo $form->textFields($confOrg,'[$num]sub_org',array('size'=>70,'maxlength'=>100,'class'=>'value','tableClass'=>'value'),'vertical',$conf->getLanguages());?>
            </div>
        </div>
           <?php echo CHtml::hiddenField('ConfOrg[$num][id]','EmptyId');?>
           <?php echo CHtml::hiddenField('ConfOrg[$num][state]','new',array('id'=>'stateEmptyId'));?>
        <div class="actions right"><a href="javascript:void(0)" onclick="hideListObject(this);" ><?php echo Yii::t('actions','delete')?></a></div>
    </div>
    <!-- End of Template for new organization-->

     <div class="actions right">
         <a href="javascript:void(0)" onclick="createListObject(false);" class="link" ><?php echo Yii::t('actions','add')?></a><a href="javascript:void(0)" class="link" onclick="createListObject(true);" ><?php echo Yii::t('actions','add from list')?></a>
     </div>
    </div>
   
    <div class="row" >
        <?php echo CHtml::activeLabel($conf,'description');?><br />
        <?php echo $form->textAreas($conf,'description',array('cols'=>91,'rows'=>5,'class'=>'editor value','tableClass'=>'value','hintClass'=>'editor-hint'),'vertical',$conf->getLanguages() );?>
    </div>

    <div class="row" >
        <?php echo CHtml::activeLabel($conf,'fee');?><br />
        <?php echo $form->textAreas($conf,'fee',array('cols'=>91,'rows'=>2,'class'=>'editor value','tableClass'=>'value','hintClass'=>'editor-hint'),'vertical',$conf->getLanguages() );?>
    </div>

    <div class="row table-row" >
        <?php echo CHtml::activeLabel($conf,'accommodation');?><br />
        <?php echo $form->textAreas($conf,'accommodation',array('cols'=>91,'rows'=>2,'class'=>'editor value','tableClass'=>'value','hintClass'=>'editor-hint'),'vertical',$conf->getLanguages() );?>
    </div>

    <div class="actions right">
        <?php echo CHtml::link(Yii::t('actions','cancel'),$this->createUrl('conf/'.Yii::app()->controller->action->id,array('urn'=>$conf->urn())),array('class'=>'link')); ?>
        <?php echo CHtml::submitButton(Yii::t('actions','Save')); ?>
    </div>
<?php $this->endWidget(); ?>
</div>



