<?php

/**
 * Cart actions.
 *
 * @package    fpPayment
 * @subpackage Cart
 */
class fpPaymentCartActionsBase extends sfActions
{
  
	/**
   * Add item to the cart
   *
   * @param sfWebRequest $request
   *
   * @return sfView::NONE
   */
  public function executeNew(sfWebRequest $request)
  {
    $objectId = $request->getParameter('object_id');
    $objectClassName = $request->getParameter('object_class_name');
    fpPaymentCartContext::getInstance()
      ->getHolder()
      ->addItemByObjId($objectId);
    return sfView::NONE;
  }
  
  /**
   * Render row
   * 
   * @return sfView::NONE
   */
  protected function renderRow() {
    return $this->renderComponent('fpPaymentCart',
    														  'box',
                                  array());
  }
  
  /**
   * Add
   *
   * @param sfWebRequest $request
   *
   * @return void
   */
  public function executeAdd(sfWebRequest $request)
  {
    $this->id = $request->getParameter('id');
    fpPaymentCartContext::getInstance()->getHolder()->addItemById($this->id);
    return $this->renderRow();
  }
  
	/**
   * Set quantity
   *
   * @param sfWebRequest $request
   *
   * @return void
   */
  public function executeSetQuantity(sfWebRequest $request)
  {
    $this->id = $request->getParameter('id');
    $quantity = (int)$request->getParameter('quantity', 1);
    fpPaymentCartContext::getInstance()->getHolder()->setQuantity($this->id, $quantity);
    return $this->renderRow();
  }

  /**
   * Delete one product item
   *
   * @param sfWebRequest $request
   *
   * @return void
   */
  public function executeDelete(sfWebRequest $request)
  {
    $this->id = $request->getParameter('id');
    fpPaymentCartContext::getInstance()->getHolder()->deleteItem($this->id);
    return $this->renderRow();
  }
  
	/**
   * Remove one cart item
   *
   * @param sfWebRequest $request
   *
   * @return void
   */
  public function executeRemove(sfWebRequest $request)
  {
    $this->id = $request->getParameter('id');
    fpPaymentCartContext::getInstance()->getHolder()->removeItem($this->id);
    return $this->renderRow();
  }

  /**
   * Show
   *
   * @param sfWebRequest $request
   *
   * @return void
   */
  public function executeShow(sfWebRequest $request)
  {
  }

}
