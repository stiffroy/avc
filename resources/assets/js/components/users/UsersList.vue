<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Users
                <small>List View Mode</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Users</a></li>
                <li class="active"><a href="#">List</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Table</h3>
                    <router-link :to="{name: 'createUser'}" class="pull-right btn btn-link">
                        <i class="fa fa-2x fa-plus-square-o"></i>
                    </router-link>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table-clients" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(user, index) in users" :key="index">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.created_at }}</td>
                            <td>{{ user.updated_at }}</td>
                            <td>
                                <router-link :to="{name: 'showUser', params: {id: user.id}}" class="pull-left btn btn-link">
                                    <i class="fa fa-eye"> Show</i>
                                </router-link>
                                <router-link :to="{name: 'editUser', params: {id: user.id}}" class="pull-left btn btn-link">
                                    <i class="fa fa-edit"> Edit</i>
                                </router-link>
                                <p class="btn btn-link" v-on:click="deleteEntry(user.id)">
                                    <i class="fa fa-times-circle"> Delete</i>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Upgraded At</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                    </table>
                    <div v-if="links.prev !== links.next" class="pull-right">
                        <p class="btn btn-link" v-on:click="mountData(links.first)">First</p>
                        <p class="btn btn-link" v-on:click="mountData(links.prev)">Prev</p>
                        <p class="btn btn-link" v-on:click="mountData(links.next)">Next</p>
                        <p class="btn btn-link" v-on:click="mountData(links.last)">Last</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    export default {
        data: () => {
            return {
                users: [],
                links: []
            }
        },
        mounted() {
            this.mountData('/api/v1/users');
        },
        methods: {
            mountData(link) {
                if (link !== null) {
                    axios.get(link)
                        .then((response) => {
                            this.refreshData(response);
                        })
                        .catch((response) => {
                            alert("Could not load clients");
                            console.dir(response);
                        });
                }
            },
            refreshData(response) {
                this.users = response.data.data;
                this.links = response.data.links;
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    axios.delete('/api/v1/users/' + id)
                        .then((response) => {
                            this.users.splice(index, 1);
                        })
                        .catch((response) => {
                            alert("Could not delete company");
                            console.dir(response);
                        });
                }
            }
        }
    }
</script>
