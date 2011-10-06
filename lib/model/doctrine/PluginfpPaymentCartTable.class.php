<?php

/**
 * PluginfpPaymentCartTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class PluginfpPaymentCartTable extends Doctrine_Table
{
  
  const MODEL_NAME = 'fpPaymentCart';

  /**
   * Returns an instance of this class.
   *
   * @return object fpPaymentCartTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable(static::MODEL_NAME);
  }
  
  /**
   * prepareItemsQuery 
   *
   * @param int $userId
   * @param string $objectId
   * @param int $objectClassName
   *
   * @return Doctrine_Query
   */
  protected function prepareItemsQuery($userId, $objectId = null, $objectClassName = null)
  {
    $tables = sfConfig::get('fp_payment_cart_object_classes_names');
    $query = $this->createQuery('c')
      ->andWhere('c.customer_id = ?', $userId);
    if (null !== $objectId) {
      
      $query->andWhere('c.object_id = ?', $objectId);
      if (1 < count($tables)) {
        $query->andWhere('c.object_class_name = ?', $objectClassName);
      }
    }
    if (1 == count($tables)) {
      $query->innerJoin('c.Product p');
    }
    return $query;
  }
  
  /**
   * Return item
   *
   * @param int objectId
   * @param string $objectClassName
   * @param int $userId
   *
   * @return fpPaymentCart
   */
  public function getItem($objectId, $objectClassName, $userId)
  {
    return $this->prepareItemsQuery($userId, $objectId, $objectClassName)->fetchOne();
  }
  
  /**
   * Return items
   *
   * @param int $userId
   *
   * @return mixed
   */
  public function getItems($userId)
  {
    return $this->prepareItemsQuery($userId)->execute();
  }
  
  /**
   * Add item to cart
   *
   * @param int $objectId
   * @param string $objectClassName
   * @param int $userId
   *
   * @return fpPaymentCart
   */
  public function addNewItem($objectId, $objectClassName, $userId)
  {
    $model = new fpPaymentCart();
    $model->setObjectId($objectId);
    if (method_exists($model, 'setObjectClassName')) {
      $model->setObjectClassName($objectClassName);
    }
    $model->setCustomerId($userId);
    $model->setQuantity(1);
    $model->save();
    return $model;
  }
  
	/**
   * Clear customer cart
   *
   * @param int $customerId
   *
   * @return bool
   */
  public function clearCustomerCart($customerId)
  {
    return $this->prepareItemsQuery($customerId)
      ->delete()
      ->execute();
  }
}