<?php

/**
 * Cart components
 *
 * @package    fpPayment
 * @subpackage Cart
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 *
 */
class fpPaymentCartComponents extends sfComponents
{

  public function executeEditbox()
  {
    foreach (array('id', 'object_id', 'object_class_name', 'view') as $val) {
      if (!isset($this->$val)) {
        $this->$val = null;
      } 
    }
    if(!(!sfConfig::get('fp_payment_cart_login_strict_mode') || $this->getUser()->isAuthenticated())) {
      return sfView::NONE;
    }
  }
  
  public function executeRow()
  {
  }
  
  public function executeIcon()
  {
    /* GET THE CONFIG */
    $tables = sfConfig::get('fp_payment_cart_object_classes_names');
    $simpleMode = false;
    if (1 < count($tables)) {
      $simpleMode = true;
      if (false === array_search($this->object_class_name, $tables)) {
        throw new sfException("Class '{$this->object_class_name}' don't find in the config");
      }
    }
    $this->images = sfConfig::get('fp_payment_cart_images');
    $this->labels = sfConfig::get('fp_payment_cart_labels');
    $this->path = sfConfig::get('fp_payment_cart_images_path');
    
    if (isset($this->extUrl)) {
        $this->extUrl = '&view=row';
        $this->el = "actions_{$this->id}";
    } else {
        $this->extUrl = '' ;
        $this->el = 'cartbody';
    }
    if ('new' == $this->action) {
      $this->extUrl .= "&object_id={$this->object_id}";
      if ($simpleMode) {
       
        $this->extUrl .= "&object_class_name={$this->object_class_name}";
      }
    }
  }
}
