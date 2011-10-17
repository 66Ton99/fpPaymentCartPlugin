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
  abstract public function getItemByObjId($objectId);
  
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
  abstract public function addItemByObjId($objectId);
  
  /**
   * Delete cart item by id
   *
   * @param int $id
   *
   * @return fpPaymentHolderBase
   */
  abstract public function deleteItem($id);
  
  /**
   * Remove product item by id
   *
   * @param int $id
   *
   * @return fpPaymentHolderBase
   */
  abstract public function removeItem($id);
  
  /**
   * Sert items quantity
   *
   * @param int $id
   * @param int $quantity
   *
   * @return fpPaymentHolderBase
   */
  abstract public function setQuantity($id, $quantity);

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
