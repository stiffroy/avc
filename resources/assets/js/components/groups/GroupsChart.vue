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
    import VAChart from 'vue2-admin-lte/src/components/VAChart';

    export default {
        data: () => {
            return {
                group: {},
                chartConfig: {},
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
                this.chartConfig = response;
                this.loaded = true;
            },
        },
        components: {
            'va-chart': VAChart
        }
    }
</script>
