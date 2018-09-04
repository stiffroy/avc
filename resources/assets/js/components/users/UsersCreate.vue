<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Users
                <small>Create</small>
            </h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li><a href="#">Users</a></li>
                <li class="active"><a href="#">Create</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Create New User</h3>
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
        data: () => {
            return {
                user: {
                    id: 0,
                    name: '',
                    email: '',
                    password: '',
                    groups: [],
                }
            }
        },
        components: {
            UserForm
        }
    }
</script>
