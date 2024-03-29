<?php

/**
 * Session holder
 *
 * @package    fpPayment
 * @subpackage Cart
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class fpPaymentCartHolderSession extends fpPaymentCartHolderBase
{
  
  protected $ns = null;
  
  /**
   * Save data to the DB
   * 
   * @param sfEvent $event
   *
   * @return fpPaymentHolderSession
   */
  public function saveData(sfEvent $event)
  {
    if (!$this->isEmpty() && $event['authenticated']) {
      fpPaymentCartTable::getInstance()->clearCustomerCart($this->getContext()->getCustomer()->getId());
      /* @var $item fpPaymentCart */
      foreach ($this->getAll() as $item) {
        $item->setId(null);
        $item->setCustomerId($this->getContext()->getCustomer()->getId());
        $item->save();
      }
      $this->clear();
    }
    return $this;
  }
  
  /**
   * Constructor
   *
   * @return void
   */
  public function __construct()
  {
    sfContext::getInstance()
      ->getEventDispatcher()
      ->connect('user.change_authentication', array($this, 'saveData'));
    $holders = sfConfig::get('fp_payment_cart_holders', array('not_authenticated' => array('session_ns' => 'fpPaymentCart')));
    $this->ns = $holders['not_authenticated']['session_ns'];
  }
  
  /**
   * NS anme
   *
   * @return string
   */
  public function getNs()
  {
    return $this->ns;
  }
  
  /**
   * Session holder
   *
   * @return sfNamespacedParameterHolder
   */
  protected function getSessionHolder()
  {
    return sfContext::getInstance()->getUser()->getAttributeHolder();
  }
  
  /**
   * Generate unique id for session key
   *
   * @return int
   */
  protected function generateId()
  {
    do {
      $id = time() + rand(0, 100);
    } while ($this->getSessionHolder()->has($id));
    return $id;
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::getAll()
   */
  public function getAll()
  {
    return $this->getSessionHolder()->getAll($this->getNs());
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::getItemById()
   */
  public function getItemById($id)
  {
    return $this->getSessionHolder()->get($id, null, $this->getNs());
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::getItemByObjId()
   */
  public function getItemByObjId($objectId)
  {
    foreach ($this->getAll() as $key => $val) {
      if ($val->getObjectId() == $objectId) {
        return $val;
      }
    }
    return null;
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::addItem()
   */
  public function addItemById($id)
  {
    /* @var $item fpPaymentCart */
    if ($item = $this->getItemById($id)) {
      $item->setQuantity($item->getQuantity() + 1);
      $this->getSessionHolder()->set($item->getId(), $item, $this->getNs());
    }
    return $this;
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::addItemToCart()
   */
  public function addItemByObjId($objectId)
  {
    $item = $this->getItemByObjId($objectId);
    if (empty($item)) {
      $item = new fpPaymentCart(); 
      $item->setObjectId($objectId)
        ->setQuantity(1)
        ->setId($this->generateId());
    } else {
      $item->setQuantity($item->getQuantity() + 1);
    }
    
    $this->getSessionHolder()->set($item->getId(), $item, $this->getNs());
    return $this;
  }
  
	/**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::addItemToCart()
   */
  public function setQuantity($id, $quantity)
  {
    /* @var $item fpPaymentCart */
    if (($item = $this->getItemById($id)) && 0 < (int)$quantity) {
      $item->setQuantity((int)$quantity);
      $this->getSessionHolder()->set($item->getId(), $item, $this->getNs());
      return $this;
    }
    return $this;
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::removeItem()
   */
  public function removeItem($id)
  {
    $item = $this->getItemById($id);
    if (1 >= $item->getQuantity()) {
      $this->getSessionHolder()->remove($id, null, $this->getNs());
    } else {
      $item->setQuantity($item->getQuantity() - 1);
      $this->getSessionHolder()->set($item->getId(), $item, $this->getNs());
    }
    return $this;
  }
  
	/**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::deleteItem()
   */
  public function deleteItem($id)
  {
    $this->getSessionHolder()->remove($id, null, $this->getNs());
    return $this;
  }

  /**
   * @return fpPaymentHolderDb
   */
  public function clear()
  {
    $this->getSessionHolder()->removeNamespace($this->getNs());
    return $this;
  }
  
  /**
   * (non-PHPdoc)
   * @see fpPaymentHolderBase::isEmpty()
   */
  public function isEmpty()
  {
    $items = $this->getAll();
    return empty($items);
  }
}
