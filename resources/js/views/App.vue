<template>
    <div>
        <md-toolbar class="md-layout md-alignment-center-space-between">
            <div class="md-layout-item md-layout md-alignment-center-left">
                <h3 class="md-title md-layout-item md-size-15">{{langs.minicrm}}</h3>

                <md-menu v-if="$auth.check()" class="md-layout-item md-size-15">
                    <router-link :to="{ name: 'companies' }">
                        <md-button>{{langs.companies}}</md-button>
                    </router-link>
                </md-menu>
                <md-menu v-if="$auth.check()" class="md-layout-item md-size-15">
                    <router-link :to="{ name: 'emploees' }">
                        <md-button class="md-layout-item">{{langs.emploees}}</md-button>
                    </router-link>
                </md-menu>
            </div>

            <div class="md-layout-item md-layout md-alignment-center-right">
                <md-menu md-direction="bottom-start">
                    <md-button md-menu-trigger>{{langs.language}} ({{locale}})</md-button>

                    <md-menu-content>
                        <md-menu-item @click.prevent="switchLanguage('en')">en</md-menu-item>
                        <md-menu-item @click.prevent="switchLanguage('ru')">ru</md-menu-item>
                    </md-menu-content>
                </md-menu>
                <md-menu v-if="$auth.check()" md-direction="bottom-start" class="md-layout-item md-size-10">
                    <md-button @click.prevent="$auth.logout()">
                        {{langs.logout}}
                    </md-button>
                </md-menu>
                <md-menu v-else md-direction="bottom-start" class="md-layout-item md-size-10">
                    <router-link :to="{ name: 'login' }">
                        <md-button>
                            {{langs.login}}
                        </md-button>
                    </router-link>
                </md-menu>
            </div>

        </md-toolbar>

        <router-view></router-view>
    </div>
</template>
<script>
    export default {
        name: 'App',
        data: () => ({
            langs: {},
            locale: 'en'
        }),
        beforeMount() {
            this.getLocale();
        },
        mounted() {
            this.getLangs();
        },
        methods: {
            getLocale() {
                const locale = document.cookie.replace(/(?:(?:^|.*;\s*)locale\s*\=\s*([^;]*).*$)|^.*$/, "$1");
                this.locale = locale ? locale : 'en';
            },
            getLangs() {
                axios.get('/langs?lang=' + this.locale)
                    .then(res => {
                        this.langs = res.data;
                    });
            },
            switchLanguage(locale) {
                document.cookie = 'locale=' + locale;
                window.axios.defaults.headers.common['Locale'] = document.cookie.replace(/(?:(?:^|.*;\s*)locale\s*\=\s*([^;]*).*$)|^.*$/, "$1");
                this.locale = locale;
                this.getLangs();
            }
        }
    }
</script>
<style>
    .md-content {
        padding: 0 5rem;
    }

    .page-link {
        background-color: inherit;
        border: none;
    }
</style>