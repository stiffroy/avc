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
                    <div v-for="client in criticalClients" :key="client.id" class="col-lg-3 col-xs-6">
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
                    <div v-for="client in warningClients" :key="client.id" class="col-lg-3 col-xs-6 warning">
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
                    <div v-for="client in healthyClients" :key="client.id" class="col-lg-3 col-xs-6 healthy">
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
                    <div v-for="client in otherClients" :key="client.id" class="col-lg-3 col-xs-6 others">
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
                criticalClients: [],
                warningClients: [],
                healthyClients: [],
                otherClients: [],
                links: [],
                intervalTime: 30000,
                timer: null
            }
        },
        mounted() {
            this.mountData();
            this.timer = setInterval(this.mountData, this.intervalTime);
        },
        methods: {
            mountData() {
                console.log('mounted');
                let clientsLink = '/api/v1/clients';

                let app = this;
                if (clientsLink !== null) {
                    axios.get(clientsLink)
                        .then(function (response) {
                            app.refreshData(response);
                        })
                        .catch(function (response) {
                            alert("Could not load clients");
                            console.log(response);
                        });
                }
            },
            refreshData(response) {
                this.criticalClients = [];
                this.warningClients = [];
                this.healthyClients = [];
                this.otherClients = [];
                this.clients = response.data.data;
                this.links = response.data.links;
                this.sortClients();
            },
            sortClients() {
                let app = this;
                this.clients.forEach(function (client) {
                    app.setClientInGroup(client);
                });
            },
            setClientInGroup(client) {
                if (client.health === 'Critical') {
                    this.criticalClients.push(client);
                } else if (client.health === 'Warning') {
                    this.warningClients.push(client);
                } else if (client.health === 'Healthy') {
                    this.healthyClients.push(client);
                } else {
                    this.otherClients.push(client);
                }
            },
        },
        beforeDestroy() {
            clearInterval(this.timer)
        }
    }
</script>
