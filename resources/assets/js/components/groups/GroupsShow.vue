<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Group
                <small>Details</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Groups</a></li>
                <li class="active"><a href="#">{{ group.name }}</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ group.name }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td class="text-bold">{{ group.name }}</td>
                            </tr>
                            <tr>
                                <th>Warning Time</th>
                                <td>{{ group.warning }} seconds</td>
                            </tr>
                            <tr>
                                <th>Critical Time</th>
                                <td>{{ group.critical }} seconds</td>
                            </tr>
                            <tr>
                                <th>Clients</th>
                                <td>
                                    <router-link v-for="(client, index) in group.clients" :key="index"
                                                 :to="{name: 'showClient', params: {id: client.id}}" class="btn-link">
                                        <span :class="'label label-' + client.status_label">{{ client.name }}</span>
                                        &nbsp;
                                    </router-link>
                                </td>
                            </tr>
                            <tr>
                                <th>Users</th>
                                <td>
                                    <router-link v-for="(user, index) in group.users" :key="index"
                                                 :to="{name: 'showUser', params: {id: user.id}}" class="btn-link">
                                        {{ user.name }}
                                        &nbsp;
                                    </router-link>
                                </td>
                            </tr>

                            <tr>
                                <th>Created On</th>
                                <td>{{ group.created_at }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ group.updated_at }}</td>
                            </tr>
                        </table>
                        <router-link :to="{name: 'listGroups'}" class="btn btn-warning btn-flat">List</router-link>
                        <router-link :to="{name: 'createGroup'}" class="btn btn-success btn-flat">Create</router-link>
                        <router-link :to="{name: 'editGroup', params: {id: group.id}}" class="btn btn-primary btn-flat">Edit</router-link>
                        <router-link :to="{name: 'chartGroup', params: {id: group.id}}" class="btn btn-info btn-flat">Chart</router-link>
                        <p class="btn btn-danger btn-flat" v-on:click="deleteEntry(group.id)">Delete</p>
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
                group: {
                    id: 0,
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
            this.mountData('/api/v1/groups/');
        },
        methods: {
            mountData(link) {
                let id = this.$route.params.id;
                axios.get(link + id)
                    .then((response) => {
                        this.group = response.data.data;
                    })
                    .catch((response) => {
                        console.log("Could not load clients");
                        console.log(response);
                    });
            },
            deleteEntry(id) {
                if (confirm("Do you really want to delete it?")) {
                    axios.delete('/api/v1/groups/' + id)
                        .then((response) => {
                            this.$router.push({name: "listGroups"});
                        })
                        .catch((response) => {
                            console.log("Could not delete company");
                            console.log(response);
                        });
                }
            }
        }
    }
</script>
