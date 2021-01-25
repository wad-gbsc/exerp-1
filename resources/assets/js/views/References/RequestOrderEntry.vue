<style scoped>
:disabled {
    cursor: not-allowed! important;
}
</style>
<template>
    <div><!-- main container -->
        <notifications group="notification" />
        <div class="animated fadeIn"> <!-- main div -->
            <b-row> <!-- main row -->
                <b-col sm="12">
                    <b-card >  <!-- main card -->
                    <template #header>
                        <div style="height:25px;">
                        <b-row>
                        <b-col lg="4">
                        <h5>  <!-- table header -->
                            <span style="color: #FFA500;">
                                
                                Request Order Entry 
                                <!-- <small class="font-italic">List of all registered Card type.</small> -->
                                </span>
                        </h5>
                        </b-col>
                        <b-col lg="4"></b-col>
                        <b-col lg="4">
                        <b-form-group style="float:right; margin-top:3px;">
                        <b-button variant="danger" @click="setDelete()" v-show="forms.poentry.fields.ord_req_no != null" :disabled="status_code === 'R' || status_code === 'A'"><i class="fa fa-ban"></i> Cancel</b-button>
                        <b-button variant="outline-primary" @click="status_code = null, clearFields('poentry'), tables.poe.items = [], forms.poentry.fields.required_date = '', entryMode = 'Add'"><i class="fa fa-eraser"></i> Clear</b-button>
                        <b-button variant="primary"  :disabled="forms.poentry.isSaving" @click="onPurchasemainEntry()"> <icon v-if="forms.poentry.isSaving" name="sync" spin></icon><i class="fa fa-floppy-o"></i> Save</b-button>
                        </b-form-group>
                         </b-col>
                        </b-row>
                        </div>
                        </template>
                        <b-row class="mb-2"> 
                        <b-col lg="2"></b-col>
                        <b-col lg="4">
                        <input v-model="forms.poentry.fields.psoh_hash" type="hidden" />
                        <b-form-group>
                        <label for="ord_req_no"> Request Order No.</label>
                        <select2
                        @input="getPoInfo"
                          ref="ord_req_no"
                          id="ord_req_no"
                          :allowClear="false"
                          :placeholder="'Select Request Order No.'"
                          v-model="forms.poentry.fields.ord_req_no"
                        >
                          <option
                            v-for="pur in options.psoh.items"
                            :key="pur.ord_req_no"
                            :value="pur.ord_req_no"
                          >{{pur.ord_req_no}}</option>
                        </select2>
                        </b-form-group>
                        <b-form-group>
                        <label for="rd">* Required Date</label>
                        <date-picker
                        :disabled="status_code == 'A' || status_code == 'R'"
                        v-model="forms.poentry.fields.required_date"
                        id="required_date"
                        ref="required_date"
                        format="MMMM/DD/YYYY"
                        type="date"
                        lang="en"
                        input-class="form-control mx-input"
                        :clearable="false"
                        placeholder="Select Target Date"
                        ></date-picker>
                        </b-form-group>
                           </b-col>
                        <b-col lg="4">
                        <b-form-group>
                        <label for="request_user">* Person Requisitioner RO</label>
                        <b-form-input
                            style="background-color:white;"
                            :disabled="status_code == 'A' || status_code == 'R'"
                            v-model="forms.poentry.fields.request_user"
                            id="request_user"
                            ref="request_user"
                            type="text"
                            placeholder="Person Requisitioner RO"
                            >
                        </b-form-input>
                        </b-form-group>
                        
                        <label for="status"> Status</label>
                        <h5>
                            <!-- <b-badge variant="primary" style="width: 20%;"
                            id="status"
                            ref="status">
                            {{status_code}}</b-badge> -->
                            <div v-show="status_code != 'X'">
                            <b-badge v-if="status_code == 'O'" pill variant="primary">{{"Open"}}</b-badge>
                            <b-badge v-else-if="status_code == 'A'" pill variant="warning" style="color: white;">{{"Approved"}}</b-badge>
                            <b-badge v-else-if="status_code == 'R'" pill variant="success" style="color: white;">{{"Receipted"}}</b-badge>
                            </div>
                            </h5>
                        </b-col>
                        <b-col lg="2"></b-col>
                        </b-row>
                       <hr/>
                        <b-row>
                            <b-col lg="2"></b-col>
                            <b-col lg="8">
                                <b-form-group>
                                <label for="textarea">* Reason for requesting</label>
                                <b-form-textarea
                                style="background-color:white;"
                                :disabled="status_code == 'A' || status_code == 'R'"
                                id="reason"
                                ref="reason"
                                v-model="forms.poentry.fields.reason"
                                placeholder="Reason for requesting"
                                rows="3"
                                max-rows="6"
                                ></b-form-textarea>
                            </b-form-group>
                            </b-col>
                            <b-col lg="2"></b-col>
                        </b-row>
                         <hr/>
                         <b-row>
                             <b-col lg="12">
                                 <b-button @click="showModalINMR = true" v-show="status_code == null || status_code == 'O'" style="float:right; margin-bottom: 5px; width: 5%;" variant="success"><i class="fa fa-plus"></i></b-button>
                             </b-col>
                         </b-row>
                        <b-row> <!-- row table -->
                            <b-col sm="12">
                                <b-table 
                                    responsive striped hover small bordered show-empty
                                     :fields="tables.poe.fields"
                                     :items.sync="tables.poe.items"
                                     
                                > <!-- table -->
                                <template v-slot:cell(order_qty)="data">
                                <vue-autonumeric
                                    ref="order_qty"
                                    id="order_qty"
                                    v-model="data.item.order_qty"
                                    class="form-control text-right"
                                    :options="{
                                                    minimumValue: '0', 
                                                    emptyInputBehavior:'0',}"
                                ></vue-autonumeric>
                                </template>
                                
                                 <template v-slot:cell(remarks)="data">
                                 <b-form-input
                                    v-model="data.item.remarks"
                                    id="remarks"
                                    ref="remarks"
                                    type="text"
                                    >
                                </b-form-input>
                                </template>

                                 <template v-slot:cell(action)="data">
                                <b-btn :size="'sm'" variant="danger" :disabled="status_code == 'A' || status_code == 'R' " @click="removeProduct(data.index)">
                                    <i class="fa fa-trash"></i>
                                </b-btn>
                                </template>
                                </b-table> <!-- table -->
                            </b-col>
                        </b-row> <!-- row table -->
                        
                    </b-card><!-- main card -->
                </b-col>
            </b-row> <!-- main row -->

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
                    <b-button variant="primary" @click="addItem">
                    Accept
                    </b-button>
                    <b-button variant="secondary" @click="showModalINMR=false">Close</b-button>
                </div>
             </b-modal>

        </div><!-- main div -->
    </div> <!-- main container -->
