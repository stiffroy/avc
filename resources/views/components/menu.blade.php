<ul class="sidebar-menu" data-widget="tree">
    <li class="header">SECTIONS</li>
    <!-- Optionally, you can add icons to the links -->
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-desktop"></i> <span>Clients</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ route('client.overview') }}"><i class="fa fa-th"></i> Overview</a></li>
            <li><a href="{{ route('client.list') }}"><i class="fa fa-list"></i> List Clients</a></li>
            <li><a href="{{ route('client.create') }}"><i class="fa fa-plus"></i> Add Client</a></li>
        </ul>
    </li>
</ul>