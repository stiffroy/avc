$(function () {
    $("#table-clients").DataTable();
    menuBuilder();
});

function menuBuilder() {
    highlightGroup();
    let activeLink = $('ul.sidebar-menu a[href="'+ window.location.href +'"]');
    activeLink.closest('li').addClass('active');
    activeLink.closest('li.treeview').addClass('active');
}

function highlightGroup() {
    let section = window.location.pathname.split('/');
    $('ul.sidebar-menu li.' + section[1]).addClass('active');
}