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
        data: function () {
            return {
                group: {},
            }
        },
        mounted() {
            this.getGroup('/api/v1/groups/');
        },
        methods: {
            getGroup(link) {
                let id = this.$route.params.id;
                if (link !== null) {
                    axios.get(link + id)
                        .then(response => {
                            this.refreshGroup(response);
                        })
                        .catch(function (response) {
                            console.dir(response);
                        });
                }
            },
            refreshGroup(response) {
                this.group = response.data.data;
            }
        },
        components: {
            GroupForm
        }
    }
</script>
