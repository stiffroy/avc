<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Clients
                <small>Details</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Clients</a></li>
                <li class="active"><a href="#">{{ client.name }}</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ client.name }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td class="text-bold">{{ client.name }}</td>
                            </tr>
                            <tr>
                                <th>External ID</th>
                                <td>{{ client.external_id }}</td>
                            </tr>
                            <tr>
                                <th>Group</th>
                                <td>
                                    <router-link v-if="client.group" :to="{name: 'showGroup', params: {id: client.group.id}}">
                                        {{ client.group.name }}
                                    </router-link>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span v-if="client.alive">Active</span>
                                    <span v-else>Inactive</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Health</th>
                                <td><span :class="'label label-' + client.status_label">{{ client.health }}</span></td>
                            </tr>
                            <tr>
                                <th>Created On</th>
                                <td>{{ client.created_at }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ client.updated_at }}</td>
                            </tr>
                        </table>
                        <router-link :to="{name: 'listClients'}" class="btn btn-warning btn-flat">List</router-link>
                        <router-link :to="{name: 'createClient'}" class="btn btn-success btn-flat">Create</router-link>
                        <router-link :to="{name: 'editClient', params: {id: client.id}}" class="btn btn-primary btn-flat">Edit</router-link>
                        <p class="btn btn-danger btn-flat" v-on:click="deleteEntry(client.id)">Delete</p>
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
                client: {
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
            this.mountData('/api/v1/clients/');
        },
        methods: {
            mountData(link) {
                let id = this.$route.params.id;
                axios.get(link + id)
                    .then((response) => {
                        this.client = response.data.data;
                    })
                    .catch((response) => {
                        alert("Could not load clients");
                        console.log(response);
                    });
            },
            deleteEntry(id) {
                if (confirm("Do you really want to delete it?")) {
                    axios.delete('/api/v1/clients/' + id)
                        .then((response) => {
                            this.$router.push({name: "listClients"});
                        })
                        .catch((response) => {
                            alert("Could not delete company");
                            console.log(response);
                        });
                }
            }
        }
    }
</script>
