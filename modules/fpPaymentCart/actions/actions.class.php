<?php

/**
 * Cart actions.
 *
 * @package    fpPayment
 * @subpackage Cart
 */
class fpPaymentCartActions extends sfActions
{
  
  protected function renderEditBox($request, $id) {
    if ($request->getParameter('view') != '') {
      return $this->renderComponent('fpPaymentCart',
      														  'editbox',
                                    array('id' => $id, 
                                          'actions' => array('add', 'delete'), 
                                          'view' => $request->getParameter('view')));
    } else {
      return $this->renderComponent('fpPaymentCart',
      														  'editbox',
                                    array('id' => $id, 
                                          'actions' => array('add', 'show')));
    }
  }
  
  /**
   * Add item to the cart
   *
   * @param sfWebRequest $request
   *
   * @return
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
    return $this->renderEditBox($request, $id);
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
    return $this->renderEditBox($request, $id);
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
    return $this->renderEditBox($request, $id);
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
