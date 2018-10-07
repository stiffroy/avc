<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Overview Mode</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Dashboard</h3>
                    <div class="pull-right">
                        <input v-model="show.all" @click="checkboxToggle('all')" type="checkbox" class="form-check-input" id="show_all"> All
                        <input v-model="show.critical" @click="checkboxToggle('critical')" type="checkbox" class="form-check-input" id="show_critical"> Critical
                        <input v-model="show.warning" @click="checkboxToggle('warning')" type="checkbox" class="form-check-input" id="show_warning"> Warning
                        <input v-model="show.healthy" @click="checkboxToggle('healthy')" type="checkbox" class="form-check-input" id="show_healthy"> Healthy
                        <input v-model="show.other" @click="checkboxToggle('other')" type="checkbox" class="form-check-input" id="show_other"> Others
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div v-if="show.critical || show.all" v-for="client in criticalClients" :key="client.id" class="col-lg-3 col-xs-6">
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
                    <div v-if="show.warning || show.all" v-for="client in warningClients" :key="client.id" class="col-lg-3 col-xs-6 warning">
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
                    <div v-if="show.healthy || show.all" v-for="client in healthyClients" :key="client.id" class="col-lg-3 col-xs-6 healthy">
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
                    <div v-if="show.other || show.all" v-for="client in otherClients" :key="client.id" class="col-lg-3 col-xs-6 others">
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
        data: () => {
            return {
                clients: [],
                criticalClients: [],
                warningClients: [],
                healthyClients: [],
                otherClients: [],
                links: [],
                intervalTime: 30000,
                timer: null,
                show: {
                    all: false,
                    critical : true,
                    warning : true,
                    healthy : false,
                    other : false
                }
            }
        },
        mounted() {
            this.mountData();
            this.timer = setInterval(this.mountData, this.intervalTime);
        },
        methods: {
            mountData() {
                let clientsLink = '/api/v1/clients/user/' + this.$store.state.authUser.id;

                if (clientsLink !== null) {
                    axios.get(clientsLink)
                        .then((response) => {
                            this.refreshData(response);
                        })
                        .catch((response) => {
                            console.log("Could not load clients");
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
                this.clients.forEach((client) => {
                    this.setClientInGroup(client);
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
            checkboxToggle(mode) {
                if (mode === 'all') {
                    this.show.critical = false;
                    this.show.warning = false;
                    this.show.healthy = false;
                    this.show.other = false;
                } else {
                    this.show.all = false;
                }
            }
        },
        beforeDestroy() {
            clearInterval(this.timer)
        }
    }
</script>
