define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'nowvoice/index' + location.search,
                    add_url: 'nowvoice/add',
                    edit_url: 'nowvoice/edit',
                    del_url: 'nowvoice/del',
                    multi_url: 'nowvoice/multi',
                    import_url: 'nowvoice/import',
                    table: 'nowvoice',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'voice_name', title: __('Voice_name'), operate: 'LIKE', table: table, class: 'autocontent', formatter: Table.api.formatter.content},
                        {field: 'voice_type', title: __('Voice_type')},
                        {field: 'background_img', title: __('Background_img'),events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'background_video', title: __('Background_video'),operate: false, formatter: Table.api.formatter.file},
                        {field: 'voice', title: __('Voice'), operate: false, formatter: Table.api.formatter.file},
                        {field: 'voice_listen_num', title: __('Voice_listen_num')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