</template>

<script>
export default {
    name: 'poe',
    data () {
      return {
        status_code: null,
        selectedRow: [],
        entryMode: 'Add',
        showModalItems: false,
        showModalINMR: false,
        forms:{
            poentry : {
                isSaving: false,
                isDeleting: false,
                fields: {
                 psoh_hash: null,
                }
            }
        }, 
          tables: {
            poe: {
                fields: [
                // {
                //     key: 'inmr_hash',
                //     label: 'No.',
                //     thStyle: {width: '35px'},
                //     tdClass: 'align-middle',
                //     sortable: true
                // },
                {
                    key: 'item_no',
                    label: 'Product Code',
                    tdClass: 'align-middle',
                    thStyle: {width: '160px'},
                    sortable: true
                },
                {
                    key: 'description',
                    label: 'Description',
                    thStyle: {width: '200px'},
                    tdClass: 'align-middle',
                    sortable: false
                },
                {
                    key: 'uom_code',
                    label: 'UOM',
                    tdClass: 'align-middle',
                    sortable: false
                },
                {
                    key: 'available_qty',
                    label: 'Available Qty.',
                    thStyle: {width: '120px'},
                    tdClass: 'align-middle',
                    sortable: true
                },
                {
                    key: 'order_qty',
                    label: 'Request Qty.',
                    thStyle: {width: '120px'},
                    tdClass: 'align-middle',
                    sortable: true
                },
                {
                    key: 'price',
                    label: 'Unit Price',
                    tdClass: 'align-middle',
                    sortable: true
                },
                {
                    key: 'remarks',
                    label: 'Remarks',
                    tdClass: 'align-middle',
                    sortable: false
                },
                {   
                    key: 'action',
                    label: '',
                    thStyle: {width: '80px'},
                    tdClass: 'text-center'
                },
                ],
                items: []
            },
            inmr: {
                fields: [
                // {
                //     key: 'inmr_hash',
                //     label: '',
                //     thStyle: {width: '15px'},
                //     tdClass: 'align-middle',
                //     sortable: false
                // },
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
          psoh: {
            items: []
          }
        },
        // filters: {
        //   cardtypes: {
        //     criteria: null
        //   }
        // },
        // paginations: {
        //   cardtypes: {
        //     totalRows: 0,
        //     currentPage: 1,
        //     perPage: 10
        //   }
        // },
        // card_type_id: null,
        // row: []
     
      }
    },
    methods:{
    getPoInfo: function(value,data)  {
      if (data.length > 0) {
        this.entryMode = "Edit";
        var po = this.options.psoh.items[data[0].element.index]
        
        this.forms.poentry.fields.psoh_hash = po.psoh_hash
        this.forms.poentry.fields.ord_req_no = po.ord_req_no
        this.forms.poentry.fields.required_date = po.required_date
        this.forms.poentry.fields.request_user = po.request_user
        this.status_code = po.status_code
        this.forms.poentry.fields.reason = po.reason
         this.$http.get("api/getpoitems/"+po.psoh_hash,{
             headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
          }).then(response => {
            this.tables.poe.items = response.data
          })
          .catch(err=>{
            console.log(err)
          })
      }
    },
    onPurchasemainEntry() {

        if (this.status_code === 'A' || this.status_code === 'R') {
            Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'You cannot Update this Request Order.',
            showConfirmButton: false,
            timer: 2000
            })

        }else{
            if (this.tables.poe.items.length > 0) {
                this.forms.poentry.fields.items = this.tables.poe.items;
                if (this.entryMode == "Add") {
                this.forms.poentry.isSaving = true;
                this.resetFieldStates('poentry');
                this.$http
                .post("api/poentry", this.forms.poentry.fields, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token")
                }
                })
                .then(response => {
                this.forms.poentry.isSaving = false;
                this.clearFields('poentry');

                this.$http
                    .get("api/getRequest", {
                        headers: {
                        Authorization: "Bearer " + localStorage.getItem("token")
                        }
                    })
                    .then(response => {
                        
                        this.getRequest = response.data;
                        console.log(this.getRequest)
                    })
                    .catch(error => {
                        console.log(error);
                    });
                    
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Successfully Created.',
                        text: this.getRequest,
                        showConfirmButton: false,
                        timer: 2000
                        })
                        this.tables.poe.items = [];
                        this.forms.poentry.fields.required_date = ''
                        this.loadPurchaseOrder();
                        this.status_code = null;
                })
                .catch(error => {
                this.forms.poentry.isSaving = false;
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
                    this.forms.poentry.isSaving = true;
                    this.resetFieldStates('poentry');
                    this.$http.put("api/poentry/"  + this.forms.poentry.fields.psoh_hash,
                        this.forms.poentry.fields,
                        {
                            headers: {
                            Authorization: "Bearer " + localStorage.getItem("token")
                            }
                        }
                        )
                        .then(response => {
                        this.forms.poentry.isSaving = false;
                        Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Successfully Updated.',
                                showConfirmButton: false,
                                timer: 2000
                                })
                        this.tables.poe.items = [];
                        this.forms.poentry.fields.required_date = ''
                        this.clearFields('poentry');
                        this.loadPurchaseOrder();

                })
                }
            } else {
                Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Please Add an Item',
                        showConfirmButton: false,
                        timer: 1500
                        })
            }
            }
    },
    removeProduct(index) {
            this.tables.poe.items.splice(index, 1);
    },
    addItem() {
            
            if (this.selectedRow.length > 0) {
        if (
                this.tables.poe.items.filter(
                    i => i.inmr_hash == this.selectedRow[0].inmr_hash
                ).length > 0
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
        this.tables.poe.items.push({
          inmr_hash: this.selectedRow[0].inmr_hash,
          item_no: this.selectedRow[0].item_no,
          description: this.selectedRow[0].description,
          uom_code: this.selectedRow[0].uom_code,
          available_qty: this.selectedRow[0].on_hand,
          price: this.selectedRow[0].price,
          remarks: this.selectedRow[0].remarks,
        //   product_quantity: 1,
        //   product_total: this.selectedRow[0].product_cost, 
          
        });
       
      }
    },
    async setDelete() {
        
        this.psoh_hash = this.forms.poentry.fields.psoh_hash;
        console.log(this.psoh_hash)
        Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
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
                            "api/poentry/delete/" + this.psoh_hash,
                            this.forms.poentry.fields,
                            {
                              headers: {
                                Authorization: "Bearer " + localStorage.getItem("token")
                              }
                            }
                          ).then(()=>{
                                    Swal.fire(
                                    'Cancelled!',
                                    'The Request Order has been Cancelled.',
                                    'success'
                                    )
                                    this.tables.poe.items = [];
                                    this.forms.poentry.fields.required_date = ''
                                    this.clearFields('poentry');
                                    this.loadPurchaseOrder();
                            }).catch(()=> {
                                    Swal.fire("Failed!", "There was something wronge.", "warning");
                            });
                         }
                    })
      },
      loadPurchaseOrder() {
        this.$http
        .get("api/poentry", {
            headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
            }
        })
        .then(response => {
            
            this.tables.inmr.items = response.data.inmr;
            this.options.psoh.items = response.data.psoh;
        })
        .catch(error => {
            console.log(error);
        });
      },
    },
    created () {
       this.loadPurchaseOrder()
    }
  }
</script>

