<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Groups
                <small>Chart</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Group</a></li>
                <li class="active"><a href="#">Chart</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Group Statistics</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-sm-8 col-sm-offset-2">
                        <va-chart v-if="loaded" :chart-config="chartConfig"></va-chart>
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
        data: () => {
            return {
                group: {},
                chartConfig: {
                    type: 'line',
                    data: {
                        labels: [1, 2, 3, 4, 5],
                        datasets: []
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Chart.js Line Chart'
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true,
                            // animationDuration: 0
                        },
                        // animation: {
                        //     duration: 0
                        // },
                        // responsiveAnimationDuration: 0,
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Month'
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Value'
                                }
                            }]
                        }
                    }
                },
                tempData: [],
                tempDataSets: [],
                loaded: false
            }
        },
        mounted() {
            this.mountData();
        },
        methods: {
            mountData() {
                let link = '/api/v1/group/chart/' + this.$route.params.id;
                if (link !== null) {
                    axios.get(link)
                        .then((response) => {
                            this.refreshData(response.data);
                        })
                        .catch((response) => {
                            console.log("Could not load group statistics");
                            console.log(response);
                        });
                }
            },
            refreshData(response) {
                this.makeDataLabel(response.data);
                this.makeDataSet();
            },
            determineChartType() {
                return 'line';
            },
            populateChart(data) {
                let chart = _.cloneDeep(this.chartConfig);
                Vue.set(chart.data.datasets[0], 'data', data);
                return chart;
            },
            makeDataLabel(data) {
                this.chartConfig.data.labels = [];
                if (this.chartConfig.type === 'line') {
                    data.forEach(value => {
                        this.chartConfig.data.labels.push(value.created_at);
                        this.tempData.push(value.stats);
                    });
                }
            },
            makeDataSet() {
                if (this.chartConfig.type === 'line') {
                    this.makeLineDataSet();
                }
                this.loaded = true;
            },
            makeLineDataSet() {
                Object.keys(this.tempData[0]).map((value, index) => {
                    let colorList = ['#00c0ef', '#f39c12', '#dd4b39', '#00a65a'];
                    this.tempDataSets[value] = {
                        'label': value,
                        'fill': false,
                        'data': [],
                        'backgroundColor': colorList[index],
                        'borderColor': colorList[index],
                    };

                    this.tempData.forEach(data => {
                        this.tempDataSets[value].data.push(data[value]);
                    });
                });

                this.chartConfig.data.datasets = [];
                let dataset = [];
                Object.keys(this.tempDataSets).map(key => {
                    dataset.push(this.tempDataSets[key]);
                });
                this.chartConfig.data.datasets = dataset;
            }
        },
        components: {
            'va-chart': VAChart
        }
    }
</script>
