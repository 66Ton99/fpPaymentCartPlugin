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
      ->disconnect('fp_payment_order.befor_create', array($this, 'getPriceManager'));
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
      ->connect('fp_payment_order.befor_create', array($this, 'getPriceManager'));
    
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
      $functionsClassName = sfConfig::get('functions_class_name');
      $this->customer = $functionsClassName::getObjFromConfig('fp_payment_cart_customer_callback',
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

  /**
   * Fill fpPaymentPriceManager
   *
   * @param fpPaymentPriceManager $priceManager
   *
   * @return void
   */
  protected function fillPriceManager($priceManager)
  {
    /* @var $item fpPaymentCart */
    foreach ($this->getHolder()->getAll() as $item) {
      $priceItem = new fpPaymentPriceManagerItem($item->getProduct(), $item->getQuantity());
      $priceManager->addItem($priceItem);
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
        $this->fillPriceManager($priceManager);
      }
    } else {
      $this->fillPriceManager($priceManager);
    }
    $this->holderToManagerHashes[$cartItemsMd5] = md5(serialize($priceManager));
    return $priceManager;
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