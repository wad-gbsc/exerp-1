<template>
<div>
    
    <b-card>
           <template #header>
                        <div style="height:25px;">
                        <b-row>
                        <b-col lg="4">
                        <h5>  <!-- table header -->
                            <span style="color: #FFA500;">
                                
                             Product Maintenance
                                <!-- <small class="font-italic">List of all registered Card type.</small> -->
                                </span>
                        </h5>
                        </b-col>
                          <b-col lg="4"></b-col>
                        <b-col lg="4">
                        <b-form-group style="float:right; margin-top:3px;">
                        <b-button variant="danger" @click="setDelete()"><i class="fa fa-ban" ></i> Delete</b-button>
                        <b-button variant="outline-primary" @click="clearFields('products') , entryMode = 'Add', forms.products.fields.status = 'A', forms.products.fields.costing = 'A'"><i class="fa fa-eraser" ></i> Clear</b-button>
                        <b-button variant="primary"  @click="onProductEntry() "><icon v-if="forms.products.isSaving" name="sync" spin></icon><i class="fa fa-floppy-o"></i> Save</b-button>
                        </b-form-group>
                         </b-col>
                        </b-row>
                        </div>
                        </template>
                        <b-row>
                            <b-col lg="2">
                                <span></span>
                            </b-col>

                            <b-col lg="4">
                                <input type="hidden" v-model="forms.products.fields.inmr_hash"/>
                                <b-row class="my-2">
                                    <b-col sm="3">
                                    <label for="item_no" style="float:right; margin-top:6px;">* Item Code</label>
                                    </b-col>
                                    <b-col sm="8">
                                    <b-input-group-append>
                                    <b-form-input
                                    v-model="forms.products.fields.item_no"
                                    ref="item_no"
                                    id="item_no"
                                    type="text"
                                    placeholder="Item Code">
                                </b-form-input>
                                
                                <b-button squared variant="primary" size="sm" @click="showModalINMR = true"><span style="font-size: 15px;"><i class="fa fa-search"></i></span></b-button>
                                </b-input-group-append>
                                    </b-col>    
                                </b-row>
                                <b-row class="my-2">
                                    <b-col sm="3">
                                    <label for="description" style="float:right; margin-top:6px;">* Item Name</label>
                                    </b-col>
                                    <b-col sm="8">
                                    <b-form-input
                                    v-model="forms.products.fields.description"
                                    ref="description"
                                    id="description"
                                    type="text"
                                    placeholder="Item Name">
                                </b-form-input>
                                </b-col>    
                                </b-row>
                                </b-col>
                            <b-col lg="4">
                                <b-row class="my-2">
                                    <b-col sm="3">
                                    <label  style="float:right; margin-top:6px;">* Status</label>
                                    </b-col>
                                    <b-col sm="8">
                                        <b-form-radio-group
                                            v-model="forms.products.fields.status"
                                            :options="statusOption"
                                            buttons
                                            button-variant="outline-primary"
                                            size="sm"
                                        ></b-form-radio-group>
                                        <!-- <c-switch 
                                        squared
                                        type="text" 
                                        variant="primary" 
                                        on="On" 
                                        off="Off"
                                        :pill="true"/> -->
                                       
                                    
                                     <!-- :ref="row.item.user_group_id + '-' + module.module_id + '-' + right.module_right_id" 
                                        :checked="right.rights == 0 ? false : true" -->
                                    <!-- <cSwitch  class="switch switch-3d switch-primary" size="lg"  labelOn="'ON'" labelOff="'OFF'"/>
                                     -->
                                   <!--   <label class="switch switch-3d switch-primary">
                                    <input type="checkbox" class="switch-input" checked>
                                    <span class="switch-label"></span>
                                    <span class="switch-handle"></span>
                                </label> -->
                                </b-col>    
                                </b-row>
                            </b-col>
                            <b-col lg="2">
                                <span></span>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col lg="2"><span></span></b-col>
                            <b-col lg="4">
                                <b-row class="my-2">
                                    <b-col sm="3">
                                    <label for="" style="float:right; margin-top:6px;">* Description</label>
                                    </b-col>
                                    <b-col sm="9">
                                    <b-form-textarea
                                    style="width: 100%"
                                    ref=""
                                    id=""
                                    type="textarea"
                                    placeholder="Description"
                                    >
                                </b-form-textarea>
                                </b-col>    
                                </b-row>
                            </b-col>
                            <b-col lg="4"><span></span></b-col>
                            <b-col lg="2"><span></span></b-col>
                        </b-row>
                        <hr>

                    <b-row>
                        <b-col lg="2"><h6 style="color:#FFA500;">Item Details</h6></b-col>
                        <b-col lg="4"> 
                            <b-row class="my-2">
                                    <b-col sm="3">
                                    <label for="barcode" style="float:right; margin-top:6px;">* Barcode</label>
                                    </b-col>
                                    <b-col sm="8">
                                    <b-form-input
                                    v-model="forms.products.fields.barcode"
                                    ref="barcode"
                                    id="barcode"
                                    type="text"
                                    placeholder="Barcode">
                                </b-form-input>
                                </b-col>    
                            </b-row>
                            <b-row class="my-2">
                                    <b-col sm="3">
                                    <label for="product_type" style="float:right; margin-top:6px;">* Category</label>
                                    </b-col>
                                    <b-col sm="8">
                                    <select2
                                    ref="product_type"
                                    id="product_type"
                                    :allowClear="false"
                                    :placeholder="'Select Category'"
                                    v-model="forms.products.fields.product_type"
                                    >
                                    <option
                                        v-for="inty in options.inty.items"
                                        :key="inty.product_type"
                                        :value="inty.product_type"
                                    >{{inty.product_desc}}</option>
                                    </select2>
                                </b-col>    
                            </b-row>
                             <b-row class="my-2">
                                    <b-col sm="3">
                                    <label for="uom_code" style="float:right; margin-top:6px;">* UOM</label>
                                    </b-col>
                                    <b-col sm="8">
                                    <select2
                                    ref="uom_code"
                                    id="uom_code"
                                    :allowClear="false"
                                    :placeholder="'Select Unit'"
                                    v-model="forms.products.fields.uom_code">

                                    </select2>
                                </b-col>    
                            </b-row>
                            <b-row class="my-2">
                            <b-col sm="4">
                            <label for="markup_pc" style="float:right; margin-top:3px;">* Item Markup %</label>
                            </b-col>
                            <b-col sm="6">
                            <vue-autonumeric
                                    v-model="forms.products.fields.markup_pc"
                                    ref="markup_pc"
                                    id="markup_pc"
                                    class="form-control text-right"
                                    :options="{
                                                    minimumValue: '0', 
                                                    emptyInputBehavior:'0',}"
                                ></vue-autonumeric>
                        </b-col>
                        </b-row>
                        </b-col>
                        <b-col lg="1"></b-col>
                          <b-col lg="3">
                              <br>
                              <br> 
                                <b-row class="my-2">
                            <b-col sm="5">
                            <label style="float:right; margin-top:3px;">* Costing Type.</label>
                            </b-col>
                            <b-col sm="7">
                           <b-form-radio-group
                                v-model="forms.products.fields.costing"
                                :options="costOption"
                                button-variant="outline-primary"
                                size="sm"
                                buttons
                            ></b-form-radio-group>
                        </b-col>
                        </b-row>
                          
                             <b-row class="my-2">
                            <b-col sm="5">
                            <label for="po_qty" style="float:right; margin-top:3px;">* Minimum Qty.</label>
                            </b-col>
                            <b-col sm="7">
                            <vue-autonumeric
                                    ref="po_qty"
                                    id="po_qty"
                                    class="form-control text-left"
                                    :options="{
                                                    minimumValue: '0', 
                                                    emptyInputBehavior:'0',}"
                                ></vue-autonumeric>
                        </b-col>
                        </b-row>
                        <b-row class="my-2">
                            <b-col sm="5">
                            <label for="cost" style="float:right; margin-top:3px;">* Last Cost</label>
                            </b-col>
                            <b-col sm="7">
                            <vue-autonumeric
                                    v-model="forms.products.fields.cost"
                                    ref="cost"
                                    id="cost"
                                    class="form-control text-right"
                                    :options="{
                                                    minimumValue: '0', 
                                                    emptyInputBehavior:'0',}"
                                ></vue-autonumeric>
                        </b-col>
                        </b-row>
                            </b-col>
                           <b-col lg="2"><span></span> </b-col>
                    </b-row>

    </b-card>
                <b-modal   
                header-bg-variant="primary"
                title="Products"
                v-model="showModalINMR"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
                size="lg">
                <b-row>
                    <b-col lg="12">
                        <b-table    
                            selectable
                            select-mode="single"
                            responsive striped hover small bordered show-empty
                            :fields="tables.inmr.fields"
                            :items.sync="tables.inmr.items"
                            @filttered="onFiltered($event, 'inmr')"
                            @row-selected="selectedRow = $event"
                        > 
                        </b-table> <!-- table -->
                    </b-col>
                </b-row>
                 <div slot="modal-footer">
                    <!-- modal footer buttons -->
                    <b-button variant="primary" @click="addProduct">
                    Accept
                    </b-button>
                    <b-button variant="secondary" @click="showModalINMR=false">Close</b-button>
                </div>
                </b-modal>
