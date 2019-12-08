<template>
    <md-content>
        <md-dialog :md-active.sync="deleteDialog" style="padding: 0 2rem">
            <p>Are you sure you want to delete?</p>
            <md-button class="md-primary" @click="deleteDialog = false">Close</md-button>
            <md-button class="md-accent" @click="deleteCompany()">Delete</md-button>
        </md-dialog>

        <md-dialog :md-active.sync="showModal" style="padding: 0 2rem">
            <md-dialog-title v-if="companyData.id">Edit company</md-dialog-title>
            <md-dialog-title v-else>New company</md-dialog-title>

            <md-field>
                <label>Name</label>
                <md-input v-model="companyData.name"></md-input>
            </md-field>
            <md-field>
                <label>Email</label>
                <md-input v-model="companyData.email"></md-input>
            </md-field>
            <md-field>
                <label>Website</label>
                <md-input v-model="companyData.website"></md-input>
            </md-field>
            <md-field>
                <label>Logo</label>
                <md-file v-model="companyData.logo" accept="image/*"></md-file>
            </md-field>

            <md-dialog-actions>
                <md-button class="md-primary" @click="showModal = false">Close</md-button>
                <md-button v-if="companyData.id" class="md-primary" @click="updateCompany()">Save</md-button>
                <md-button v-else class="md-primary" @click="createCompany()">Save</md-button>
            </md-dialog-actions>
        </md-dialog>


        <md-table md-card>
            <md-table-toolbar>
                <h1 class="md-title">Companies</h1>
            </md-table-toolbar>

            <md-button class="md-fab md-mini md-primary" @click="showModal = true">
                <md-icon>add</md-icon>
            </md-button>

            <md-table-row>
                <md-table-head>Logo</md-table-head>
                <md-table-head>Name</md-table-head>
                <md-table-head>Email</md-table-head>
                <md-table-head>Website</md-table-head>
                <md-table-head>Action</md-table-head>
            </md-table-row>

            <md-table-row v-for="company in companies">
                <md-table-cell>{{company.logo}}</md-table-cell>
                <md-table-cell>{{company.name}}</md-table-cell>
                <md-table-cell>{{company.email}}</md-table-cell>
                <md-table-cell>{{company.website}}</md-table-cell>
                <md-table-cell>
                    <md-button class="md-icon-button md-primary" @click.prevent="clickEdit(company)">
                        <md-icon>edit</md-icon>
                    </md-button>

                    <md-button class="md-icon-button md-accent" @click.prevent="clickDel(company)">
                        <md-icon>delete</md-icon>
                    </md-button>
                </md-table-cell>
            </md-table-row>
        </md-table>
    </md-content>
</template>

<script>
    export default {
        name: 'Login',
        data: () => ({
            companies: {},
            companyData: {},
            errors: {},
            sending: false,
            showModal: false,
            deleteDialog: false,
        }),
        mounted() {
            this.getCompanies()
        },
        methods: {
            getCompanies() {
                axios.get('/companies')
                    .then(res => {
                        this.companies = res.data;
                    });
            },
            clickEdit(company) {
                this.companyData = company;
                this.showModal = true;
            },
            clickDel(company) {
                this.companyData = company;
                this.deleteDialog = true;
            },
            createCompany() {
                axios.post('/companies', this.companyData)
                    .then(() => {
                        this.showModal = false;
                        this.getCompanies()
                    });
            },
            updateCompany() {
                axios.put('/companies/' + this.companyData.id, this.companyData)
                    .then(() => {
                        this.showModal = false;
                        this.getCompanies()
                    });
            },
            deleteCompany() {
                axios.delete('/companies/' + this.companyData.id)
                    .then(() => {
                        this.deleteDialog = false;
                        this.getCompanies()
                    });
            }
        }
    }
</script>


