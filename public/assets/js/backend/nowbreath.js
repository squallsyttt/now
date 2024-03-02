define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'nowbreath/index' + location.search,
                    add_url: 'nowbreath/add',
                    edit_url: 'nowbreath/edit',
                    del_url: 'nowbreath/del',
                    multi_url: 'nowbreath/multi',
                    import_url: 'nowbreath/import',
                    table: 'nowbreath',
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
                        {field: 'breath_type', title: __('Breath_type')},
                        {field: 'breath_scene', title: __('Breath_scene')},
                        {field: 'breath_voice', title: __('Breath_voice'), operate: 'LIKE', table: table, class: 'autocontent', formatter: Table.api.formatter.content},
                        {field: 'breath_use_scenes_list', title: __('Breath_use_scenes_list'), searchList: {"478":__('Breath_use_scenes_list 478'),"44":__('Breath_use_scenes_list 44')}, operate:'FIND_IN_SET', formatter: Table.api.formatter.label},
                        {field: 'breath_length', title: __('Breath_length'), operate:'BETWEEN'},
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