</div>
</template>
<script>
export default {
    name: 'products',
    data () {
      return {
          entryMode: 'Add',
          showModalINMR: false,
         
            statusOption: [
            { text: 'Active', value: 'A' ,},
            { text: 'Inactive', value: 'I' },
            ],
         
            costOption: [
            { text: 'Average', value: 'A' },
            { text: 'FIFO', value: 'F' },
            { text: 'Standard', value: 'S' },
            ],
        forms:{
            products : {
                isSaving: false,
                isDeleting: false,
                fields: {
                    inmr_hash: null,
                    status: 'A',
                    costing: 'A',
                    item_no: null,
                    description: null,
                    barcode: null,
                    product_type: null,
                    markup_pc: 0,
                    cost: 0,
                    uom_code: null,
                }
            }
        },
         tables: {
            inmr: {
                fields: [
                {
                    key: 'item_no',
                    label: 'Product Code',
                    thStyle: {width: '35px'},
                    tdClass: 'align-middle',
                    sortable: false
                },
                {
                    key: 'description',
                    label: 'Description',
                    thStyle: {width: '35px'},
                    tdClass: 'align-middle',
                    sortable: false
                },
                {
                    key: 'uom_code',
                    label: 'UOM',
                    thStyle: {width: '35px'},
                    tdClass: 'align-middle',
                    sortable: false
                },
                {
                    key: 'on_hand',
                    label: 'Available Qty.',
                    thStyle: {width: '35px'},
                    tdClass: 'align-middle',
                    sortable: false
                },
                {
                    key: 'price',
                    label: 'Unit Price',
                    thStyle: {width: '35px'},
                    tdClass: 'align-middle',
                    sortable: false
                },
                ],
                items: []
               
                },
            
        },
        options: {
          inty: {
            items: []
          }
        },
      }
    },
    methods: {
        addProduct() {
        if (this.selectedRow.length > 0) {
                if (
                         this.selectedRow[0].item_no == this.forms.products.fields.item_no
                        
                ) {
                        Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: 'Item is already added.',
                        showConfirmButton: false,
                        timer: 1500
                        })
                return;
                }
        
        //   inmr_hash: this.selectedRow[0].inmr_hash,
        this.entryMode = 'Edit'
        this.forms.products.fields.inmr_hash = this.selectedRow[0].inmr_hash,
        this.forms.products.fields.item_no = this.selectedRow[0].item_no,
        this.forms.products.fields.description = this.selectedRow[0].description
        this.forms.products.fields.barcode = this.selectedRow[0].barcode
        this.forms.products.fields.product_type = this.selectedRow[0].product_type
        this.forms.products.fields.status = this.selectedRow[0].status
        this.forms.products.fields.markup_pc = this.selectedRow[0].markup_pc
        this.forms.products.fields.costing = this.selectedRow[0].costing
        this.forms.products.fields.cost = this.selectedRow[0].cost
        this.forms.products.fields.uom_code = this.selectedRow[0].uom_code
        this.showModalINMR = false
        }
      },
    onProductEntry() {
                if (this.entryMode == "Add") {
                this.forms.products.isSaving = true;
                this.resetFieldStates('products');
                this.$http
                .post("api/products", this.forms.products.fields, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token")
                }
                })
                .then(response => {
                this.forms.products.isSaving = false;
                this.clearFields('products');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Successfully Created.',
                        showConfirmButton: false,
                        timer: 2000
                        })
                        this.loadProducts()
                        this.forms.products.fields.status = 'A'
                        this.forms.products.fields.costing = 'A'
                       
                })
                .catch(error => {
                this.forms.products.isSaving = false;
                if (!error.response) return;
                const errors = error.response.data.errors;
                var a = 0;
                for (var key in errors) {
                    if (a == 0) {
                    this.focusElement(key, false);
                    Toast.fire({
                    icon: 'error',
                    title: 'Error!',
                    showConfirmButton: false,
                    timer: 2000,
                    text: errors[key][0]
                    })
                    }
                    a++
                }
                });
                } else {
                    this.forms.products.isSaving = true;
                    this.resetFieldStates('products');
                    this.$http.put("api/products/"  + this.forms.products.fields.inmr_hash,
                        this.forms.products.fields,
                        {
                            headers: {
                            Authorization: "Bearer " + localStorage.getItem("token")
                            }
                        }
                        )
                        .then(response => {
                        this.forms.products.isSaving = false;
                        Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Successfully Updated.',
                                showConfirmButton: false,
                                timer: 2000
                                })
                                this.loadProducts()
                        

                })
                }
     },
     async setDelete() {
        
        this.inmr_hash = this.forms.products.fields.inmr_hash;

        if (this.inmr_hash == null || this.inmr_hash == 0 ) {
                 Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Select Product first',
                        showConfirmButton: false,
                        timer: 1500
                    })
        }else{
                    Swal.fire({
                    title: 'Are you sure?',
                    icon: 'question',
                    cancelButtonText: 'No',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Cancel it!',
                    text: "You won't be able to revert this!",
                    })
                 .then((result) => {
                        // Send request to the server
                         if (result.value) {
                                this.$http
                          .put(
                            "api/product/delete/" + this.inmr_hash,
                            this.forms.products.fields,
                            {
                              headers: {
                                Authorization: "Bearer " + localStorage.getItem("token")
                              }
                            }
                          ).then(()=>{
                                    Swal.fire(
                                    'Deleted!',
                                    'The Product has been deleted.',
                                    'success'
                                    )
                                    this.loadProducts()
                            }).catch(()=> {
                                    Swal.fire("Failed!", "There was something wronge.", "warning");
                            });
                         }
                    })
        }
      },
      loadProducts() {
            this.$http
        .get("api/products", {
            headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
            }
        })
        .then(response => {
            this.tables.inmr.items = response.data.inmr;
            this.options.inty.items = response.data.inty;
        })
        .catch(error => {
            console.log(error);
        });
      }
    },
     created () {
        this.loadProducts()
      },
    }

</script>