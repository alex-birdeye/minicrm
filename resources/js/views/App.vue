<template>
    <div>
        <md-toolbar class="md-layout md-alignment-center-space-between">
            <h3 class="md-title md-layout-item">MiniCRM</h3>
            <md-menu md-direction="bottom-start" class="md-layout-item md-size-10">
                <router-link :to="{ name: 'login' }">
                    <md-button>
                        Login
                    </md-button>
                </router-link>
            </md-menu>
        </md-toolbar>
        <div class="md-layout md-alignment-center">
            <h1>MiniCRM test task</h1>
        </div>

        <!--<div class="container">-->
            <router-view></router-view>
        <!--</div>-->
    </div>
</template>
<script>
    export default {}
</script>