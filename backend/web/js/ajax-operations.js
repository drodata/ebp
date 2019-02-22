/**
 * Global ajax operations
 */
$(function(){
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
