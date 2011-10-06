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
   * Get 
   *
   * @param int $userId
   * @param string $objectId
   * @param int $objectClassName
   *
   * @return Doctrine_Query
   */
  protected function prepareItemsQuery($userId, $objectId = null, $objectClassName = null)
  {
    $query = $this->createQuery('c')
      ->select('c.id, c.customer_id, c.object_id, c.object_class_name, c.quantity')
      ->andWhere('c.customer_id = ?', $userId);
    if (null !== $objectId && null !== $objectClassName) {
      $query->andWhere('c.object_id = ?', $objectId);
      $tables = sfConfig::get('fp_payment_cart_object_classes_names');
      if (1 < count($tables)) {
        $query->andWhere('c.object_class_name = ?', $objectClassName);
      }
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
    $model->setObjectClassName($objectClassName);
    $model->setCustomerId($userId);
    $model->setQuantity(1);
    $model->save();
    return $model;
  }
}