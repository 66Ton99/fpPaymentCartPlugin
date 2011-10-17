<?php sfContext::getInstance()->getConfiguration()->loadHelpers(array('Number'));
use_helper('jQuery');
use_javascript(sfConfig::get('fp_payment_cart_js'));
use_javascript(sfConfig::get('fp_payment_cart_js_overlay'));
if(count($cart) <= 0) {
  echo "Cart is empty";
  return;
} ?>
<script type="text/javascript">
<!--
  var $fp_payment_cart_url_set_quntity = '<?php echo url_for('@fpPaymentCartPlugin_setQuantity') ?>'; 
//-->
</script>
<table class="fp_payment_cart_table">
  <caption></caption>
  <thead>
    <tr>
      <th>Product</th>
      <th>Unit Price</th>
      <th>Qty</th>
      <th>Subtotal</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($cart as $item) { /* @var $item fpPaymentCart */ ?>
    <tr id="cart_row_<?php echo $item->getId()?>">
      <?php include_component('fpPaymentCart','row', array('item' => $item,
      																										 'id' => $item->getId(),
      																										 'update' => 'fp_payment_cart_box')); ?>
    </tr>
  <?php }?>
  <?php if ($tax = fpPaymentCartContext::getInstance()->getPriceManager()->getTaxValue()) { ?>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>
        Tax: <?php echo format_currency($tax, fpPaymentCartContext::getInstance()->getCurrency()) ?>
      </td>
    </tr>
  <?php }?>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td>
      Sum: <?php echo format_currency(fpPaymentCartContext::getInstance()->getPriceManager()->getSum(),
                                      fpPaymentCartContext::getInstance()->getCurrency()) ?>
    </td>
  </tr>
  </tbody>
</table>

<?php echo link_to('Checkout', '@fpPaymentPlugin_checkout') ?>