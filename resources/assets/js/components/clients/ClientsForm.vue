<template>
    <form name="client" method="post" class='form-horizontal' data-validate='true' @submit.prevent="saveClient">
        <input type="hidden" name="_token" :value="csrf">
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" id="name" name="name" class="form-control" placeholder="Name of the client" v-model="client.name">
                <p v-for="validation in errors.name" class="text text-danger">{{ validation }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="external_id" class="col-sm-2 control-label">External ID</label>
            <div class="col-sm-10">
                <input type="text" id="external_id" name="external_id" class="form-control" placeholder="External ID of the client" v-model="client.external_id">
                <p v-for="validation in errors.external_id" class="text text-danger">{{ validation }}</p>
            </div>
        </div>

        <div class="form-group">
            <label for="group_id" class="col-sm-2 control-label">Group</label>
            <div class="col-sm-10">
                <v-select name="group_id" id="group_id" v-model="client.group" :options="groups"></v-select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input type="checkbox" id="alive" v-model="client.alive">
                <label for="alive">Is Alive</label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-primary btn-flat">Save</button>
                <router-link :to="{name: 'listClients'}" class="btn btn-danger btn-flat">Cancel</router-link>
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
                    external_id: [],
                },
                groups: [],
            }
        },
        props: ['client'],
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
                            console.log("Could not load groups");
                            console.dir(response);
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
                });
            },
            saveClient() {
                axios.post('/api/v1/clients', this.client)
                    .then((response) => {
                        let id = response.data.data.id;
                        this.$router.push({name: 'showClient', params: { id: id }});
                    })
                    .catch((response) => {
                        this.errors = response.response.data.errors;
                        console.dir(response);
                    });
            }
        },
        components: {
            'v-select': vSelect
        }
    }
</script>
