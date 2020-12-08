<?php
/**
 *  @var $this AdminController
 *  @var $conf Conf
 *  @var $recipientsForm RecipientsForm
 */
?>
<?php include 'header.inc';?>
<?php
$this->breadcrumbs=array(
        StringUtils::cutOnWord($conf->title())=>array('conf/info','urn'=>$conf->urn()),
        Yii::t('admin','Administration')=>array('admin/settings','urn'=>$conf->urn()),
        Yii::t('admin','Recipients')
);
?>
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerScriptFile('/js/admin/recipients.js?v=3', CClientScript::POS_HEAD);   
?>   
 <?php 
        $languages = $conf->getLanguages(); 
        $showPreferredLanguage = FALSE;
        if (count($languages) > 1) {
            $showPreferredLanguage = TRUE;
        }
    ?>
<h2><?php echo Yii::t('admin','Recipients'); ?></h2>
<div class="form confadmin-recipients" >
    <?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php };?>
    <p class="note" >
        <?php echo Yii::t('admin','Notes:'); ?>
        <ul>
        <li><?php echo Yii::t('admin', 'Select participants to whom the E-mail will be sent.');?></li> 
        <li><?php echo Yii::t('admin', 'A common letter is sent to the selected authors of one application for participation.');?></li> 
        <li><?php echo Yii::t('admin', 'Authors who do not have an E-mail address or a specified address is not correct will be excluded from the mailing list. These authors are displayed in gray. Detailed statistics with the results of the mailing can be viewed in the mailing queue.');?></li>  
        <?php if($showPreferredLanguage) { ?>
        <li><?php echo Yii::t('admin', 'The preferred language of the letter is the language chosen by the first of the authors of the application form as the preferred notification language. It is recommended for writing the text of the letter to the authors of the application.');?></li>
        <?php }; ?>
        </ul>
    </p>
   
    <?php 
        if ($showPreferredLanguage) {
            echo Yii::t('admin', 'Select participants by preferred language of the letter')?>:
        <?php foreach ($languages as $lang => $name ) { ?>
            &nbsp;<input type="checkbox" id="lang_<?php echo $lang; ?>_id" onchange="selectByLocale('<?php echo $lang; ?>', this);">&nbsp;<?php echo CHtml::label($recipientsForm->getLanguageName($lang), "lang_${lang}_id"); ?>    
        <?php } ?>   
        <br />    
    <?php } ;?>
    <input type="checkbox" id='select_all_id' onchange="selectAll(this)">&nbsp;<?php echo CHtml::label(Yii::t('admin', 'Select/unselect all participants'), "select_all_id", array('class'=>'checkbox')); ?>        
    
    <?php $form = $this->beginWidget('ActiveForm',array('action' => $this->createUrl('admin/recipients',array('urn'=>$conf->urn())))); ?>
        <table class="table" >
            <tr>
                <th style="width:100px" >&nbsp;</th>
                <th class="center" ><?php echo Yii::t('participants','Participant');?></th>
            </tr>
            <?php $r = $recipientsForm->recipients; ?>
            <?php
                $i = 0;
                foreach($r as $participant_id => $participant) { 
                    $i++; 
                    $htmlOptions = array();
                    $htmlOptions['id'] = "recipients_chbx_${participant_id}_id";
                    $htmlOptions['onchange'] = "selectAuthors(${participant_id}, this);";
            ?>
            <tr class="ordered">
                <td class="center">
                    <?php echo ($i);?><br />
                    <?php echo CHtml::hiddenField("RecipientsForm[recipients][${participant_id}][locale]", $participant['locale']); ?>
                    <?php echo CHtml::checkBox("RecipientsForm[recipients][${participant_id}][selected]", $participant['selected'], $htmlOptions); ?>&nbsp;<?php echo CHtml::label(Yii::t('actions', 'select'), "recipients_chbx_${participant_id}_id"); ?>
                </td>
                <td class="top">
                    <p class="p"><?php echo $participant['title'];?></p>
                    <p class="p">
                    <?php echo Yii::t('admin', 'Recipients');?>: 
                    <?php $authors = $participant['authors']; 
                        foreach($authors as $author_id => $author) {
                            $htmlOptions = array();
                            $htmlOptions['id'] = "authors_chbx_${author_id}_id";
                            $htmlOptions['onchange'] = "selectAuthor(${participant_id}, this);";
                            if(!$author['valid']){
                                $htmlOptions['disabled'] = 'disabled'; 
                            };
                            $gray = !$author['valid'];
                    ?>
                        <br />
                        <?php echo CHtml::hiddenField("RecipientsForm[recipients][${participant_id}][authors][${author_id}][email]", $author['email']); ?>
                        <?php echo CHtml::checkBox("RecipientsForm[recipients][${participant_id}][authors][${author_id}][selected]", $author['selected'], $htmlOptions); ?>&nbsp;<?php if ($gray) {?><span style="color:graytext"><?php }?> <?php echo CHtml::label($author['email'], "authors_chbx_${author_id}_id"); ?><?php if ($gray) {?></span><?php } ?>
                    <?php } ?>
                    </p>
                    <?php if($showPreferredLanguage) { ?>
                    <p class="p">
                    <?php echo Yii::t('admin', 'Preferred language of the letter');?>: <?php echo $recipientsForm->getLanguageName($participant['locale']); ?>
                    </p>
                    <?php }; ?>
                </td>
            </tr>
            <?php } ?>
        </table>    
        <div class="actions right">
        <?php echo CHtml::link(Yii::t('actions','return'),$this->createUrl('admin/mailing',array('urn'=>$conf->urn())), array('class'=>'link'));?>
        <?php echo CHtml::submitButton(Yii::t('actions','Save'),array('name'=>'save')); ?>       
        </div>
    <?php $this->endWidget(); ?>       
</div>

