<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Clients
                <small>Overview Mode</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Clients</a></li>
                <li class="active"><a href="#">Overview</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Clients</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div v-for="(client, index) in clients" :key="index" class="col-lg-3 col-xs-6">
                        <div :class="'small-box bg-' + client.bg">
                            <div class="inner">
                                <h3>{{ client.name }}</h3>
                                <p>{{ client.external_id }}</p>
                                <p>{{ client.health }}</p>
                            </div>

                            <div class="icon">
                                <i :class="'fa fa-' + client.bg_icon"></i>
                            </div>
                            <router-link :to="{name: 'showClient', params: {id: client.id}}" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </router-link>
                        </div>
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
                        .then(response => {
                            this.refreshData(response);
                        })
                        .catch(function (response) {
                            alert("Could not load clients");
                            console.log(response);
                        });
                }
            },
            refreshData(response) {
                this.clients = response.data.data;
                this.links = response.data.links;
            }
        }
    }
</script>
