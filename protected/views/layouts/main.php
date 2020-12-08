<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <?php echo '<base href="'.$this->createAbsoluteUrl('/').'/" />'; ?>
        <?php $baseUrl = ''; if(Yii::app()->theme != NULL){ $baseUrl = Yii::app()->theme->baseUrl; } ?>    
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/main.css?v=12" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/column1.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/conf.css?v=5" />
        <link rel="icon" href="<?php echo $baseUrl; ?>/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo $baseUrl; ?>/images/favicon.ico" type="image/x-icon" />


        <title><?php echo CHtml::encode($this->pageTitle); ?></title>


    </head>

    <body>

        <div id="page">

            <div id="header">
                <table >
                    <tr >
                        <td >
                            <div id="logo" ><?php echo CHtml::link(Yii::t('site',CHtml::encode(Yii::app()->name)), array(Yii::app()->homeUrl) ,array('class'=>'home-link'));  ?></div>
                        </td>
                        <td class="right">
                            <?php
                                $currentLanguages = $this->getCurrentLanguages();
                                if(count($currentLanguages)==1){ $currentLanguages=array();};
                                if(!empty($currentLanguages)) {
                            ?>
                            <span class="languages">
                                <?php
                                foreach($currentLanguages as $language => $name) {
                                    $linkName=Yii::app()->params['languages'][$language];
                                    if($language==Yii::app()->language) {
                                        echo '&nbsp;' .$linkName . '&nbsp;';
                                    }else {
                                        //echo CHtml::link($img, array('site/language','language'=>$lang));
                                        $requestUri=Yii::app()->request->requestUri;      
                                        $path=explode('/',$requestUri);
                                        if(in_array($path[1], array_keys(Yii::app()->params['languages']))){
                                            array_shift($path);
                                            array_shift($path);
                                            $requestUri='/'.implode('/',$path);
                                        };   
                                        if($requestUri=='/'){
                                            $requestUri='';
                                        };
                                        if($language==Yii::app()->params['mainLanguage']){
                                            $language='';
                                            if($requestUri==''){
                                                $language='/';  
                                            };
                                        }else{
                                            $language='/'.$language;
                                        };                                       
                                        echo '&nbsp;' . CHtml::link($linkName, Yii::app()->request->baseUrl.$language.$requestUri) .'&nbsp;';
                                    }
                                }
                                ?>
                            </span>
                            <?php }; ?>
                            <br class="clear"/>
                            <div class="login-form">
                                <?php if(Yii::app()->user->isGuest) {
                                    $form=$this->beginWidget('ActiveForm',array('action'=>$this->createUrl('site/login')));
                                    $model=new LoginForm;
                                    echo $form->label($model,'email').'&nbsp;';
                                    echo $form->textField($model,'email',array('size'=>20,'maxlength'=>100));
                                    echo '&nbsp;'.$form->label($model,'password').'&nbsp;';
                                    echo $form->passwordField($model,'password',array('size'=>15,'maxlength'=>50));
                                    echo $form->honeypot($model, 'ukazhite_e_mail');
                                    echo '&nbsp;'. CHtml::submitButton(Yii::t('actions','Login'));                                  
                                    $this->endWidget();
                                    echo '<div class="links">';
                                    echo CHtml::link(Yii::t('users','Password recovery'),array('/user/lostpassword'));
                                    echo '&nbsp;&nbsp;&nbsp;';
                                    echo CHtml::link(Yii::t('confs','Registration'),array('/user/register'));
                                    echo '</div>';
                                }else {
                                    echo '<div class="links">';
                                    echo CHtml::link(Yii::t('users','Logout').' ('.Yii::app()->user->name.')',array('/site/logout'));
                                    echo '</div>';
                                }?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div><!-- header -->

            <div id="mainmenu">
                <?php 
                     $menuItems = $this->userMenu;
                     $menuItems = array_splice($menuItems,0,8);
                     $this->widget('zii.widgets.CMenu',array('items'=>$menuItems)); 
                ?>
            </div><!-- mainmenu -->
            <?php if(isset($this->breadcrumbs)):?>
                <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                        'links'=>$this->breadcrumbs,
                        'homeLink' => CHtml::link(Yii::t('site','Home'), array(Yii::app()->homeUrl)),
                )); ?><!-- breadcrumbs -->
            <?php endif?>

            <div id="content">
                <?php echo $content; ?>
            </div>

            <div class="clear"></div>

            <div id="footer">
                &copy; <?php echo date('Y'); ?>. <?php echo Yii::t('site','The site is designed for conferences in the city of Bugulma, as well as');?><br /> 
                <?php echo Yii::t('site','<a href="https://translate.google.com/translate?hl=ru&sl=ru&tl=en&u=http://bumate.ru">Bugulma Engineering College</a>');?>.<br />
                <?php echo Yii::t('site','E-mail') .': abzalovailvin@gmail.com' .  StringUtils::hideEmail(Yii::app()->params['adminEmail']) .'&nbsp;&nbsp;&nbsp;';?>
                <?php echo Yii::t('site','Phone').': 89297272909' . Yii::app()->params['adminPhone'];?><br />
                <?php //echo Yii::powered(); ?>
            </div><!-- footer -->

        </div><!-- page -->

        <?php if(!Yii::app()->user->checkAccess('admin') && !empty(Yii::app()->params['GAProperty'])) {?>
            <?php Yii::app()->clientScript->registerScriptFile('/js/urchin.js'); ?>
        <script type="text/javascript">
            _uacct = "<?php echo Yii::app()->params['GAProperty'];?>";
            urchinTracker();
        </script>
            <?php };?>

    </body>
</html>
