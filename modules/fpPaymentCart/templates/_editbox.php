<?php  /* INCLUDE THE JQUERY LIBRARY FROM THE sfJQueryReloadedPlugin HELPER*/
use_helper('jQuery');
use_stylesheet(sfConfig::get('fp_payment_cart_css'));
?>
<div id="cartbody">
  <?php
  foreach ($actions as $action) {
    include_component('fpPaymentCart',
    									'icon',
                      array('action' => $action,
                      			'id' => $id,
                      			'object_id' => $object_id,
                      			'object_class_name' => $object_class_name,
                            'extUrl' => $view));
  } ?>
</div>