<template>
    <md-content>
        <md-dialog :md-active.sync="deleteDialog" style="padding: 0 2rem">
            <p>Are you sure you want to delete?</p>
            <md-button class="md-primary" @click="deleteDialog = false">Close</md-button>
            <md-button class="md-accent" @click="deleteEmploee()">Delete</md-button>
        </md-dialog>

        <md-dialog :md-active.sync="showModal" style="padding: 0 2rem">
            <md-dialog-title v-if="emploeeData.id">Edit emploee</md-dialog-title>
            <md-dialog-title v-else>New emploee</md-dialog-title>

            <md-field>
                <label>First name</label>
                <md-input v-model="emploeeData.first_name" required></md-input>
                <span v-if="errors.first_name" class="md-error">{{errors.first_name[0]}}</span>
            </md-field>
            <md-field>
                <label>Last name</label>
                <md-input v-model="emploeeData.last_name" required></md-input>
                <span v-if="errors.last_name" class="md-error">{{errors.last_name[0]}}</span>
            </md-field>
            <md-autocomplete :md-options="companies" @md-changed="getCompanies"
                             @md-opened="getCompanies" @md-selected="companySelected" required>
                <label>Company</label>

                <template slot="md-autocomplete-item" slot-scope="{ item, term }">{{ item.name }}</template>
                <span v-if="errors.company_id" class="md-error">{{errors.company_id[0]}}</span>
            </md-autocomplete>
            <md-field>
                <label>Email</label>
                <md-input v-model="emploeeData.email"></md-input>
                <span v-if="errors.email" class="md-error">{{errors.email[0]}}</span>
            </md-field>
            <md-field>
                <label>Phone</label>
                <md-input v-model="emploeeData.phone"></md-input>
                <span v-if="errors.phone" class="md-error">{{errors.phone[0]}}</span>
            </md-field>

            <md-dialog-actions>
                <md-button class="md-primary" @click="showModal = false">Close</md-button>
                <md-button v-if="emploeeData.id" class="md-primary" @click="updateEmploee()">Save</md-button>
                <md-button v-else class="md-primary" @click="createEmploee()">Save</md-button>
            </md-dialog-actions>
        </md-dialog>


        <md-table md-card>
            <md-table-toolbar>
                <h1 class="md-title">Emploees</h1>
            </md-table-toolbar>

            <md-button class="md-fab md-mini md-primary" @click="clickAdd()">
                <md-icon>add</md-icon>
            </md-button>

            <md-table-row>
                <md-table-head>First name</md-table-head>
                <md-table-head>Last name</md-table-head>
                <md-table-head>Company</md-table-head>
                <md-table-head>Email</md-table-head>
                <md-table-head>Phone</md-table-head>
            </md-table-row>

            <md-table-row v-for="emploee in emploees.data">
                <md-table-cell>{{emploee.first_name}}</md-table-cell>
                <md-table-cell>{{emploee.last_name}}</md-table-cell>
                <md-table-cell>{{emploee.company.name}}</md-table-cell>
                <md-table-cell>{{emploee.email}}</md-table-cell>
                <md-table-cell>{{emploee.phone}}</md-table-cell>
                <md-table-cell>
                    <md-button class="md-icon-button md-primary" @click.prevent="clickEdit(emploee)">
                        <md-icon>edit</md-icon>
                    </md-button>

                    <md-button class="md-icon-button md-accent" @click.prevent="clickDel(emploee)">
                        <md-icon>delete</md-icon>
                    </md-button>
                </md-table-cell>
            </md-table-row>
        </md-table>
        <pagination :data="emploees" :limit="2" @pagination-change-page="getResults"></pagination>
    </md-content>
</template>

<script>
    export default {
        name: 'Emploees',
        data: () => ({
            companies: [],
            emploees: {},
            emploeeData: {},
            errors: {},
            sending: false,
            showModal: false,
            deleteDialog: false,
            file: null
        }),
        mounted() {
            this.getResults();
        },
        methods: {
            getResults(page = 1) {
                axios.get('/emploees?page=' + page)
                    .then(res => {
                        this.emploees = res.data;
                    });
            },
            getCompanies(searchTerm) {
                this.companies = new Promise(resolve => {
                        if (!searchTerm) {
                            axios.get('/companies-autocomplete?search=')
                                .then(res => {
                                    resolve(res.data);
                                })
                        } else {
                            axios.get('/companies-autocomplete?search=' + searchTerm)
                                .then(res => {
                                    resolve(res.data);
                                })
                        }
                })
            },
            companySelected(company){
                this.emploeeData.company_id = company.id;
            },
            clickAdd() {
                this.emploeeData = {};
                this.errors = {};
                this.showModal = true;
            },
            clickEdit(emploee) {
                this.emploeeData = JSON.parse(JSON.stringify(emploee));
                this.errors = {};
                this.showModal = true;
            },
            clickDel(emploee) {
                this.emploeeData = emploee;
                this.deleteDialog = true;
            },
            createEmploee() {
                axios.post('/emploees', this.emploeeData)
                    .then(() => {
                        this.showModal = false;
                        this.getResults()
                    }).catch(error => {
                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                });
            },
            updateEmploee() {
                delete this.emploeeData.company;
                axios.put('/emploees/' + this.emploeeData.id, this.emploeeData)
                    .then(() => {
                        this.showModal = false;
                        this.getResults(this.emploees.current_page)
                    }).catch(error => {
                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                });
            },
            deleteEmploee() {
                axios.delete('/emploees/' + this.emploeeData.id)
                    .then(() => {
                        this.deleteDialog = false;
                        this.getResults(this.emploees.current_page);
                    });
            },
            onFileUpload(event) {
                this.file = event[0]
            }
        }
    }
</script>

<style>
    .md-menu-content {
        z-index: 11;
    }
</style>