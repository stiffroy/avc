<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Groups
                <small>Create</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Group</a></li>
                <li class="active"><a href="#">Create</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Create New Group</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-sm-8 col-sm-offset-2">
                        <va-chart :chart-config="chartConfig"></va-chart>
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
                    type: '',
                    data: {
                        labels: ['No records yet', 'Warning', 'Critical', 'Healthy'],
                        datasets: [{
                            data: [],
                            backgroundColor: ['#00c0ef', '#f39c12', '#dd4b39', '#00a65a'],
                            hoverBackgroundColor: ['#00a7d0', '#db8b0b', '#d33724', '#008d4c']
                        }]
                    }
                },
            }
        },
        mounted() {
            this.mountData();
        },
        methods: {
            mountData() {
                let link = '/api/v1/groups/' + this.$route.params.id;
                if (link !== null) {
                    axios.get(link)
                        .then((response) => {
                            this.refreshData(response);
                        })
                        .catch((response) => {
                            console.log("Could not load group statistics");
                            console.log(response);
                        });
                }
            },
            refreshData(response) {
                this.group = response.data.data;
                let dataArray = this.makeDataArray(this.group.statistics);
                // @TODO make the data set accordingly
                this.makeDataSets(dataArray);
                Vue.set(this.chartConfig, 'type', this.determineChartType());
            },
            makeDataArray(statistics) {
                let dataArray = [];
                for (let i = 0, len = statistics.length; i < len; i++) {
                    let stats = statistics[i];
                    let data = stats.data;
                    let dataKeyArray = Object.keys(data);

                    dataKeyArray.forEach((value, index) => {
                        if (!dataArray.hasOwnProperty(index)) {
                            dataArray[index] = [];
                        }
                        dataArray[index].push({
                            x: stats.created_at,
                            y: data[value]
                        });
                    });
                }

                return dataArray;
            },
            determineChartType() {
                return 'line';
            },
            makeDataSets(dataArray) {
                console.log(dataArray);
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
