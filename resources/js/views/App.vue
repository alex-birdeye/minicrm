<template>
    <div>
        <md-toolbar class="md-layout md-alignment-center-space-between">
            <div class="md-layout-item md-layout md-alignment-center-left">
                <h3 class="md-title md-layout-item md-size-15">MiniCRM</h3>

                <md-menu v-if="$auth.check()" class="md-layout-item md-size-15">
                    <router-link :to="{ name: 'companies' }">
                        <md-button>Companies</md-button>
                    </router-link>
                </md-menu>
                <md-menu v-if="$auth.check()" class="md-layout-item md-size-15">
                    <md-button class="md-layout-item">Emploees</md-button>
                </md-menu>
            </div>

            <div class="md-layout-item md-layout md-alignment-center-right">
                <md-menu v-if="$auth.check()" md-direction="bottom-start" class="md-layout-item md-size-10">
                    <md-button @click.prevent="$auth.logout()">
                        Logout
                    </md-button>
                </md-menu>
                <md-menu v-else md-direction="bottom-start" class="md-layout-item md-size-10">
                    <router-link :to="{ name: 'login' }">
                        <md-button>
                            Login
                        </md-button>
                    </router-link>
                </md-menu>
            </div>

        </md-toolbar>

        <router-view></router-view>
    </div>
</template>
<script>
    export default {}
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