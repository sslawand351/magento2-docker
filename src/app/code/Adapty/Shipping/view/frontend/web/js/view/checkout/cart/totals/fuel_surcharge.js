define(['Adapty_Shipping/js/view/checkout/summary/fuel_surcharge'], function (Component) {
    'use strict';
    return Component.extend({
        /**
         * @override
         */
        isDisplayed: function () {
            return this.getPureValue() !== 0;
        }
    });
});