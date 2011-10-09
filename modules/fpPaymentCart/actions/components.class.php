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
    if (empty($this->id) && !empty($this->object_id)) {
      $this->id = $this->object_id;
    }
    foreach (array('el', 'object_id', 'object_class_name') as $val) {
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
    if (!isset($this->el)) {
      $this->el = null;
    }
  }
  
  public function executeIcon()
  {
    if (empty($this->extUrl)) {
      $this->extUrl = null;
    }
    /* GET THE CONFIG */
    $this->images = sfConfig::get('fp_payment_cart_images');
    $this->labels = sfConfig::get('fp_payment_cart_labels');
    $this->path = sfConfig::get('fp_payment_cart_images_path');
    
    if ('new' == $this->action) {
      $this->extUrl .= "&object_id={$this->object_id}";
    }
  }
}
