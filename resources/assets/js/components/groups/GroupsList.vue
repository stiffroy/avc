<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Groups
                <small>List View Mode</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Groups</a></li>
                <li class="active"><a href="#">List</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Table</h3>
                    <router-link :to="{name: 'createGroup'}" class="pull-right btn btn-link">
                        <i class="fa fa-2x fa-plus-square-o"></i>
                    </router-link>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="table-clients" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Group</th>
                            <th>Warning Time</th>
                            <th>Critical Time</th>
                            <th>No of Clients</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(group, index) in groups" :key="index">
                            <td>{{ group.name }}</td>
                            <td>{{ group.warning }} seconds</td>
                            <td>{{ group.critical }} seconds</td>
                            <td>{{ group.clients.length }}</td>
                            <td>
                                <router-link :to="{name: 'showGroup', params: {id: group.id}}" class="pull-left btn btn-link">
                                    <i class="fa fa-eye"> Show</i>
                                </router-link>
                                <router-link :to="{name: 'editGroup', params: {id: group.id}}" class="pull-left btn btn-link">
                                    <i class="fa fa-edit"> Edit</i>
                                </router-link>
                                <p class="btn btn-link" v-on:click="deleteEntry(group.id, index)">
                                    <i class="fa fa-times-circle"> Delete</i>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Group</th>
                            <th>Warning Time</th>
                            <th>Critical Time</th>
                            <th>No of Clients</th>
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
                groups: [],
                links: []
            }
        },
        mounted() {
            this.mountData();
        },
        methods: {
            mountData() {
                let link = '/api/v1/groups/user/' + this.$store.state.authUser.id;
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
                this.groups = response.data.data;
                this.links = response.data.links;
            },
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    axios.delete('/api/v1/groups/' + id)
                        .then((response) => {
                            this.groups.splice(index, 1);
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
