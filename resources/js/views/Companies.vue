<template>
    <md-content>
        <md-dialog :md-active.sync="deleteDialog" style="padding: 0 2rem">
            <p>{{$parent.langs.confirm_delete}}</p>
            <md-button class="md-primary" @click="deleteDialog = false">{{$parent.langs.close}}</md-button>
            <md-button class="md-accent" @click="deleteCompany()">{{$parent.langs.delete}}</md-button>
        </md-dialog>

        <md-dialog :md-active.sync="showModal" style="padding: 0 2rem">
            <md-dialog-title v-if="companyData.id">{{$parent.langs.edit_company}}</md-dialog-title>
            <md-dialog-title v-else>{{$parent.langs.new_company}}</md-dialog-title>

            <md-field>
                <label>{{$parent.langs.name}}</label>
                <md-input v-model="companyData.name" required></md-input>
                <span v-if="errors.name" class="md-error">{{errors.name[0]}}</span>
            </md-field>
            <md-field>
                <label>{{$parent.langs.email}}</label>
                <md-input v-model="companyData.email" required></md-input>
                <span v-if="errors.email" class="md-error">{{errors.email[0]}}</span>
            </md-field>
            <md-field>
                <label>{{$parent.langs.website}}</label>
                <md-input v-model="companyData.website"></md-input>
                <span v-if="errors.website" class="md-error">{{errors.website[0]}}</span>
            </md-field>
            <md-field>
                <label>{{$parent.langs.logo}}</label>
                <md-file v-model="companyData.logo" accept="image/*" @md-change="onFileUpload($event)"></md-file>
                <span v-if="errors.logofile" class="md-error">{{errors.logofile[0]}}</span>
            </md-field>

            <md-dialog-actions>
                <md-button class="md-primary" @click="showModal = false">{{$parent.langs.close}}</md-button>
                <md-button v-if="companyData.id" class="md-primary" @click="updateCompany()">{{$parent.langs.save}}</md-button>
                <md-button v-else class="md-primary" @click="createCompany()">{{$parent.langs.save}}</md-button>
            </md-dialog-actions>
        </md-dialog>


        <md-table md-card>
            <md-table-toolbar>
                <h1 class="md-title">{{$parent.langs.companies}}</h1>
            </md-table-toolbar>

            <md-button class="md-fab md-mini md-primary" @click="clickAdd()">
                <md-icon>add</md-icon>
            </md-button>

            <md-table-row>
                <md-table-head>{{$parent.langs.logo}}</md-table-head>
                <md-table-head>{{$parent.langs.name}}</md-table-head>
                <md-table-head>{{$parent.langs.email}}</md-table-head>
                <md-table-head>{{$parent.langs.website}}</md-table-head>
                <md-table-head>{{$parent.langs.action}}</md-table-head>
            </md-table-row>

            <md-table-row v-for="company in companies.data">
                <md-table-cell>
                    <img width="100" v-if="company.logo" :src="'/storage/' + company.logo" alt="">
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
        <pagination :data="companies" :limit="2" @pagination-change-page="getResults">
            <span slot="prev-nav">&lt;</span>
            <span slot="next-nav">&gt;</span>
        </pagination>
    </md-content>
</template>

<script>
    export default {
        name: 'Companies',
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
                let formData = this.prepareRequestData();
                formData.append('_method', 'PUT');
                axios.post('/companies/' + this.companyData.id, formData, {
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


