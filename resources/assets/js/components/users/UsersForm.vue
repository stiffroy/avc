<template>
    <form name="client" method="post" class='form-horizontal' data-validate='true' @submit.prevent="saveUser">
        <input type="hidden" name="_token" :value="csrf">
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" id="name" name="name" class="form-control" placeholder="Name of the user" v-model="user.name">
                <p v-for="validation in errors.name" class="text text-danger">{{ validation }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email ID</label>
            <div class="col-sm-10">
                <input type="email" id="email" name="email" class="form-control" placeholder="user@av-comparatives.org" v-model="user.email">
                <p v-for="validation in errors.email" class="text text-danger">{{ validation }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
                <input type="text" id="password" name="critical" class="form-control" placeholder="********" v-model="user.password">
                <p v-for="validation in errors.password" class="text text-danger">{{ validation }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="slack-webhook-url" class="col-sm-2 control-label">Slack URL</label>
            <div class="col-sm-10">
                <input type="text" id="slack-webhook-url" name="critical" class="form-control" placeholder="Slack Webhook URL" v-model="user.slack_webhook_url">
                <p v-for="validation in errors.slack_webhook_url" class="text text-danger">{{ validation }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="groups" class="col-sm-2 control-label">Preferred Method</label>
            <div class="col-sm-10">
                <v-select name="preferred-method" id="preferred-method" v-model="user.preferred_method" :options="notificationMethods"></v-select>
            </div>
        </div>

        <div class="form-group">
            <label for="groups" class="col-sm-2 control-label">Groups</label>
            <div class="col-sm-10">
                <v-select multiple="multiple" name="groups" id="groups" v-model="user.groups" :options="groups"></v-select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-primary btn-flat">Save</button>
                <router-link :to="{name: 'listUsers'}" class="btn btn-danger btn-flat">Cancel</router-link>
            </div>
        </div>
    </form>
</template>

<script>
    import vSelect from 'vue-select';

    export default {
        data: () => {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors: {
                    name: [],
                    warning: [],
                    critical: [],
                },
                groups: [],
                notificationMethods: ['mail', 'slack'],
            }
        },
        props: ['user'],
        mounted() {
            this.mountData('/api/v1/groups/');
        },
        methods: {
            mountData(link) {
                if (link !== null) {
                    axios.get(link)
                        .then((response) => {
                            this.refreshData(response);
                        })
                        .catch((response) => {
                            alert("Could not load groups");
                            console.log(response);
                        });
                }
            },
            refreshData(response) {
                let data = response.data.data;
                let groups = this.groups;
                data.forEach((value) => {
                    let group = {
                        'value': value.id,
                        'label': value.name,
                    };
                    groups.push(group);
                })
            },
            saveUser() {
                axios.post('/api/v1/users', this.user)
                    .then((response) => {
                        let id = response.data.data.id;
                        this.$router.push({name: 'showUser', params: { id: id }});
                    })
                    .catch((response) => {
                        this.errors = response.response.data.errors;
                    });
            }
        },
        components: {
            'v-select': vSelect
        }
    }
</script>
