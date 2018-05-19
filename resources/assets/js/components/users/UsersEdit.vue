<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Users
                <small>Edit</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Users</a></li>
                <li class="active"><a href="#">Edit</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edit {{ user.name }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-sm-8 col-sm-offset-2">
                        <user-form :user="user"></user-form>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    import UserForm from './UsersForm';

    export default {
        data: function () {
            return {
                user: {}
            }
        },
        mounted() {
            this.mountData('/api/v1/users/');
        },
        methods: {
            mountData(link) {
                let id = this.$route.params.id;
                if (link !== null) {
                    axios.get(link + id)
                        .then(response => {
                            this.refreshData(response);
                        })
                        .catch(function (response) {
                            console.dir(response);
                        });
                }
            },
            refreshData(response) {
                let groups = [];
                this.user = response.data.data;
                this.user.groups.forEach(function (value, key) {
                    groups.push({'value': value.id, 'label': value.name})
                });
                this.user.groups = groups;
            }
        },
        components: {
            UserForm
        }
    }
</script>
