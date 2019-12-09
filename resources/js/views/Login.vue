<template>
    <form novalidate class="md-layout md-alignment-center-center" @submit.prevent="login">
        <md-card class="md-layout-item md-size-50 md-small-size-100">
            <md-card-header>
                <div class="md-title">{{$parent.langs.login}}</div>
            </md-card-header>

            <md-card-content>
                <md-field>
                    <label for="email">{{$parent.langs.email}}</label>
                    <md-input type="email" id="email" autocomplete="email" v-model="form.email"
                              :disabled="sending"/>
                    <span class="md-error" v-if="errors.email">{{errors.email[0]}}</span>
                </md-field>
                <md-field>
                    <label for="password">{{$parent.langs.password}}</label>
                    <md-input type="password" id="password" v-model="form.password"
                              :disabled="sending"/>
                    <!--<span class="md-error" v-if="!$v.form.email.required">The email is required</span>-->
                </md-field>
            </md-card-content>

            <md-progress-bar md-mode="indeterminate" v-if="sending"/>

            <md-card-actions>
                <md-button type="submit" class="md-primary" :disabled="sending">{{$parent.langs.login}}</md-button>
            </md-card-actions>
        </md-card>

        <!--<md-snackbar :md-active.sync="userSaved">The user {{ lastUser }} was saved with success!</md-snackbar>-->
    </form>
</template>

<script>
    export default {
        name: 'Login',
        data: () => ({
            form: {
                email: null,
                password: null,
            },
            errors: {},
            sending: false,
        }),
        methods: {
            login() {
                this.sending = true;
                this.errors = {};

                var redirect = this.$auth.redirect();
                var app = this;
                this.$auth.login({
                    params: app.form,
                    success: function () {
                        // handle redirection
                        const redirectTo = redirect ? redirect.from.name : 'home'
                        this.$router.push({name: redirectTo})
                    },
                    error: function (error) {
                        this.sending = false;
                        app.errors = error.response.data.errors;
                    },
                    rememberMe: true,
                    fetchUser: true
                })
            }
        }
    }
</script>

<style>
    .md-field .md-error {
        color: #e9605c;
        opacity: unset;
        transform: unset;
    }
</style>