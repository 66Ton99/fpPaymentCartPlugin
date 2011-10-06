<h1>Cart</h1>
<?php if(count($cart)<=0){
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
  <?php foreach ($cart as $item) { /* @var $item fpPaymentCart */
    include_component('fpPaymentCart', 'row', array('item' => $item, 'id' => $item->getId()));
  }?>
  </tbody>
</table>

<?php echo link_to('Checkout', $checkout_route) ?>