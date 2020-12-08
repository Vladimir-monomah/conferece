<?php

/**
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class ActiveRecord extends CActiveRecord {

    public function __set($name, $value) {
        $behaviors = $this->behaviors();
        $propertyExists = false;

        //  если подключено поведение FilesBehavior
        //  считаем, что определены свойства setXXX,
        //  где XXX перечислено в поведении в поле files
        //  if FilesBehavior is attached then 
        //  returning that file properties exist in the object
        if (isset($behaviors['FilesBehavior'])) {
            if ($this->hasFileAttr($name)) {
                $propertyExists = true;
            };
        }

        if (!$propertyExists) {
            parent::__set($name, $value);
        }
    }

    public function __isset($name) {
        $behaviors = $this->behaviors();
        if (isset($behaviors['FilesBehavior'])) {
            if ($this->hasFileAttr($name)) {
                return true;
            };
        }

        return parent::__isset($name);
    }

    /* все ломается, если раскомментировать
     * видимо при инициализации объекта
     * методы поведения подключаются позже
     
      it breakes the application if uncomment these lines
       
      public function __get($name) {
      $behaviors=$this->behaviors();
      if(isset($behaviors['FilesBehavior'])) {
      if($this->hasFile($name)) {
      return $this->getFiles($name);
      };
      }
      return parent::__get($name);
      }

     */
}

?>
