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
  
  protected $customer;
  
  protected $cartHolder;
  
  protected $holderToManagerHashes;
  
  /**
   * Return singleton
   *
   * @return fpPaymentCartContext
   */
  public static function getInstance()
  {
    if (empty(static::$instance)) {
      $class = sfConfig::get('fp_payment_cart_context_class_name', 'fpPaymentCartContext');
      static::$instance = new $class();
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
      ->disconnect('fp_payment_order.after_create',
                   array(fpPaymentOrderItemTable::getInstance(), 'saveCartItemsToOrderItems'));
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
      ->connect('fp_payment_order.after_create',
                array(fpPaymentOrderItemTable::getInstance(), 'saveCartItemsToOrderItems'));
    
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
  public function getCustomer()
  {
    if (empty($this->customer)) {
      $this->customer = fpPaymentFunctions::getObjFromConfig('fp_payment_cart_customer_callback',
                                                         array('function' => 'fpPaymentContext::getInstance',
                                                               'parameters' => array(),
                                                               'subFunctions' => array('getCustomer')));
    }
    return $this->customer;
  }
  
  /**
   * Return cart holder
   *
   * @return fpPaymentCartHolder
   */
  public function getHolder()
  {
    if (empty($this->cartHolder)) {
      $holders = sfConfig::get('fp_payment_cart_holders',
                               array('authenticated' => array('class' => 'fpPaymentCartHolderDb'),
                                     'not_authenticated' => array('class' => 'fpPaymentCartHolderSession'),
                                     'decorator' => 'fpPaymentCartHolder'));
      if (sfContext::getInstance()->getUser()->isAuthenticated()) {
        $class = $holders['authenticated']['class'];
        $object = new $class();
      } else {
        $class = $holders['not_authenticated']['class'];
        $object = new $class();
      }
      $class = $class = $holders['decorator'];
      $this->cartHolder = new $class($object);
    }
    return $this->cartHolder;
  }

  protected function fillPriceManager()
  {
    /* @var $item fpPaymentCart */
    foreach ($this->getHolder()->getAll() as $item) {
      new fpPaymentPriceManagerItem($this->getContext()->getPriceManager(),
                                    $item->getProduct(),
                                    $item->getQuantity());
    }
  }
  
  /**
   * Get Price Manager 
   * 
   * @return fpPaymentPriceManager
   */
  public function getPriceManager()
  {
    $priceManager = $this->getContext()->getPriceManager();
    $priceManagerMd5 = md5(serialize($priceManager));
    $cartItems = $this->getHolder()->getAll();
    $cartItemsMd5 = md5(serialize($cartItems));

    if (!empty($this->holderToManagerHashes[$cartItemsMd5])) {
      if ($this->holderToManagerHashes[$cartItemsMd5] != $priceManagerMd5) {
        $this->fillPriceManager();
      }
    } else {
      $this->fillPriceManager();
    }
    $this->holderToManagerHashes[$cartItemsMd5] = md5(serialize($priceManager));
    return $priceManager;
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
  
  /**
   * Get Payment context
   *
   * @return fpPaymentContext
   */
  protected function getContext()
  {
    return fpPaymentContext::getInstance();
  } 
}