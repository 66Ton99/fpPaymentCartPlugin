<?php

/**
 * Cart holder
 * 
 * @package    fpPayment
 * @subpackage Cart
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 * 
 * @method getAll()
 * @method getItemByObjIdAndObjClassName()
 * @method getItemById()
 * @method addItemById()
 * @method addItemByObjIdAndObjClassName()
 * @method removeItem()
 * @method clear()
 * @method isEmpty()
 */
class fpPaymentHolder
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
   * @return void
   */
  function __construct(fpPaymentHolderBase $object)
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
    return call_user_func_array(array($this->object, $method), $params);
  }
}