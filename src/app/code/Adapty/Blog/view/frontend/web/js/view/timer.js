define(['uiComponent', 'ko'], function (uiComponent, ko) {
    return uiComponent.extend({
        time: ko.observable('Loading...'),
        initialize: function () {
            this._super();
            setInterval(this.updateTime.bind(this), 1000);
        },
        getTime: function () {
            return this.time;
        },
        updateTime: function () {
            this.time(new Date());
            console.log('update time', this.time);
        }
    })
})