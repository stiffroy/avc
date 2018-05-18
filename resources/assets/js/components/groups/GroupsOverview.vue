<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Groups
                <small>Overview Mode</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Groups</a></li>
                <li class="active"><a href="#">Overview</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Groups</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div v-for="(group, index) in groups" :key="index" class="col-lg-4 col-xs-6">
                        <div class="small-box bg-teal">
                            <div class="inner">
                                <h3>{{ group.name }}</h3>
                                <p>
                                    <span class="text-yellow">{{ group.warning }} {{ group.warning | pluralize('min') }}</span> |
                                    <span class="text-red">{{ group.critical }} {{ group.critical | pluralize('min') }}</span> |
                                    {{ group.clients_no }} {{ group.clients_no | pluralize('client') }}
                                </p>
                            </div>

                            <!--<div class="icon">-->
                                <!--<va-chart :chart-config="group.chartConfig"></va-chart>-->
                            <!--</div>-->

                            <router-link :to="{name: 'showGroup', params: {id: group.id}}" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </router-link>
                        </div>
                        <va-chart :chart-config="group.chartConfig"></va-chart>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    import Vue from 'vue';
    import VAChart from 'vue2-admin-lte/src/components/VAChart';

    export default {
        data: function () {
            return {
                groups: [],
                links: [],
                chartConfig: {
                    type: 'pie',
                    data: {
                        labels: ['No records yet', 'Warning', 'Critical', 'Healthy'],
                        datasets: [{
                            data: [],
                            backgroundColor: ['#00c0ef', '#f39c12', '#dd4b39', '#00a65a'],
                            hoverBackgroundColor: ['#00a7d0', '#db8b0b', '#d33724', '#008d4c']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: !this.isMobile,
                        legend: {
                            position: 'bottom',
                            display: true
                        }
                    }
                },
            }
        },
        mounted() {
            this.mountData('/api/v1/groups');
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
                this.groups = response.data.data;
                this.links = response.data.links;
                this.mountChartToData();
            },
            mountChartToData() {
                let app = this;
                this.groups.forEach(function (group, key) {
                    app.setChartToGroup(group);
                });
            },
            setChartToGroup(group) {
                let chart = this.populateChart(group.clients_data);
                Vue.set(group, 'chartConfig', chart);
            },
            populateChart(data) {
                let chart = _.cloneDeep(this.chartConfig);
                Vue.set(chart.data.datasets[0], 'data', data);
                return chart;
            }
        },
        components: {
            'va-chart': VAChart
        }
    }
</script>
