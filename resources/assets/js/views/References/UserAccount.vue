<template>
    <div><!-- main container -->
        <notifications group="notification" />
        <div class="animated fadeIn"> <!-- main div -->
            <b-row> <!-- main row -->
                <b-col sm="12">
                    <b-card > <!-- main card -->
                     <template #header>
              <div style="height:25px">
              <b-row>
               <b-col sm="4">
                 <h5 >
                   <span style="color: #FF8C00;">
                      User Account
                  </span>
                </h5>
              </b-col>

              <b-col sm="7">
                <span></span>
              </b-col>

              <b-col sm="1">
                <b-form-group style="float:right; margin-top:3px;">
                <b-button variant="primary" @click="showModalEntry = true, entryMode='Add', clearFields('user')">
                    <i class="fa fa-plus-circle"></i>New User
                </b-button>
              </b-form-group>
              </b-col>
              </b-row>
              </div>
              </template>
                        <b-row class="mb-2"> <!-- row button and search input -->
                            <b-col sm="4">
                            </b-col>

                            <b-col  sm="5">
                                <span></span>
                            </b-col>

                            <b-col  sm="3">
                                <b-form-input 
                                    v-model="filters.users.criteria"
                                    type="text" 
                                    placeholder="Search">
                                </b-form-input>
                            </b-col>
                        </b-row> <!-- row button and search input -->
                    
                        <b-row> <!-- row table -->
                            <b-col sm="12">
                                <b-table 
                                    responsive striped hover small bordered show-empty
                                    :filter="filters.users.criteria"
                                    :fields="tables.users.fields"
                                    :items.sync="tables.users.items"
                                    :current-page="paginations.users.currentPage"
                                    :per-page="paginations.users.perPage"
                                > <!-- table -->

                                <template v-slot:cell(action)="data">
                                    <b-btn
                                    :size="'sm'"
                                    variant="primary"
                                    @click="setUpdate(data)"
                                >
                                    <i class="fa fa-edit"></i>
                                </b-btn>
                                <b-btn
                                    :size="'sm'"
                                    variant="danger"
                                    @click="setDelete(data)"
                                >
                                    <i class="fa fa-trash"></i>
                                </b-btn>
                                </template>

                                </b-table> <!-- table -->
                            </b-col>
                        </b-row> <!-- row table -->

                        <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1">
                                    <b-pagination size="sm" align="right" 
                                    :total-rows="paginations.users.totalRows" 
                                    :per-page="paginations.users.perPage" 
                                    v-model="paginations.users.currentPage"
                                     class="my-0" />
                                </b-col>
                        </b-row> <!-- Pagination -->
                        
                    </b-card><!-- main card -->
                </b-col>
            </b-row> <!-- main row -->

        </div><!-- main div -->

        <div> <!-- modal div -->
            <b-modal 
                v-model="showModalEntry"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
                @shown="focusElement('fullname')"
                size="lg"
            >
            
            <div slot="modal-title"> <!-- modal title -->
                {{entryMode}} User
            </div> <!-- modal title -->

            <b-col lg=12> <!-- modal body -->
                <b-form @keydown="resetFieldStates('user')" autocomplete="off">
                    <b-row>
                    <b-col lg=6>
                    <b-form-group>
                        <label for="fullname">* Full Name</label>
                        <b-form-input
                            id="fullname"
                            v-model="forms.user.fields.fullname"
                            type="text"
                            placeholder="Full Name"
                            ref="fullname">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                        <label>* Username</label>
                        <b-form-input
                            ref="username"
                            id="username"
                            v-model="forms.user.fields.username"
                            type="text"
                            placeholder="Username">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                        <label>Password</label>
                        <b-form-input
                            ref="password"
                            id="password"
                            v-model="forms.user.fields.password"
                            type="password"
                            placeholder="Password">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                        <label>Confirm Password</label>
                        <b-form-input
                            ref="password_confirmation"
                            id="password_confirmation"
                            v-model="forms.user.fields.password_confirmation"
                            type="password"
                            placeholder="Confirm Password">
                        </b-form-input>
                    </b-form-group>
                    </b-col>
                    <b-col lg=6>
                    <b-form-group>
                    <label for="company_access">* Company</label>
                    <select2
                      ref="company_access"
                      :allowClear="false"
                      :placeholder="'Select Company'"
                      v-model="forms.user.fields.company_access"
                    >
                      <option
                        v-for="co in options.company.items"
                        :key="co.comr_hash"
                        :value="co.comr_hash"
                      >{{co.co_code}}</option>
                     </select2>
                    </b-form-group>
                    <b-form-group>
                    <label for="branch_access">* Branch</label>
                    <select2
                      ref="branch_access"
                      :allowClear="false"
                      :placeholder="'Select Branch'"
                      v-model="forms.user.fields.branch_access"
                    >
                      <option
                        v-for="br in options.branch.items"
                        :key="br.brmr_hash"
                        :value="br.brmr_hash"
                      >{{br.br_code}}</option>
                     </select2>
                    </b-form-group>
                    <b-form-group>
                    <label for="warehouse_access">* Warehouse</label>
                    <select2
                      ref="warehouse_access"
                      :allowClear="false"
                      :placeholder="'Select Warehouse'"
                      v-model="forms.user.fields.warehouse_access"
                    >
                      <option
                        v-for="wh in options.ware.items"
                        :key="wh.whmr_hash"
                        :value="wh.whmr_hash"
                      >{{wh.wh_code}}</option>
                     </select2>
                    </b-form-group>
                    </b-col>
                    </b-row>
                </b-form>
            </b-col> <!-- modal body -->

            <div slot="modal-footer"><!-- modal footer buttons -->
                <b-button :disabled="forms.user.isSaving" variant="primary" @click="onUserEntry">
                    <icon v-if="forms.user.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Save
                </b-button>
                <b-button variant="secondary" @click="showModalEntry = false">Close</b-button>
            </div> <!-- modal footer buttons -->

            </b-modal>
            <b-modal 
                v-model="showModalDelete"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
            >
                <div slot="modal-title">
                    Delete user
                </div>
                <b-col lg=12>
                    Are you sure you want to delete this User Account?
                </b-col>
                <div slot="modal-footer">
                    <b-button :disabled="forms.user.isSaving" variant="primary" @click="onuserDelete">
                        <icon v-if="forms.user.isSaving" name="sync" spin></icon>
                        <i class="fa fa-check"></i>
                        OK
                    </b-button>
                    <b-button variant="secondary" @click="showModalDelete=false">Close</b-button>            
                </div>
            </b-modal>
        </div> <!-- modal div -->

    </div> <!-- main container -->

   
