<?php

/**
 * Cart actions.
 *
 * @package    fpPayment
 * @subpackage Cart
 */
class fpPaymentCartActions extends sfActions
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
   * @param sfWebRequest $request
   * @param string $id
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
   * Delete
   *
   * @param sfWebRequest $request
   *
   * @return void
   */
  public function executeDelete(sfWebRequest $request)
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
