<?php sfContext::getInstance()->getConfiguration()->loadHelpers(array('Number'));
$object = $item->getProduct();
$currency = fpPaymentCartContext::getInstance()->getCurrency(); ?>
<tr>
  <td>
    <b><?php echo $object->__toString() ?></b><br />
    <?php echo $object->getDescription() ?>
  </td>
  <?php if ($object->getPrice()) { ?>
    <td>
      <?php echo $item->getQuantity() .
      						"x" .
                  format_currency($object->getPrice(), $currency)  . 
                  " = " .
                  format_currency($item->getQuantity() * $object->getPrice(), $currency); ?>
    </td>
  <?php } ?>
    <td id="actions_<?php echo $id?>">
      <?php include_component('fpPaymentCart',
      												'editbox',
                              array('id' => $id,
                                    'actions' => array('add', 'delete'),
                                    'view' => 2)) ?>
    </td>
</tr>