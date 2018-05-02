<template>
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">SECTIONS</li>
         <!--Optionally, you can add icons to the links -->
        <li><router-link :to="{name: 'home'}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></router-link></li>
        <li class="treeview user">
            <a href="#">
                <i class="fa fa-users"></i> <span>Users</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li><router-link :to="{name: 'users'}"><i class="fa fa-th"></i> Overview</router-link></li>
                <li><router-link :to="{name: 'listUsers'}"><i class="fa fa-list"></i> List Users</router-link></li>
                <li><router-link :to="{name: 'createUser'}"><i class="fa fa-plus"></i> Add User</router-link></li>
            </ul>
        </li>
        <li class="treeview group">
            <a href="#">
                <i class="fa fa-snowflake-o"></i> <span>Groups</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li><router-link :to="{name: 'groups'}"><i class="fa fa-th"></i> Overview</router-link></li>
                <li><router-link :to="{name: 'listGroups'}"><i class="fa fa-list"></i> List Groups</router-link></li>
                <li><router-link :to="{name: 'createGroup'}"><i class="fa fa-plus"></i> Add Group</router-link></li>
            </ul>
        </li>
        <li class="treeview client">
            <a href="#">
                <i class="fa fa-desktop"></i> <span>Clients</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li><router-link :to="{name: 'clients'}"><i class="fa fa-th"></i> Overview</router-link></li>
                <li><router-link :to="{name: 'listClients'}"><i class="fa fa-list"></i> List Clients</router-link></li>
                <li><router-link :to="{name: 'createClient'}"><i class="fa fa-plus"></i> Add Client</router-link></li>
            </ul>
        </li>
    </ul>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
