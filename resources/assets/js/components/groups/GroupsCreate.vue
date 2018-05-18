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
                group: {
                    id: '',
                    name: '',
                    critical: '',
                    warning: '',
                    clients: [],
                },
            }
        },
        mounted() {
        },
        methods: {
        },
        components: {
            GroupForm
        }
    }
</script>
