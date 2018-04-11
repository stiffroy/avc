webpackJsonp([1],[
/* 0 */,
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(2);
module.exports = __webpack_require__(3);


/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
$(function () {
    $("#table-clients").DataTable();
    menuBuilder();
    // console.log(groups);
    // if (groups !== undefined) {
    //     // let parsedGroups = JSON.parse(groups);
    //     console.log(groups);
    //     groupsHandler(parsedGroups, groups);
    // }
});

function menuBuilder() {
    highlightGroup();
    var activeLink = $('ul.sidebar-menu a[href="' + window.location.href + '"]');
    activeLink.closest('li').addClass('active');
    activeLink.closest('li.treeview').addClass('active');
}

function highlightGroup() {
    var section = window.location.pathname.split('/');
    $('ul.sidebar-menu li.' + section[1]).addClass('active');
}

function groupsHandler(parsedGroups, groups) {
    console.log(groups);
    console.log('in the function group');
    console.log(parsedGroups);
    console.log(parsedGroups.length);
    var i = 0;
    for (var len = groups.length; i < len; i++) {
        console.log('in the function group loop');
        console.log(groups[i]);
        generateChart(groups[i]);
    }
}

function generateChart(group) {
    alert('in the function generate chart');
    console.log(group);
}
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),
/* 3 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
],[1]);