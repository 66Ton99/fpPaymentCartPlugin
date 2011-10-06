<?php

/**
 * Cart holder
 * 
 * @package    fpPayment
 * @subpackage Cart
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 * 
 * @method fpPaymentCart[] getAll()
 * @method fpPaymentCart getItemByObjIdAndObjClassName()
 * @method fpPaymentCart getItemById()
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
   * @return void
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
    return call_user_func_array(array($this->object, $method), $params);
  }
  
  /**
   * @see fpPaymentCartHolderBase::addItemById()
   *
   * @return fpPaymentCartHolder
   */
  public function addItemById($id)
  {
    $this->object->addItemById($id);
    return $this;
  }
  
  /**
   * @see fpPaymentCartHolderBase::addItemByObjIdAndObjClassName()
   *
   * @return fpPaymentCartHolder
   */
  public function addItemByObjIdAndObjClassName($objectId, $objectClassName)
  {
    $this->object->addItemByObjIdAndObjClassName($objectId, $objectClassName);
    return $this;
  }
  
	/**
   * @see fpPaymentCartHolderBase::removeItem()
   *
   * @return fpPaymentCartHolder
   */
  public function removeItem($id)
  {
    $this->object->removeItem($id);
    return $this;
  }
  
	/**
   * @see fpPaymentCartHolderBase::clear()
   *
   * @return fpPaymentCartHolder
   */
  public function clear()
  {
    $this->object->clear();
    return $this;
  }
}