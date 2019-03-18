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
                    <div class="row">
                        <div class="col-sm-8 pull-left">
                            <date-range-picker :startDate="startDate"
                                               :endDate="endDate"
                                               @update="updateValues"
                                               :locale-data="locale"
                            >
                            </date-range-picker>
                        </div>
                        <div class="col-sm-1 col-sm-offset-3" style="padding-right: 20px;">
                            <select class="pull-right" name="chart_type" id="chart_type" v-model="chartType" @change="mountData">
                                <option value="line">Line</option>
                                <option value="bar">Bar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <va-chart v-if="loaded" :chart-config="chartConfig"></va-chart>
                            <h2 v-if="!loaded && error" class="text-center text-danger">{{ error }}</h2>
                            <p v-if="!loaded && error" class="text-center text-danger">
                                Date range from {{ formatDate(startDate) }} to {{ formatDate(endDate) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    import VAChart from 'vue2-admin-lte/src/components/VAChart';
    import DateRangePicker from 'vue2-daterange-picker'
    import moment from 'moment';

    export default {
        data: () => {
            return {
                group: {},
                chartConfig: {},
                loaded: false,
                chartType: 'line',
                error: false,
                startDate: moment().startOf('week').format('YYYY-MM-DD'),
                endDate: moment().endOf('week').format('YYYY-MM-DD'),
                locale: {
                    direction: 'ltr', //direction of text
                    format: 'DD-MM-YYYY', //fomart of the dates displayed
                    separator: ' - ', //separator between the two ranges
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                    weekLabel: 'W',
                    customRangeLabel: 'Custom Range',
                    daysOfWeek: moment.weekdaysMin(), //array of days - see moment documenations for details
                    monthNames: moment.monthsShort(), //array of month names - see moment documenations for details
                    firstDay: 1 //ISO first day of week - see moment documenations for details
                },
            }
        },
        mounted() {
            this.mountData();
        },
        methods: {
            mountData() {
                this.loaded = false;
                axios.get(this.generateURL())
                    .then((response) => {
                        this.refreshData(response.data);
                    })
                    .catch((response) => {
                        console.log("Could not load group statistics");
                        console.log(response);
                    });
            },
            generateURL() {
                let link = '/api/v1/group/chart/' + this.$route.params.id;
                let type = 'type=' + this.chartType;
                let from = 'from=' + this.startDate;
                let till = 'till=' + this.endDate;
                // let till = 'till=' + this.endDate.format('YYYY-MM-DD');

                return link + '?' + type + '&' + from + '&' + till;
            },
            refreshData(response) {
                if (response) {
                    this.chartConfig = response;
                    this.loaded = true;
                    this.error = false;
                } else {
                    this.error = 'No data found';
                    console.log('Not a correct response');
                    console.log(response);
                }
            },
            updateValues(values) {
                this.startDate = moment(values.startDate).format('YYYY-MM-DD');
                this.endDate = moment(values.endDate).format('YYYY-MM-DD');
                this.mountData();
            },
            formatDate(date) {
                return moment(date).format('DD.MM.YYYY');
            }
        },
        components: {
            'va-chart': VAChart,
            'date-range-picker': DateRangePicker,
        }
    }
</script>
<style lang="scss">
    @import '~vue2-daterange-picker/src/assets/daterangepicker.css';
</style>