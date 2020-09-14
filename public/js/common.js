$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $(".btn-submit").off('click').click(function () {
        var call = $(this).attr('data-call');

        var method = $(this).attr('data-method') !== undefined ? $(this).attr('data-method') : 'GET';

        var url = $(this).attr('data-url') !== undefined ? $(this).attr('data-url') : '';

        var redirectUrl = $(this).attr('data-redirect-url') !== undefined ? $(this).attr('data-redirect-url') : '';

        var confirmMessage = $(this).attr('data-confirm-message') !== undefined ?
            $(this).attr('data-confirm-message') : '';

        var sucFunc = $(this).attr('data-suc-func');
        if (sucFunc === undefined) {
            sucFunc = function (data) {
                layer.msg(data.message, {
                    skin: 'layui-bg-green',
                    time: 1000
                }, function () {
                    if (redirectUrl !== '') {
                        window.location.href = redirectUrl;
                    } else if (data.hasOwnProperty('data') &&
                        data.data.hasOwnProperty('redirect_url') &&
                        data.data.redirect_url !== '') {
                        window.location.href = data.data.redirect_url;
                    } else {
                        location.reload();
                    }
                });
            };
        } else {
            sucFunc = eval(sucFunc);
        }

        let alertError = $(this).attr('data-alert-error') !== undefined ? $(this).attr('data-alert-error') : '';

        var data = {};

        if (call === 'form') {
            data = $($(this).attr('data-target-form')).serializeArray();
            url = $($(this).attr('data-target-form')).attr('action')
        }

        var loadingLayer = '';

        var closeLoadingLayer = function () {
            if (loadingLayer !== '') {
                layer.close(loadingLayer);
            }
        }

        var ajaxBeforeSend = function () {
            if (alertError !== '') {
                $(alertError).empty().hide();
            }
            loadingLayer = layer.msg('处理中', {
                icon: 16,
                shade: 0.5,
                time: 90000
            });
        };

        var ajaxSuccess = function (data, textStatus, jqXHR) {
            closeLoadingLayer();
            if (data.code == 0) {
                sucFunc(data);
            } else if ((data.code == 40 || data.code == 1000004001) && alertError !== '') {
                var ul = '<ul class="m-0">';
                $.each(data.data.errors, function (index, element) {
                    $.each(element, function (i, e) {
                        ul += '<li>' + e + '</li>';
                    });
                });
                $(alertError).empty().append(ul).show();
            } else {
                layer.alert(data.message, {
                    skin: 'layui-bg-red'
                });
            }
        };

        var ajaxError = function (jqXHR, textStatus, errorThrown) {
            closeLoadingLayer();
            console.log(jqXHR);
            layer.alert(errorThrown, {
                skin: 'layui-bg-red'
            });
        };

        if (confirmMessage !== '') {
            layer.confirm(confirmMessage, {icon: 3, title: '提示'}, function (index) {
                $.ajax({
                    type: method,
                    data: data,
                    dataType: "json",
                    url: url,
                    beforeSend: ajaxBeforeSend,
                    success: ajaxSuccess,
                    error: ajaxError,
                    complete: function () {
                        layer.close(index);
                    }
                });
            });
        } else {
            $.ajax({
                type: method,
                data: data,
                dataType: "json",
                url: url,
                beforeSend: ajaxBeforeSend,
                success: ajaxSuccess,
                error: ajaxError
            });
        }
    });

    let searchForm = $('#search-form');
    if (searchForm.length > 0) {
        searchForm.find('select').change(function () {
            searchForm.submit();
        });

        searchForm.find('.nova-search').click(function () {
            searchForm.submit();
        });

        searchForm.keydown(function (e) {
            if (e.keyCode === 13) {
                searchForm.submit();
            }
        });

        $('.date').daterangepicker({
            maxDate: moment(new Date()), //设置最大日期
            "opens": "center",
            autoUpdateInput: false,
            showWeekNumbers: true,
            locale: {
                format: "YYYY-MM-DD", //设置显示格式
                applyLabel: "确认", //确定按钮文本
                cancelLabel: "取消", //取消按钮文本
                daysOfWeek: ['日', '一', '二', '三', '四', '五', '六'],
                monthNames: [
                    '一月', '二月', '三月', '四月', '五月', '六月',
                    '七月', '八月', '九月', '十月', '十一月', '十二月'
                ],
                firstDay: 1
            },
        }, function (start, end) {
            $('.date').data('daterangepicker').autoUpdateInput = true;
            $(".created_begin").val(start.format('YYYY-MM-DD'));
            $(".created_end").val(end.format('YYYY-MM-DD'));
            $(".date").val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));
            searchForm.submit();
        });
    }
});
