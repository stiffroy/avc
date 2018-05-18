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
            <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-primary btn-flat">Save</button>
                <router-link :to="{name: 'listGroups'}" class="btn btn-danger btn-flat">Cancel</router-link>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        data: function () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                errors: {
                    name: [],
                    warning: [],
                    critical: [],
                },
            }
        },
        props: ['group'],
        methods: {
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
        }
    }
</script>
