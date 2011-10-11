<?php sfContext::getInstance()->getConfiguration()->loadHelpers(array('Number'));
if(count($cart) <= 0) {
  echo "Cart is empty";
  return;
} ?>
<table>
  <caption></caption>
  <thead>
    <tr>
      <th>Name</th>
      <th>Price</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($cart as $item) { /* @var $item fpPaymentCart */ ?>
    <tr id="cart_row_<?php echo $item->getId()?>">
      <?php include_component('fpPaymentCart', 'row', array('item' => $item, 'id' => $item->getId())); ?>
    </tr>
  <?php }?>
  <tr>
    <td></td>
    <td>
      Sum: <?php echo format_currency(fpPaymentCartContext::getInstance()->getSum(),
                                      fpPaymentCartContext::getInstance()->getCurrency()) ?>
    </td>
  </tr>
  </tbody>
</table>

<?php echo link_to('Checkout', $checkout_route) ?>