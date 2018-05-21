<template>
    <form name="client" method="post" class='form-horizontal' data-validate='true' @submit.prevent="saveGroup">
        <input type="hidden" name="_token" :value="csrf">
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" id="name" name="name" class="form-control" placeholder="Name of the group" v-model="group.name">
                <p v-for="validation in errors.name" class="text text-danger">{{ validation }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="warning" class="col-sm-2 control-label">Warning Time</label>
            <div class="col-sm-10">
                <input type="text" id="warning" name="warning" class="form-control" placeholder="Warning Time (in seconds)" v-model="group.warning">
                <p v-for="validation in errors.warning" class="text text-danger">{{ validation }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="critical" class="col-sm-2 control-label">Critical Time</label>
            <div class="col-sm-10">
                <input type="text" id="critical" name="critical" class="form-control" placeholder="Critical Time (in seconds)" v-model="group.critical">
                <p v-for="validation in errors.critical" class="text text-danger">{{ validation }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="users" class="col-sm-2 control-label">Users</label>
            <div class="col-sm-10">
                <v-select multiple="multiple" name="users" id="users" v-model="group.users" :options="users"></v-select>
            </div>
        </div>

        <div class="form-group">
            <label for="clients" class="col-sm-2 control-label">Clients</label>
            <div class="col-sm-10">
                <v-select multiple="multiple" name="clients" id="clients" v-model="group.clients" :options="clients"></v-select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-primary btn-flat">Save</button>
                <router-link :to="{name: 'listGroups'}" class="btn btn-danger btn-flat">Cancel</router-link>
            </div>
        </div>
    </form>
</template>

<script>
    import vSelect from 'vue-select';

    export default {
        data: function () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors: {
                    name: [],
                    warning: [],
                    critical: [],
                },
                clients: [],
                users: [],
            }
        },
        mounted() {
            this.mountClients('/api/v1/clients/');
            this.mountUsers('/api/v1/users/');
        },
        props: ['group'],
        methods: {
            mountClients(link) {
                let app = this;
                axios.post(link)
                    .then(function (response) {
                        app.refreshClients(response);
                    })
                    .catch(function (response) {
                        alert("Could not load clients");
                        console.dir(response);
                    });
            },
            mountUsers(link) {
                let app = this;
                axios.post(link)
                    .then(function (response) {
                        app.refreshUsers(response);
                    })
                    .catch(function (response) {
                        alert("Could not load users");
                        console.dir(response);
                    });
            },
            refreshClients(response) {
                let data = response.data.data;
                let clients = this.clients;
                data.forEach(function (value, key) {
                    let client = {
                        'value': value.id,
                        'label': value.name,
                    };
                    clients.push(client);
                });
            },
            refreshUsers(response) {
                let data = response.data.data;
                let users = this.users;
                data.forEach(function (value, key) {
                    let user = {
                        'value': value.id,
                        'label': value.name,
                    };
                    users.push(user);
                });
            },
            saveGroup() {
                let app = this;
                axios.post('/api/v1/groups', app.group)
                    .then(function (response) {
                        let id = response.data.data.id;
                        app.$router.push({ name: 'showGroup', params: { id: id }});
                    })
                    .catch(function (error) {
                        app.errors = error.response.data.errors;
                    });
            }
        },
        components: {
            'v-select': vSelect
        }
    }
</script>
