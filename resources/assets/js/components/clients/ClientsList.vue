<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Clients
                <small>List View Mode</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Clients</a></li>
                <li class="active"><a href="#">List</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Table</h3>
                    <router-link :to="{name: 'createClient'}" class="pull-right btn btn-link">
                        <i class="fa fa-2x fa-plus-square-o"></i>
                    </router-link>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table-clients" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Client</th>
                            <th>External ID</th>
                            <th>Group Name</th>
                            <th>Last Updated</th>
                            <th>Health</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(client, index) in clients" :key="index">
                            <td>
                                {{ client.name }}
                                <span v-if="!client.alive" class="label label-danger label-as-badge" v-on:click="makeAlive(client)">enable</span>
                            </td>
                            <td>{{ client.external_id }}</td>
                            <td>
                                <router-link v-if="client.group" :to="{ name: 'showGroup', params: { id: client.group.id }}">
                                    {{ client.group.name }}
                                </router-link>
                            </td>
                            <td>{{ client.updated_at }}</td>
                            <td><span :class="'label label-' + client.status_label">{{ client.health }}</span></td>
                            <td>
                                <router-link :to="{name: 'showClient', params: {id: client.id}}" class="pull-left btn btn-link">
                                    <i class="fa fa-eye"> Show</i>
                                </router-link>
                                <router-link :to="{name: 'editClient', params: {id: client.id}}" class="pull-left btn btn-link">
                                    <i class="fa fa-edit"> Edit</i>
                                </router-link>
                                <p class="btn btn-link" v-on:click="deleteEntry(client.id, index)">
                                    <i class="fa fa-times-circle"> Delete</i>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Client</th>
                            <th>External ID</th>
                            <th>Group Name</th>
                            <th>Last Updated</th>
                            <th>Health</th>
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
                clients: [],
                links: []
            }
        },
        mounted() {
            this.mountData('/api/v1/clients');
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
                            console.log(response);
                        });
                }
            },
            refreshData(response) {
                this.clients = response.data.data;
                this.links = response.data.links;
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    axios.delete('/api/v1/clients/' + id)
                        .then((response) => {
                            this.clients.splice(index, 1);
                        })
                        .catch((response) => {
                            alert("Could not delete company");
                            console.log(response);
                        });
                }
            },
            makeAlive(client) {
                event.preventDefault();
                axios.post('/api/v1/client/alive', {id: client.id})
                    .then((response) => {
                        client.alive = response.data.data.alive;
                    })
                    .catch((response) => {
                        alert("Could not make the client alive");
                        console.log(response);
                    });
            }
        }
    }
</script>
