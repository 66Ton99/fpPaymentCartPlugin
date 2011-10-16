<?php

/**
 * Cart holder
 * 
 * @package    fpPayment
 * @subpackage Cart
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 * 
 * @property $object fpPaymentHolderBase
 * 
 * @method fpPaymentCart[] getAll()
 * @method fpPaymentCart getItemByObjId()
 * @method fpPaymentCart getItemById()
 * @method fpPaymentCartHolder addItemByObjId()
 * @method fpPaymentCartHolder removeItem()
 * @method fpPaymentCartHolder clear()
 * @method bool isEmpty()
 */
class fpPaymentCartHolder
{
  
  /**
   * Holder storage
   *
   * @var fpPaymentHolderBase
   */
  protected $object = null;

  /**
   * Constructor
   * 
   * @param fpPaymentCartHolderBase $object
   */
  function __construct(fpPaymentCartHolderBase $object)
  {
    $this->object = $object;
  }
  
  /**
   * Magic method
   *
   * @param string $method
   * @param array $params
   * 
   * @throws sfException
   *
   * @return mixed
   */
  public function __call($method, $params)
  {
    if (!method_exists($this->object, $method)) {
      throw new sfException("Called not exist method '{$method}'");
    }
    $return = call_user_func_array(array($this->object, $method), $params);
    if ($return instanceof fpPaymentHolderBase) {
      return $this;
    }
    return $return;
  }
}