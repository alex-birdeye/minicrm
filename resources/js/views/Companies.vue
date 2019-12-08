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
                <md-input v-model="companyData.name" required></md-input>
                <span v-if="errors.name" class="md-error">{{errors.name[0]}}</span>
            </md-field>
            <md-field>
                <label>Email</label>
                <md-input v-model="companyData.email" required></md-input>
                <span v-if="errors.email" class="md-error">{{errors.email[0]}}</span>
            </md-field>
            <md-field>
                <label>Website</label>
                <md-input v-model="companyData.website"></md-input>
                <span v-if="errors.website" class="md-error">{{errors.website[0]}}</span>
            </md-field>
            <md-field>
                <label>Logo</label>
                <md-file v-model="companyData.logo" accept="image/*" @md-change="onFileUpload($event)"></md-file>
                <span v-if="errors.logofile" class="md-error">{{errors.logofile[0]}}</span>
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

            <md-button class="md-fab md-mini md-primary" @click="clickAdd()">
                <md-icon>add</md-icon>
            </md-button>

            <md-table-row>
                <md-table-head>Logo</md-table-head>
                <md-table-head>Name</md-table-head>
                <md-table-head>Email</md-table-head>
                <md-table-head>Website</md-table-head>
                <md-table-head>Action</md-table-head>
            </md-table-row>

            <md-table-row v-for="company in companies.data">
                <md-table-cell>
                    <img v-if="company.logo" :src="'/storage/' + company.logo" alt="">
                </md-table-cell>
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
        <pagination :data="companies" :limit="2" @pagination-change-page="getResults"></pagination>
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
            file: null
        }),
        mounted() {
            this.getResults()
        },
        methods: {
            getResults(page = 1) {
                axios.get('/companies?page=' + page)
                    .then(res => {
                        this.companies = res.data;
                    });
            },
            clickAdd() {
                this.companyData = {};
                this.errors = {};
                this.showModal = true;
            },
            clickEdit(company) {
                this.companyData = JSON.parse(JSON.stringify(company));
                this.errors = {};
                this.showModal = true;
            },
            clickDel(company) {
                this.companyData = company;
                this.deleteDialog = true;
            },
            prepareRequestData() {
                let formData = new FormData();
                if (this.companyData.name) {
                    formData.append("name", this.companyData.name);
                }
                if (this.companyData.email) {
                    formData.append("email", this.companyData.email);
                }
                if (this.companyData.website) {
                    formData.append("website", this.companyData.website);
                }
                if (this.file) {
                    formData.append("logofile", this.file);
                }

                return formData;
            },
            createCompany() {
                axios.post('/companies', this.prepareRequestData(), {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(() => {
                        this.showModal = false;
                        this.getResults()
                    }).catch(error => {
                        if(error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        }
                });
            },
            updateCompany() {
                axios.put('/companies/' + this.companyData.id, this.prepareRequestData(), {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(() => {
                        this.showModal = false;
                        this.getResults(this.companies.current_page)
                    }).catch(error => {
                    if(error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                });
            },
            deleteCompany() {
                axios.delete('/companies/' + this.companyData.id)
                    .then(() => {
                        this.deleteDialog = false;
                        this.getCompanies()
                    });
            },
            onFileUpload(event) {
                this.file = event[0]
            }
        }
    }
</script>


