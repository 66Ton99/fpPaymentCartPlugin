<?php

/**
 * Doctrine extension fpPaymentCartable listener
 *
 * @package    fpPayment
 * @subpackage Cart
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class Doctrine_Template_Listener_fpPaymentCartable extends Doctrine_Record_Listener
{

  public function __construct($options = array())
  {
    $this->_options = $options;
  }

  public function postDelete(Doctrine_Event $event)
  {
    $event->getInvoker()->getAllCart()->clear();
  }
}