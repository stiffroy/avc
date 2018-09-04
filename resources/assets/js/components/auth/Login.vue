<template>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Login
                <small>Only for members</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{name: 'home'}">Home</router-link></li>
                <li class="active"><a href="#">Login</a></li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title text-center">Login Section</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-5 col-md-offset-4 col-xs-8">
                        <form class="form-signin" v-on:submit.prevent="submitLogin">
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus v-model="email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required v-model="password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-10 text-center">
                                    <div class="invalid-feedback" v-if="loginError">
                                        <strong class="text-danger">{{loginError.response.statusText}} (Error Code - {{loginError.response.status}})</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import store from '../../store';

    export default {
        data() {
            return {
                email: '',
                password: '',
                loginError: false,
            }
        },
        methods: {
            submitLogin() {
                this.loginError = false;
                axios.post('/api/v1/auth/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    localStorage.setItem('token', response.data.access_token);
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    store.commit('loginUser');
                    this.$router.push({ name: this.getUrl() })
                }).catch(error => {
                    this.loginError = error;
                    console.log(this.loginError);
                });
            },
            getUrl() {
                let url = 'home';
                if (this.$route.query.goto) {
                    url = this.$route.query.goto;
                }
                return url;
            }
        }
    }
</script>