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
    $id = fpPaymentCartContext::getInstance()
      ->getHolder()
      ->addItemByObjIdAndObjClassName($objectId, $objectClassName)
      ->getItemByObjIdAndObjClassName($objectId, $objectClassName)
      ->getId();
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
  protected function renderRow($request, $id) {
    $item = fpPaymentCartContext::getInstance()->getHolder()->getItemById($id);
    if (empty($item)) return sfView::NONE;
    return $this->renderComponent('fpPaymentCart',
    														  'row',
                                  array('id' => $id, 
                                        'actions' => array('add', 'delete'),
                                        'el' => 'cart_row_' . $item->getId(),
                                        'item' => $item));
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
    $id = $request->getParameter('id');
    fpPaymentCartContext::getInstance()->getHolder()->addItemById($id);
    return $this->renderRow($request, $id);
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
    $id = $request->getParameter('id');
    fpPaymentCartContext::getInstance()->getHolder()->removeItem($id);
    return $this->renderRow($request, $id);
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
    $this->cart = fpPaymentCartContext::getInstance()->getHolder()->getAll();
    $routes = sfConfig::get('fp_payment_cart_routes');
    $this->checkout_route = $routes['checkout'];
  }

}
