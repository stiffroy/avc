<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Users
                <small>Details</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Users</a></li>
                <li class="active"><a href="#">{{ user.name }}</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ user.name }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td class="text-bold">{{ user.name }}</td>
                            </tr>
                            <tr>
                                <th>Email ID</th>
                                <td>{{ user.email }}</td>
                            </tr>
                            <tr>
                                <th>Groups</th>
                                <td>
                                    <router-link v-for="(group, index) in user.groups" :key="index"
                                                 :to="{name: 'showGroup', params: {id: group.id}}" class="btn-link">
                                        <p class="label label-default">{{ group.name }}</p>
                                    </router-link>
                                </td>
                            </tr>
                            <tr>
                                <th>Created On</th>
                                <td>{{ user.created_at }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ user.updated_at }}</td>
                            </tr>
                        </table>
                        <router-link :to="{name: 'listUsers'}" class="btn btn-warning btn-flat">List</router-link>
                        <router-link :to="{name: 'createUser'}" class="btn btn-success btn-flat">Create</router-link>
                        <router-link :to="{name: 'editUser', params: {id: user.id}}" class="btn btn-primary btn-flat">Edit</router-link>
                        <p class="btn btn-danger btn-flat" v-on:click="deleteEntry(user.id)">Delete</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                user: {
                    created_at: {
                        date: ''
                    },
                    updated_at: {
                        date: ''
                    }
                }
            }
        },
        mounted() {
            let id = this.$route.params.id;
            axios.get('/api/v1/users/' + id)
                .then(response => {
                    this.user = response.data.data;
                })
                .catch(function (response) {
                    alert("Could not load clients");
                    console.dir(response);
                });
        },
        methods: {
            deleteEntry(id) {
                if (confirm("Do you really want to delete it?")) {
                    axios.delete('/api/v1/users/' + id)
                        .then(function (response) {
                            router.push("listUsers");
                        })
                        .catch(function (response) {
                            alert("Could not delete company");
                            console.dir(response);
                        });
                }
            }
        }
    }
</script>
