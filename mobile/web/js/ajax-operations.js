/**
 * Global ajax operations
 */
$(function(){
    /* sample
    $(document).on('click', '.confirmOrder', function(e) {
        e.preventDefault();
        var loading = weui.loading('处理中', {
            className: 'custom-classname'
        });
        var orderId = $(this).data('id');
        var postData = {id: orderId};
        $.post(APP.baseUrl + 'confirm/ajax-confirm-creation', postData, function(response) {
            if (response.status) {
                if (response.hasUnconfirmed) {
                    $('[data-key=' + orderId + ']').slideUp();
                    weui.toast('已确认', 1000);
                } else {
                    weui.toast('所有订单已确认', {
                        duration: 1000,
                        callback: function(){
                            window.location.href = response.redirectUrl;
                        }
                    });
                }
            }
        }).fail(ajax_fail_handler).always(function(){
            loading.hide();
        });
    });
    */
});
