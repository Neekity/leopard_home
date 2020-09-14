(function ($) {
    $.fn.tableView = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist in jQuery.tableView');
            return false;
        }
    };
    
    var defaults = {
        filterUrl: undefined,
        filterSelector: undefined
    };
    
    var tableData = {};
    
    var gridEvents = {
        /**
         * beforeFilter event is triggered before filtering the grid.
         * The signature of the event handler should be:
         *     function (event)
         * where
         *  - event: an Event object.
         *
         * If the handler returns a boolean false, it will stop filter form submission after this event. As
         * a result, afterFilter event will not be triggered.
         */
        beforeFilter: 'beforeFilter',
        /**
         * afterFilter event is triggered after filtering the grid and filtered results are fetched.
         * The signature of the event handler should be:
         *     function (event)
         * where
         *  - event: an Event object.
         */
        afterFilter: 'afterFilter'
    };
    
    /**
     * Used for storing active event handlers and removing them later.
     * The structure of single event handler is:
     *
     * {
     *     tableViewId: {
     *         type: {
     *             event: '...',
     *             selector: '...'
     *         }
     *     }
     * }
     *
     * Used types:
     *
     * - filter, used for filtering grid with elements found by filterSelector
     * - checkRow, used for checking single row
     * - checkAllRows, used for checking all rows with according "Check all" checkbox
     *
     * event is the name of event, for example: 'change.tableView'
     * selector is a jQuery selector for finding elements
     *
     * @type {{}}
     */
    var gridEventHandlers = {};
    
    var methods = {
        init: function (options) {
            return this.each(function () {
                var $e = $(this);
                var settings = $.extend({}, defaults, options || {});
                var id = $e.attr('id');
                if (tableData[id] === undefined) {
                    tableData[id] = {};
                }
                
                tableData[id] = $.extend(tableData[id], {settings: settings});
            });
        },
        
        
        setSelectionColumn: function (options) {
            var $table = $(this);
            var id = $(this).attr('id');
            if (tableData[id] === undefined) {
                tableData[id] = {};
            }
            tableData[id].selectionColumn = options.name;
            if (!options.multiple || !options.checkAll) {
                return;
            }
            var checkAll = "#" + id + " input[name='" + options.checkAll + "']";
            var inputs = options['class'] ? "input." + options['class'] : "input[name='" + options.name + "']";
            var inputsEnabled = "#" + id + " " + inputs + ":enabled";
            initEventHandler($table, 'checkAllRows', 'click.tableView', checkAll, function () {
                $table.find(inputs + ":enabled").prop('checked', this.checked);
            });
            initEventHandler($table, 'checkRow', 'click.tableView', inputsEnabled, function () {
                var all = $table.find(inputs).length == $table.find(inputs + ":checked").length;
                $table.find("input[name='" + options.checkAll + "']").prop('checked', all);
            });
        },
        
        getSelectedRows: function () {
            var $table = $(this);
            var data = tableData[$table.attr('id')];
            var keys = [];
            if (data.selectionColumn) {
                $table.find("input[name='" + data.selectionColumn + "']:checked").each(function () {
                    keys.push($(this).val());
                });
            }
            return keys;
        },
        
        destroy: function () {
            var events = ['.tableView', gridEvents.beforeFilter, gridEvents.afterFilter].join(' ');
            this.off(events);
            
            var id = $(this).attr('id');
            $.each(gridEventHandlers[id], function (type, data) {
                $(document).off(data.event, data.selector);
            });
            
            delete tableData[id];
            
            return this;
        },
        
        data: function () {
            var id = $(this).attr('id');
            return tableData[id];
        }
    };
    
    /**
     * Used for attaching event handler and prevent of duplicating them. With each call previously attached handler of
     * the same type is removed even selector was changed.
     * @param {jQuery} $tableView According jQuery grid view element
     * @param {string} type Type of the event which acts like a key
     * @param {string} event Event name, for example 'change.tableView'
     * @param {string} selector jQuery selector
     * @param {function} callback The actual function to be executed with this event
     */
    function initEventHandler($tableView, type, event, selector, callback) {
        var id = $tableView.attr('id');
        var prevHandler = gridEventHandlers[id];
        if (prevHandler !== undefined && prevHandler[type] !== undefined) {
            var data = prevHandler[type];
            $(document).off(data.event, data.selector);
        }
        if (prevHandler === undefined) {
            gridEventHandlers[id] = {};
        }
        $(document).on(event, selector, callback);
        gridEventHandlers[id][type] = {event: event, selector: selector};
    }
})(window.jQuery);
