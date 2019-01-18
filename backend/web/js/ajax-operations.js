/**
 * Global ajax operations
 */
$(function(){
    
    // global modal show handler
    $(document).on('show.bs.modal', '.modal', function () {
        // enable nested bootstrap modal
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);

        // opt in tooltip and popover in modal
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    });

    /**
     * 全局防止重复提交表单
     *
     * 使用：在所需的表单上增加 .prevent-duplicate-submission 类名
     */
    jQuery('form.prevent-duplicate-submission').on('beforeSubmit', function(event){
        if(jQuery(this).data('submitting')) {
            event.preventDefault();
            return false
        }
    
        jQuery(this).data('submitting', true);
        return true;
    });

    /**
     * 将普通的 view action 改用在 Modal 内显示
     */
    $(document).on('click', '.modal-view', function(e) {
        e.preventDefault();

        var selecter = '#view-modal'
        $(this).tooltip('hide');

        var queryString = $(this).prop('href').split('?')[1];
        var slices = $(this).prop('href').split('?')[0].split('/');
        var controller = slices[slices.length - 2];
        var action = slices[slices.length - 1];
        var ajaxRoute = controller + '/modal-' + action + '?' + queryString;

        $.get(APP.baseUrl + ajaxRoute, function(response) {
            $(response).appendTo('body');
            $(selecter).modal('show')
        }).fail(ajax_fail_handler).always(function(){
            $(document).on('hide.bs.modal', selecter, function() {
                $(selecter).remove()
            });
        })
    });
    /**
     * 通用的高级搜索
     */
    $(document).on('click', '.modal-search', function(e) {
        e.preventDefault();

        var selecter = '#search-modal'
        $(this).tooltip('hide');

        $.get($(this).prop('href'), function(response) {
            $(response).appendTo('body');
            $(selecter).modal('show')
        }).fail(ajax_fail_handler).always(function(){
            $(document).on('hide.bs.modal', selecter, function() {
                $(selecter).remove()
            });
        })
    });

    // 在 Modal 内通过 AJAX 快速新增 Lookup 记录(仅 name 列)
    $(document).on('click', '.modal-create-lookup', function() {
        var scenario = $(this).data('scenario')
            , type = $(this).data('type')
        if (scenario == 'dropDown') {
            var $dropDown = $(this).parents('.input-group').first().find('select')
        }
	    $.get(APP.baseUrl + 'lookup/modal-create?type=' + type, function(response) {
            $(response).appendTo('body');

            var $modal = $('#' + type + '-modal')
                , selecter = '#lookup-quick-create-form'
                , $form = $(selecter)
                , $submitButton = $form.find('[type=submit]')
                , $firstElement = $('#lookup-name')

            $modal.modal({
                'keyboard': false,
                'backdrop': 'static',
            }).on('hidden.bs.modal', function (e) {
                $modal.remove();
            }).on('shown.bs.modal', function (e) {
                $firstElement.focus();
            });
        
            $form.submit(function(e) {
            	e.preventDefault();
            	e.stopImmediatePropagation();
            	$submitButton.prop('disabled',true)
            	$.post(APP.baseUrl + 'lookup/modal-create-submit', $form.serialize(), function(response) {
            		if (!response.status) {
                        $form.displayErrors(response)
                    } else {
                        $( response.message ).appendTo($submitButton.parent());

                        if (scenario == 'dropDown') {
                            $( response.entity ).appendTo($dropDown);
                            $dropDown.trigger('change');
                        }
                    
            			setTimeout(function(){
                            $modal.modal('hide');
            			},1000);
                    }
            	}).fail(ajax_fail_handler).always(function() {
            	    $submitButton.prop('disabled',false)
            	});
            }); //!submit event
        }); //!create modal fetch
    });

    /*
    $('#batch-print-shipment-btn').click(function(e){
        var ab = $(this); 
	    $('<span id="loading">' + APP.loadingText + '</span>').appendTo(ab);
        ab.prop('disabled',true);
        var postData = {ids: ab.data('ids')};
	    $.post(APP.baseUrl + 'order/ajax-batch-print-shipment', postData, function(response) {
            // higlight printed row
            $('#preparing-grid').find('tr').each(function(){
                var currentRow = $(this);
                if (in_array(currentRow.data('key'), ab.data('ids'))) {
                    currentRow.addClass('bg-success');
                }
            });
            // popup print dialog
            var pdf = new PdfUtil(APP.baseUrl + 'merged.pdf');
            pdf.display(document.getElementById('pdf-shipment-container'));
            pdf.print();
	    }).fail(ajax_fail_handler).always(function(){
		    ab.prop('disabled',false).find('#loading').remove();
        });
    });
    */
});
