
angular.module('jQuery-ui', []).
directive('jqDate', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {

            element.datepicker(scope[attrs.jqDate]);
        }
    };
}).
directive('jqButton', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {

            element.button(scope[attrs.jqDate]);
        }
    };
}).
directive('jqAccordion', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {

            element.accordion(scope[attrs.jqDate]);
        }
    };
}).
directive('jqAutocomplete', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {

            element.autocomplete(scope[attrs.jqDate]);
        }
    };
}).
directive('jqDialog', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {

            element.dialog(scope[attrs.jqDate]);
        }
    };
}).
directive('jqMenu', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {

            element.menu(scope[attrs.jqDate]);
        }
    };
}).
directive('jqProgressbar', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {

            element.progressbar(scope[attrs.jqDate]);
        }
    };
}).
directive('jqSlider', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {

            element.slider(scope[attrs.jqDate]);
        }
    };
}).
directive('jqSpinner', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {

            element.spinner(scope[attrs.jqDate]);
        }
    };
}).
directive('jqTabs', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {

            element.tabs(scope[attrs.jqDate]);
        }
    };
}).
directive('jqTooltip', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {

            element.tooltip(scope[attrs.jqDate]);
        }
    };
});