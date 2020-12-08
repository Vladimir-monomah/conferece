<?php
/**
 *  @var $this   ExportController
 *  @var $conf   Conf
 *  @var $topicGroups    array of array of ConfTopics
 *  @var $participantGroups   array of array of Participant
 *  @var $authorGroups array of array of Author
 */
$imgs=array('doc'=>'word.gif','rtf'=>'word.gif','txt'=>'text.gif','pdf'=>'pdf.gif','tex'=>'tex.gif','ppt'=>'pptx.gif','rar'=>'zip.gif','zip'=>'zip.gif');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php $baseUrl=''; if (Yii::app()->theme){$baseUrl = Yii::app()->theme->baseUrl;}; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/main.css?v=1" />
    </head>
    <body class="export">
        <h1><?php echo $conf->title();?></h1>
        <?php
        $groupCount=count(array_keys($topicGroups));
        foreach($topicGroups as $group => $topics) { ?>
            <?php if($groupCount>1) {?><h2> <?php echo $group;?></h2> <?php }?>
            <?php foreach($topics as $topic) {?>
        <h3 class="export-topic"><?php echo $topic->title();?></h3>
        <ol>
                    <?php
                    $participants=isset($participantGroups[$topic->id])?$participantGroups[$topic->id]:array();
                    for($i=0; $i< count($participants);$i++) {
                        $participant=$participants[$i];
                        ?>
            <li>
                <span class="export-participant"><?php echo $participant->title();?></span>
                            <?php  
                            echo '<br ><span class="export-author">'.$participant->authorNames().'</span>';
                            $supervisor=$participant->supervisor();
                            if(!empty($supervisor)) {
                                echo '<br >'.Yii::t('participants','Supervisor').':&nbsp;'.$supervisor;
                            };
                            ?>
                            <?php
                                $img = '';
                                $file=$participant->getFile();
                                if($file){
                                    $img=$imgs[$file->extension()];
                                };
                            ?>
                            <?php if(!empty($img)) { ?>
                                <br />
                                <?php $baseUrl = ''; if (Yii::app()->theme) {$baseUrl = Yii::app()->theme->baseUrl;}; echo CHtml::image($baseUrl . '/images/'.$img); ?>&nbsp;
                                <?php echo CHtml::link(CHtml::encode(Yii::t('participants','Full Text')),$file->url());?>
                                <?php } else {?>
                                <?php $content=$participant->content();?>
                                <?php if (!empty($content) || $participant->hasFile() ) {?>
                                    <?php $baseUrl = ''; if (Yii::app()->theme) {$baseUrl = Yii::app()->theme->baseUrl;}; echo '<br />'.CHtml::image($baseUrl . '/images/web.gif'); ?>&nbsp;
                                    <?php echo CHtml::link( CHtml::encode(Yii::t('participants','Full Text')),$this->createUrl('participant/view',array('urn'=>$conf->urn(),'participant_urn'=>$participant->urn()))); ?>
                                  <?php }?>
                                <?php }?>
                                    <br /><br />
            </li>
                        <?php }?>
        </ol>
                <?php }?>

            <?php } ?>

    </body>
</html>
<?php ?>
