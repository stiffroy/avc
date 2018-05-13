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
                <li class="active"><a href="#">Edit</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edit {{ client.name }}</h3>
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
                client: {},
                groups: {},
            }
        },
        mounted() {
            this.getClient('/api/v1/clients/');
            this.getGroup('/api/v1/groups');
        },
        methods: {
            getClient(link) {
                let id = this.$route.params.id;
                if (link !== null) {
                    axios.get(link + id)
                        .then(response => {
                            this.refreshClient(response);
                        })
                        .catch(function (response) {
                            console.dir(response);
                        });
                }
            },
            getGroup(link) {
                if (link !== null) {
                    axios.get(link)
                        .then(response => {
                            this.refreshGroup(response);
                        })
                        .catch(function (response) {
                            console.dir(response);
                        });
                }
            },
            refreshClient(response) {
                this.client = response.data.data;
            },
            refreshGroup(response) {
                this.groups = response.data.data;
            }
        },
        components: {
            ClientForm
        }
    }
</script>
