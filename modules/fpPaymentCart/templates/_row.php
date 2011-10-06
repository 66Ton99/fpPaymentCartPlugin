<?php sfContext::getInstance()->getConfiguration()->loadHelpers(array('Number'));
$object = $item->getProduct();
$currency = fpPaymentCartContext::getInstance()->getCurrency();
?>

<td>
  <b><?php echo $object->getName() ?></b>
</td>
<td>
  <?php echo $item->getQuantity() .
  						'x' .
              format_currency($object->getPrice(), $currency)  . 
              ' = ' .
              format_currency($item->getQuantity() * $object->getPrice(), $currency); ?>
</td>
<td>
  <?php include_component('fpPaymentCart',
  												'editbox',
                          array('id' => $id,
                                'actions' => array('add', 'delete'),
                                'el' => 'cart_row_' . $id)) ?>
</td>