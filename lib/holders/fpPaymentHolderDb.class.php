<?php

/**
 * DB holder
 *
 * @package    fpPayment
 * @subpackage Cart
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class fpPaymentHolderDb extends fpPaymentHolderBase
{
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::getAll()
   */
  public function getAll()
  {
    $user = $this->getContext()->getUser();
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
   * @see fpPaymentHolderBase::getItemByObjIdAndObjClassName()
   */
  public function getItemByObjIdAndObjClassName($objectId, $objectClassName)
  {
    $user = $this->getContext()->getUser();
    return fpPaymentCartTable::getInstance()->getItem($objectId, $objectClassName, $user->getId());
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
  public function addItemByObjIdAndObjClassName($objectId, $objectClassName)
  {
    if ($item = $this->getItemByObjIdAndObjClassName($objectId, $objectClassName)) {
      $item->setQuantity($item->getQuantity() + 1);
      $item->save();
    } else {
      fpPaymentCartTable::getInstance()->addNewItem($objectId, $objectClassName, $this->getContext()->getUser()->getId());
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
    fpPaymentCartTable::getInstance()->clearCustomerCart($this->getContext()->getUser()->getId());
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
      ->addWhere('customer_id = ?', $this->getContext()->getUser()->getId())
      ->count();
  }
  
}