</template>

<script>
export default {
    name: 'users',
    data () {
      return {
        entryMode: 'Add',
        showModalEntry: false, //if true show modal
        showModalDelete: false,
        forms:{
            user : {
                isSaving: false,
                isDeleting: false,
                fields: {
                    user_hash: null,
                    fullname: null,
                    username: null,
                    password: null,
                    password_confirmation: null,
                    user_type: null,
                    co_code: null,
                    br_code: null,
                    wh_code: null,
                    sort_key: 0
                }
            }
        },
        tables: {
            users: {
                fields: [
                {
                    key: 'fullname',
                    label: 'Full Name',
                    tdClass: 'align-middle',
                    sortable: true
                },
                {
                    key: 'username',
                    label: 'User Name',
                    tdClass: 'align-middle',
                    sortable: true
                },
                {
                    key: 'co_code',
                    label: 'Company',
                    tdClass: 'align-middle',
                    sortable: true
                },
                {
                    key: 'br_code',
                    label: 'Branch',
                    tdClass: 'align-middle',
                    sortable: true
                },
                {
                    key: 'wh_code',
                    label: 'Warehouse',
                    tdClass: 'align-middle',
                    sortable: true
                },
                {   
                    key: 'action',
                    label: '',
                    thStyle: {width: '80px'},
                    tdClass: 'text-center'
                },
                ],
                items: []
            }
        },
        filters: {
          users: {
            criteria: null
          }
        },
        paginations: {
          users: {
            totalRows: 0,
            currentPage: 1,
            perPage: 10
          }
        },
        options: {
            company: {
            items: []
            },
            branch: {
            items: [] 
            },
            ware: {
            items: [] 
            }
        },
        user_hash: null,
        row: []
      }
    },
    methods:{
        onUserEntry () {
            if(this.entryMode == 'Add'){
                this.createEntity('user', true, 'users')
                
            }
            else{
                this.updateEntity('user', 'user_hash', true, this.row)
            }
        },
        onuserDelete(){
            this.deleteEntity('user', this.user_hash, true, 'users', 'user_hash')
        },
        async setDelete(data){
            if(await this.checkIfUsed('user', data.item.user_hash) == true){
                this.$notify({
                    type: 'error',
                    group: 'notification',
                    title: 'Error!',
                    text: "Unable to delete, this record is being used by other transactions."
                })
                return
            }
            this.user_hash = data.item.user_hash
            this.showModalDelete = true
        },
        setUpdate(data) {
        this.row = data.item;
        console.log(this.row);
        this.$http.get('api/user/'+data.item.user_hash, {
            headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
            }
        }).then(response => {
            // this.forms.user.fields = response.data.user
            this.forms.user.fields = response.data.users
            this.showModalEntry = true
            this.entryMode = 'Edit'
        }).catch(err => {
            console.log(err)
        })
        },
        loadUsers() {
       this.$http.get('api/users', {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
        }).then(response => {
            this.tables.users.items = response.data.users
            this.paginations.users.totalRows = response.data.users.length
            this.options.company.items = response.data.company
            this.options.branch.items = response.data.branch
            this.options.ware.items = response.data.ware
        }).catch(error => {
            console.log(error)
        })
    }
    },
    created () {
    this.loadUsers()
  }
}
</script>

