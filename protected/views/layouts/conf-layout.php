<?php /* @var $this Controller */ ?>
<?php 
$confMenuTitle = $this->confMenuTitle;
if(empty($confMenuTitle)){
    $confMenuTitle = Yii::t('site','About conference');
};
$this->beginContent('//layouts/main'); ?>
    <div class="menu-column">
        <div id="conf-menu" class="conf-menu">
            <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                    'title'=>$confMenuTitle,
            ));
            $this->widget('zii.widgets.CMenu', array(
                    'items'=>$this->confMenu,
                    'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
            ?>
        </div>
        <?php if(!empty($this->adminMenu)) {?>
        <div id="admin-menu" class="admin-menu">
                <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                        'title'=>Yii::t('admin','Conference administration'),
                ));
                $this->widget('zii.widgets.CMenu', array(
                        'items'=>$this->adminMenu,
                        'htmlOptions'=>array('class'=>'operations'),
                ));
                $this->endWidget();
                ?>
        </div>
            <?php }?>
    </div>
    <div class="conf-column">
            <?php echo $content; ?>
    </div>
<?php $this->endContent(); ?>