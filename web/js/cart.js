function showOverlay($id) {
  $($id).overlay({
    effect: 'fade',
    color: '#ccc',
    glossy: false,
    container: $id,
    onShow: function() {
      $(this).click(function(evt) {
        evt.preventDefault();
      }).bind('contextmenu', function(evt) {
        evt.preventDefault();
      });
    }
  });
  $($id + ' div.overlay').addClass('cart_loader');
  $($id).removeClass('overlay-trigger');
}

function hideOverlay($id) {
  $($id).removeClass('overlay-trigger');
  $($id + ' div.cart_loader').remove();
}

function changeQuantity($e) {
  var $theCartElement = $($e).parent().parent().parent().parent().parent();
  showOverlay('#' + $theCartElement.attr('id'));
  jQuery.ajax({
    url: $fp_payment_cart_url_set_quntity,
    type: 'POST',
    dataType: 'html',
    success:  function(data, textStatus) {
      $theCartElement.html(data);
    },
    data: {
      id: $($e).attr('id'),
      quantity: $($e).val()
    }
  });
}