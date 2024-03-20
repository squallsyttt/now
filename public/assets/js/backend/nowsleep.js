define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'nowsleep/index' + location.search,
                    add_url: 'nowsleep/add',
                    edit_url: 'nowsleep/edit',
                    del_url: 'nowsleep/del',
                    multi_url: 'nowsleep/multi',
                    import_url: 'nowsleep/import',
                    table: 'nowsleep',
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
                        {field: 'sleep_name', title: __('Sleep_name'), operate: 'LIKE', table: table, class: 'autocontent', formatter: Table.api.formatter.content},
                        {field: 'sleep_background_img', title: __('Sleep_background_img'),events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'sleep_voice', title: __('Sleep_voice'), operate: false, formatter: Table.api.formatter.file},
                        {field: 'sleep_listen_num', title: __('Sleep_listen_num')},
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
