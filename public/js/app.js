$(function () {
    $("#table-clients").DataTable();
    menuBuilder();
});

function menuBuilder() {
    let activeLink = $('ul.sidebar-menu a[href="'+ window.location.href +'"]');
    activeLink.closest('li').addClass('active');
    activeLink.closest('li.treeview').addClass('active');
}