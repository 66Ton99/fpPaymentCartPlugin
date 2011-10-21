<?php sfContext::getInstance()->getConfiguration()->loadHelpers(array('Number'));
use_helper('jQuery');
use_stylesheet(sfConfig::get('fp_payment_cart_css'));
$object = $item->getProduct();
$currency = fpPaymentCartContext::getInstance()->getPriceManager()->getCurrency();
?>
<td>
  <?php include_partial(sfConfig::get('fp_payment_cart_object_partial', 'fpPaymentCart/product'), array('object' => $object)) ?>
</td>
<td>
 <?php echo format_currency($object->getPrice(), $currency) ?>
</td>
<td>
  <input id="<?php echo $item->getId() ?>" onblur="changeQuantity(this)" value="<?php echo $item->getQuantity() ?>" />
</td>
<td>
  <?php echo format_currency($item->getQuantity() * $object->getPrice(), $currency); ?>
</td>
<td>
  <?php include_component('fpPaymentCart',
        									'icon',
                          array('action' => 'delete',
                          			'id' => $item->getId(),
                          			'update' => $update,
                          			'object_id' => $object->getId())) ?>
</td>