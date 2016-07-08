'use strict';

/**
 * Constructor
 */
var main = function () {
    this.initialize();
};

/**
 * Инициализация приложения JS
 */
main.prototype.initialize = function () {
    var
        self = this;

    $(document).ready(function () {
        self
            .vendorLibraries();
    });
};

/**
 * Инициализируем вендорные либы
 */
main.prototype.vendorLibraries = function () {

    return this;
};

(new main());
