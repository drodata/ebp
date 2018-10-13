/**
 * SPU create / adject-specification
 */

$(function () {
// 'af' = active form
var af = $('#spu-form')
    , submitBtn = af.find('button[type=submit]')
    , propertySelect = af.find('.spu-property')
    , properties = submitBtn.data('properties')
    , specifications = submitBtn.data('specifications')

// Event binding
propertySelect.on("select2:select select2:unselect", syncSpecificationSelect)
af.on("beforeSubmit", submitForm)

/**
 * 选择/反选属性选择器中的某个值后生成/删除对应的规格选择器
 *
 * 由 'select2:select' 或 'select2:unselect' 触发
 *
 * @param PlainObject param, 仅当通过 AJAX 临时新建属性时才会携带此参数，格式 {id: xx, name: 'xx'},
 * 分别表示新建属性的 id 和名称
 */
function syncSpecificationSelect (e, param) {

    // 反选直接删除对应的 form field
    if (e.type == "select2:unselect") {
        $('.field-commonform-' + e.params.data.id + '-specifications').remove()
        return
    }

    // 通过 AJAX 新建属性的方式选择属性
    if (typeof(param) == 'undefined') {
        var id = e.params.data.id
            , name = e.params.data.text
    } else {
        var id = param.id
            , name = param.name
    }
    var tpl = $('.spu-specification-tpl').html()
        , propertyMap = submitBtn.data('map')
    tpl = tpl.replace(/indextoken/g, id);
    tpl = tpl.replace(/LABEL/g, name);
    tpl = tpl.replace(/PARENT/g, id);
    $(tpl).appendTo($('.specification-container'));

    $("#commonform-" + id + "-specifications").select2({
        data: propertyMap[id],
        theme: 'krajee',
        placeholder: "请选择" + name,
        width:"100%",
    });
}
/**
 * AJAX 提交 SPU 表单
 */
function submitForm(e)
{
    submitBtn.prop('disabled', true)

    $.post(af.attr('action'), af.serialize(), function(response) {
        console.log(response)
        // 含有非法数据，显示错误提示
        if (!response.status) {
            af.displayErrors(response)
            return false;
        }

        // 提交成功
        $(response.message).insertAfter(submitBtn);

        setInterval(function(){
            window.location.href = response.redirectUrl;
        },1000);
    }).fail(ajax_fail_handler).always(function(){
        submitBtn.prop('disabled', false)
    });

    // 禁用默认的提交行为
    return false
}

})
