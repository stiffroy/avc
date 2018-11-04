<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Groups
                <small>Edit</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Groups</a></li>
                <li class="active"><a href="#">Edit</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edit {{ group.name }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-sm-8 col-sm-offset-2">
                        <group-form :group="group"></group-form>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    import GroupForm from './GroupsForm';

    export default {
        data: () => {
            return {
                group: {},
            }
        },
        mounted() {
            this.mountData('/api/v1/groups/');
        },
        methods: {
            mountData(link) {
                let id = this.$route.params.id;
                if (link !== null) {
                    axios.get(link + id)
                        .then((response) => {
                            this.refreshData(response);
                        })
                        .catch((response) => {
                            console.log("Could not load group");
                            console.dir(response);
                        });
                }
            },
            refreshData(response) {
                let clients = [];
                let users = [];
                this.group = response.data.data;
                this.group.clients.forEach((value) => {
                    clients.push({'value': value.id, 'label': value.name})
                });
                this.group.clients = clients;
                this.group.users.forEach((value) => {
                    users.push({'value': value.id, 'label': value.name})
                });
                this.group.users = users;
            }
        },
        components: {
            GroupForm
        }
    }
</script>
