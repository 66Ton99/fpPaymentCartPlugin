<?php

/**
 * Cart context
 *
 * @package    fpPayment
 * @subpackage Cart
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class fpPaymentCartContext
{

  /**
   * Object instance
   *
   * @var fpPaymentContext
   */
  protected static $instance;
  
  protected $user;
  
  protected $cartHolder;
  
  /**
   * Return singleton
   *
   * @return fpPaymentCartContext
   */
  public static function getInstance()
  {
    if (empty(static::$instance)) {
      static::$instance = new self();
    }
    return static::$instance;
  }
  
  /**
   * Destroy object
   *
   * @return void
   */
  public function destroy()
  {
    sfContext::getInstance()
      ->getEventDispatcher()
      ->disconnect('fp_payment_order.after_create', array(fpPaymentOrderItemTable::getInstance(), 'saveCartItemsToOrderItems'));
    sfContext::getInstance()
      ->getEventDispatcher()
      ->disconnect('fp_payment_order.after_create', array($this->getHolder(), 'clear'));
    static::$instance = null;
  }
  
  /**
   * Constructor
   *
   * @return void
   */
  protected function __construct()
  {
    sfContext::getInstance()
      ->getEventDispatcher()
      ->connect('fp_payment_order.after_create', array(fpPaymentOrderItemTable::getInstance(), 'saveCartItemsToOrderItems'));
    
    // There must call $this->getHolder()
    sfContext::getInstance()
      ->getEventDispatcher()
      ->connect('fp_payment_order.after_create', array($this->getHolder(), 'clear'));
  }
  
  /**
   * Get user
   *
   * @throws sfException
   *
   * @return sfGuardUser
   */
  public function getUser()
  {
    if (empty($this->user)) {
      $this->user = fpPaymentFunctions::getObjFromConfig('fp_payment_cart_callback_user',
                                                         array('function' => 'fpPaymentContext::getInstance',
                                                               'parameters' => array(),
                                                               'subFunctions' => array('getUser', 'getGuardUser')));
    }
    return $this->user;
  }
  
  /**
   * Return cart holder
   *
   * @return fpPaymentHolderBase
   */
  public function getHolder()
  {
    if (empty($this->cartHolder)) {
      if (sfContext::getInstance()->getUser()->isAuthenticated()) {
        $class = sfConfig::get('fp_payment_cart_holders_class_authenticated_', 'fpPaymentHolderDb');
        $this->cartHolder = new $class();
      } else {
        $class = sfConfig::get('fp_payment_cart_holders_class_not_authenticated', 'fpPaymentHolderSession');
        $this->cartHolder = new $class();
      }
    }
    return $this->cartHolder;
  }

  /**
   * @return float
   */
  public function getSum()
  {
    $items = $this->getHolder()->getAll();
    $sum = 0.0;
    foreach ($items as $item) {
      /* @var $item fpPaymentCart */
      $sum += $item->getQuantity() * $item->getProduct()->getPrice();
    }
    return $sum;
  }
  
  /**
   * Retrun currency
   * 
   * @todo not implemented yet
   *
   * @return string
   */
  public function getCurrency()
  {
    return sfConfig::get('fp_payment_cart_currency', 'USD');
  }
  
  /**
   * Checks is empty cart or not
   *
   * @return bool
   */
  public function isEmpty()
  {
    return $this->getHolder()->isEmpty();
  }
}