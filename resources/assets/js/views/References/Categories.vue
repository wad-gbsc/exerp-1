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
                            <b-col sm="9">
                                <h5 >
                                <span style="color: #FF8C00;">
                                    Categories
                                </span>
                                </h5>
                            </b-col>

                            <b-col sm="2">
                                <b-form-input 
                                    v-model="filters.categories.criteria"
                                    type="text" 
                                    placeholder="Search">
                                </b-form-input>
                            </b-col>

                            <b-col sm="1">
                                <b-form-group style="float:right; margin-top:3px;">
                                <!-- <b-button variant="primary" @click="showModalEntry = true, entryMode='Add', clearFields('category')">
                                       New Category
                                </b-button> -->
                                <b-button @click="showModalEntry = true, entryMode='Add', clearFields('category')" 
                                variant="success"
                                ><i class="fa fa-plus"></i>
                                </b-button>
                            </b-form-group>
                            </b-col>
                            </b-row>
                            </div>
                        </template>
                        
                        <b-row class="mb-2"> <!-- row button and search input -->
                            <b-col sm="4">
                                
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                               
                            </b-col>
                        </b-row> <!-- row button and search input -->
                    
                        <b-row> <!-- row table -->
                            <b-col sm="12">
                                <b-table 
                                    responsive striped hover small bordered show-empty
                                    :filter="filters.categories.criteria"
                                    :fields="tables.categories.fields"
                                    :items.sync="tables.categories.items"
                                    :current-page="paginations.categories.currentPage"
                                    :per-page="paginations.categories.perPage"
                                > <!-- table -->

                                <template v-slot:cell(action)="data">
                                    <b-btn :size="'sm'" variant="primary" @click="setUpdate(data)">
                                        <i class="fa fa-edit"></i>
                                    </b-btn>
                                    <b-btn :size="'sm'" :disabled="forms.category.isDeleting" variant="danger" @click="setDelete(data)">
                                            <icon v-if="forms.category.isDeleting" name="sync" spin></icon>
                                            <i v-else class="fa fa-trash"></i>
                                        </b-btn>
                                </template>

                                </b-table> <!-- table -->
                            </b-col>
                        </b-row> <!-- row table -->

                        <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.categories.totalRows" :per-page="paginations.categories.perPage" v-model="paginations.categories.currentPage"
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
                @shown="focusElement('product_type')"
            >
            
            <div slot="modal-title"> <!-- modal title -->
                {{entryMode}} Category
            </div> <!-- modal title -->

            <b-col lg=12> <!-- modal body -->
                <b-form @keydown="resetFieldStates('category')" autocomplete="off">
                    <b-form-group>
                        <label for="product_type">* Category Code</label>
                        <b-form-input
                            id="product_type"
                            v-model="forms.category.fields.product_type"
                            type="text"
                            placeholder="Category Code"
                            ref="product_type">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                        <label>* Category Description</label>
                        <b-form-input
                            ref="product_desc"
                            id="product_desc"
                            v-model="forms.category.fields.product_desc"
                            type="text"
                            placeholder="Category Description">
                        </b-form-input>
                    </b-form-group>
                </b-form>
            </b-col> <!-- modal body -->

            <div slot="modal-footer"><!-- modal footer buttons -->
                <b-button :disabled="forms.category.isSaving" variant="primary" @click="onCategoryEntry">
                    <icon v-if="forms.category.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Save
                </b-button>
                <b-button variant="secondary" @click="showModalEntry=false">Close</b-button>
            </div> <!-- modal footer buttons -->

            </b-modal>
            <b-modal 
                v-model="showModalDelete"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
            >
                <div slot="modal-title">
                    Delete Category
                </div>
                <b-col lg=12>
                    Are you sure you want to delete this Category?
                </b-col>
                <div slot="modal-footer">
                    <b-button :disabled="forms.category.isSaving" variant="primary" @click="onCategoryDelete">
                        <icon v-if="forms.category.isSaving" name="sync" spin></icon>
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
    name: 'categories',
    data () {
      return {
        entryMode: 'Add',
        showModalEntry: false, //if true show modal
        showModalDelete: false,
        selected: 'radio1',
            options: [
            { text: 'Average', value: 'A' },
            { text: ' FIFO ', value: 'F' },
            { text: 'Standard', value: 'S' },
            ],
        forms:{
            category : {
                isSaving: false,
                isDeleting: false,
                fields: {
                    inty_hash: null,
                    product_type: null,
                    product_desc: null
                }
            }
        },
        tables: {
            categories: {
                fields: [
                {
                    key: 'product_type',
                    label: 'Category Code',
                    thStyle: {width: '150px'},
                    tdClass: 'align-middle',
                    sortable: true
                },
                {
                    key: 'product_desc',
                    label: 'Category Description',
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
          categories: {
            criteria: null
          }
        },
        paginations: {
          categories: {
            totalRows: 0,
            currentPage: 1,
            perPage: 10
          }
        },
        inty_hash: null,
        row: []
      }
    },
    methods:{
        onCategoryEntry () {
            if(this.entryMode == 'Add'){
                this.createEntity('category', true, 'categories')
            }
            else{
                this.updateEntity('category', 'inty_hash', true, this.row)
            }
        },
        onCategoryDelete(){
            this.deleteEntity('category', this.inty_hash, true, 'categories', 'inty_hash')
        },
        async setDelete(data){
            if(await this.checkIfUsed('category', data.item.inty_hash) == true){
                // this.$notify({
                //     type: 'error',
                //     group: 'notification',
                //     title: 'Error!',
                //     text: "Unable to delete, this record is being used by other transactions."
                // })
                return
            }
            this.inty_hash = data.item.inty_hash
            this.showModalDelete = true
        },
        setUpdate(data){
            this.row = data.item
            this.resetFieldStates('category')
            this.fillEntityForm('category', data.item.inty_hash)
            this.showModalEntry=true
            this.entryMode='Edit'
        }
    },
    created () {
      this.fillTableList('categories')
    }
  }
</script>

