<?php

/**
 * Base holder
 *
 * @package    fpPayment
 * @subpackage Cart
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
abstract class fpPaymentCartHolderBase
{

  /**
   * Get all items
   *
   * @return fpPaymentCart[] - array of objects of items
   */
  abstract public function getAll();
  
  /**
   * Get one cart item by object ID and object class name
   *
   * @param int $objectId
   * @param string $objectClassName
   *
   * @return fpPaymentCart
   */
  abstract public function getItemByObjIdAndObjClassName($objectId, $objectClassName);
  
  /**
   * Get one cart item by ID
   *
   * @param int $id
   *
   * @return fpPaymentCart
   */
  abstract public function getItemById($id);
  
  /**
   * Add item by id
   *
   * @param int $item
   *
   * @return fpPaymentHolderBase
   */
  abstract public function addItemById($id);
  
  /**
   * Add item to cart
   *
   * @param int $objectId
   * @param string $objectClassName
   *
   * @return fpPaymentHolderBase
   */
  abstract public function addItemByObjIdAndObjClassName($objectId, $objectClassName);
  
  /**
   * Remove item by id
   *
   * @param int $id
   *
   * @return fpPaymentHolderBase
   */
  abstract public function removeItem($id);

  /**
   * Clrear all cart content
   * 
   * @return fpPaymentHolderBase
   */
  abstract public function clear();
  
  /**
   * Check is empty cart or not 
   * 
   * @return bool
   */
  abstract public function isEmpty();

  /**
   * Context
   *
   * @return fpPaymentCartContext
   */
  protected function getContext()
  {
    return fpPaymentCartContext::getInstance();
  }
  
}
