(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(["knockout", "autosize"], factory);
    } else {
        // Browser globals
        factory(ko, autosize);
    }
}(this, function (ko, autosize) {
    ko.bindingHandlers.autosize = {
        init: function (element, valueAccessor) {
            var enabled = ko.unwrap(valueAccessor());
            if (enabled === true) {
                autosize(element);
            }
        }
    }
}));