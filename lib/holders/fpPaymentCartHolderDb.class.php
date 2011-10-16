<?php

/**
 * DB holder
 *
 * @package    fpPayment
 * @subpackage Cart
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class fpPaymentCartHolderDb extends fpPaymentCartHolderBase
{
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::getAll()
   */
  public function getAll()
  {
    $user = $this->getContext()->getCustomer();
    return fpPaymentCartTable::getInstance()->getItems($user->getId());
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::getItemById()
   */
  public function getItemById($id)
  {
    return fpPaymentCartTable::getInstance()->findOneById($id);
  }
  
	/**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::getItemByObjId()
   */
  public function getItemByObjId($objectId)
  {
    $user = $this->getContext()->getCustomer();
    return fpPaymentCartTable::getInstance()->getItem($objectId, $user->getId());
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::addItem()
   */
  public function addItemById($id)
  {
    $item = $this->getItemById($id);
    if ($item) {
      $item->setQuantity($item->getQuantity() + 1);
      $item->save();
    }
    return $this;
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::addItemToCart()
   */
  public function addItemByObjId($objectId)
  {
    if ($item = $this->getItemByObjId($objectId)) {
      $item->setQuantity($item->getQuantity() + 1);
      $item->save();
    } else {
      fpPaymentCartTable::getInstance()->addNewItem($objectId, $this->getContext()->getCustomer()->getId());
    }
    return $this;
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::removeItem()
   */
  public function removeItem($id)
  {
    $item = fpPaymentCartTable::getInstance()->findOneById($id);
    if ($item) {
      if ($item->getQuantity() > 1) {
        $item->setQuantity($item->getQuantity() - 1);
        $item->save();
      } else {
        $item->delete();
      }
    }
    return $this;
  }

  /**
   * @return fpPaymentHolderDb
   */
  public function clear()
  {
    fpPaymentCartTable::getInstance()->clearCustomerCart($this->getContext()->getCustomer()->getId());
    return $this;
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::isEmpty()
   */
  public function isEmpty()
  {
    return !(bool)fpPaymentCartTable::getInstance()
      ->createQuery()
      ->addWhere('customer_id = ?', $this->getContext()->getCustomer()->getId())
      ->count();
  }
  
}
