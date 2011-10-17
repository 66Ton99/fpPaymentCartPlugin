<?php use_helper('jQuery');
use_javascript(sfConfig::get('fp_payment_cart_js'));
use_javascript(sfConfig::get('fp_payment_cart_js_overlay'));
$idString = "fp_payment_cart_{$action}_{$id}";
 ?>
<div class="small cart" id="<?php echo $idString ?>">
  <?php

  /* MAKE THE AJAX LINK*/
  $img = '<img src="'.$path . $images[$action].'" title="'.$labels[$action].'"/>';
  if ('show' == $action) {
    echo link_to($img, url_for('@fpPaymentCartPlugin_show'));
  } else {
    $options = array('update' => $update,
                     'url' => url_for('@fpPaymentCartPlugin_' . $action)."?id=".$id.$extUrl,
                     'loading' => empty($update)?"showOverlay('#{$idString}')":"showOverlay('#{$update}')",
                     'failure' => "alert('HTTP Error ' + request.status + '!')");
    if (empty($update)) {
      $options['success'] = "hideOverlay('#{$idString}')";
    }
    echo jq_link_to_remote($img, $options);
  }?>
</div>