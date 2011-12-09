<?php

/**
 * Cart holder decorator
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
 * @method fpPaymentCartHolder addItemById()
 * @method fpPaymentCartHolder setQuantity()
 * @method fpPaymentCartHolder deleteItem()
 * @method fpPaymentCartHolder removeItem()
 * @method fpPaymentCartHolder clear()
 * @method bool isEmpty()
 */
class fpPaymentCartHolder extends fpPaymentDecoratorBase
{

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
   * (non-PHPdoc)
   * @see fpPaymentDecoratorBase::__call()
   */
  public function __call($method, $params)
  {
    $return = parent::__call($method, $params);
    if ($return instanceof fpPaymentCartHolderBase) {
      return $this;
    }
    return $return;
  }
}