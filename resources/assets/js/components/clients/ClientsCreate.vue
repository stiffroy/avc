<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Clients
                <small>Create</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Clients</a></li>
                <li class="active"><a href="#">Create</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Create New Client</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-sm-8 col-sm-offset-2">
                        <client-form :groups="groups" :client="client"></client-form>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    import ClientForm from './ClientsForm';

    export default {
        data: function () {
            return {
                client: {
                    id: '',
                    name: '',
                    external_id: '',
                    group_id: '',
                    alive: '',
                },
                groups: {},
            }
        },
        mounted() {
            this.getGroup('/api/v1/groups');
        },
        methods: {
            getGroup(link) {
                let app = this;
                if (link !== null) {
                    axios.get(link)
                        .then(function (response) {
                            app.refreshData(response);
                        })
                        .catch(function (response) {
                            console.dir(response);
                        });
                }
            },
            refreshData(response) {
                this.groups = response.data.data;
            }
        },
        components: {
            ClientForm
        }
    }
</script>
