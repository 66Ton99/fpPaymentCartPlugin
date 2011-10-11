<div class="small cart">
  <?php
  /* MAKE THE IMAGE BUTTON */
  $img = '<img src="'.$path . $images[$action].'" title="'.$labels[$action].'"/>';?>

  <div class="cart_loader" id="loader_<?php echo $action . '_' . $id?>" title="<?php echo $labels['loader'] ?>">
      <img src="<?php echo $path . $images['loader'] ?>"/>
  </div>
  <?php

  /* MAKE THE AJAX LINK*/
  if ('show' == $action) { 
    echo link_to($img, url_for('@fpPaymentCartPlugin_show'));
  } else {
    $options = array('update' => $update,
                     'url' => url_for('@fpPaymentCartPlugin_' . $action)."?id=".$id.$extUrl,
                     'loading' => '$("#loader_' . $action . '_' . $id .'").show()' ,
                     'failure' => "alert('HTTP Error ' + request.status + '!')");
    if (empty($update)) {
      $options['success'] = '$("#loader_' . $action . '_' . $id .'").hide()';
    }
    echo jq_link_to_remote($img, $options);
  }?>
</div>