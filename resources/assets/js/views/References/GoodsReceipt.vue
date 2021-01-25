<template>
  <div>
    <!-- main container -->
    <notifications group="notification" />
    <div v-show="!showEntry" class="animated fadeIn">
      <!-- sec div -->
      <b-row>
        <!-- sec row -->
        <b-col sm="12">
          <b-card>
            <!-- sec card -->
                   <template #header>
              <div style="height:25px">
              <b-row>
               <b-col sm="4">
                 <h5 >
                   <span style="color: #FF8C00;">
                      Goods Receipt Input
                  </span>
                </h5>
              </b-col>

              <b-col sm="7">
                <span></span>
              </b-col>

              <b-col sm="1">
                <b-form-group style="float:right; margin-top:3px;">
                <b-button
                :disabled="forms.goodsreceipt.isSaving"
                variant="primary"
                @click="ongoodsreceiptsEntry"
              >
                <icon v-if="forms.goodsreceipt.isSaving" name="sync" spin></icon>
                <i class="fa fa-floppy-o"></i>
                Save
              </b-button>
              </b-form-group>
                <!-- <b-button variant="danger"  @click="showEntry=false"><i class="fa fa-ban"></i> Cancel</b-button> -->
              </b-col>
              </b-row>
              </div>
              </template>
            <div class="scroll">
              <b-col lg="12">
                <!-- modal body -->
                <b-form autocomplete="off">
                   <b-row class="mb-2">
                    <b-col lg=9></b-col>
                    <b-col lg=3>
                        <b-form-input v-model="filters.goodsreceiptitems.criteria" placeholder="Search"></b-form-input>
                    </b-col>
                  </b-row>
                  <b-row>
                     <b-col lg="2">
                     </b-col>
                    <b-col lg="4">
                      <!-- divider -->
                      <b-form-group>
                        <label for="ord_req_no">Select Request Order No.</label>
                        <select2
                        @input="getPoInfo"
                          ref="ord_req_no"
                          id="ord_req_no"
                          :allowClear="false"
                          :placeholder="'Select Request Order No.'"
                          v-model="forms.goodsreceipt.fields.ord_req_no"
                        >
                          <option
                            v-for="pur in options.psoh.items"
                            :key="pur.ord_req_no"
                            :value="pur.ord_req_no"
                          >{{pur.ord_req_no}}</option>
                        </select2>
                      </b-form-group>
                      </b-col>
                    <b-col lg="4">
                      <b-form-group>
                        <label>* Document Ref No.</label>
                        <b-form-input
                          id="doc_ref_no"
                          v-model="forms.goodsreceipt.fields.doc_ref_no"
                          type="number"
                          placeholder="Document Ref No."
                          ref="doc_ref_no"
                        ></b-form-input>
                      </b-form-group>
                    </b-col>
                    <b-col lg="2">
                     </b-col>
                  </b-row>
                </b-form>
              </b-col>
              <!-- modal body -->
            </div>
                 
            <div>
              <!-- row table -->
              <b-row>
                <b-col sm="12">
                  <b-table
                    responsive
                    fixed
                    striped
                    hover
                    small
                    bordered
                    show-empty
                    :filter="filters.goodsreceiptitems.criteria"
                    :fields="tables.goodsreceiptitems.fields"
                    style
                    :items.sync="tables.goodsreceiptitems.items"
                  
                  >
                  </b-table>
                </b-col>
              </b-row>
            </div>
            <!-- modal footer buttons -->
            <div v-show="forms.goodsreceipt.fields.ord_req_no != null">
              <!-- row table -->
              <b-row class="mb-2">
                    <b-col lg=4>
                        <b-button variant="primary" @click="showModalProducts = true, selectedRow=[]">
                            <i class="fa fa-plus-circle"></i> Add Product
                        </b-button>
                    </b-col>
                    <b-col lg=4></b-col>
                    <b-col lg=4>
                    </b-col>
                </b-row>
              <b-row>
                <b-col sm="12">
                  <b-table
                    responsive
                    fixed
                    striped
                    hover
                    small
                    bordered
                    show-empty
                    :filter="filters.inlo.criteria"
                    :fields="tables.inlo.fields"
                    :items.sync="tables.inlo.items"
                  
                  >
                    <!-- table -->
                    <template v-slot:cell(new_receipt_qty)="data">
                      <vue-autonumeric
                        ref="new_receipt_qty"
                        name="new_receipt_qty"
                        id="new_receipt_qty"
                        v-model="data.item.new_receipt_qty"
                        class="form-control text-right"
                        :options="{
                                                minimumValue: '0', 
                                                emptyInputBehavior:'0',}"
                      ></vue-autonumeric>
                    </template>

                    <template  v-slot:cell(act_cost)="data">
                      <vue-autonumeric
                        ref="act_cost"
                        name="act_cost"
                        id="act_cost"
                        v-model="data.item.act_cost"
                        class="form-control text-right"
                        :options="{
                                                minimumValue: '0', 
                                                emptyInputBehavior:'0',}"
                      ></vue-autonumeric>
                    </template>

                     <template  v-slot:cell(sale_price)="data">
                      <vue-autonumeric
                        ref="sale_price"
                        id="sale_price"
                        name="sale_price"
                        v-model="data.item.sale_price"
                        class="form-control text-right"
                        :options="{
                                                minimumValue: '0', 
                                                emptyInputBehavior:'0',}"
                      ></vue-autonumeric>
                    </template>
                    <template  v-slot:cell(expiry_date)="data">
                      <b-form-input
                      type="date"
                        ref="expiry_date"
                        id="expiry_date"
                        name="expiry_date"
                        v-model="data.item.expiry_date"
                        class="form-control text-right expiry_date"
                       
                      ></b-form-input>
                    </template>
                    <template v-slot:cell(action)="data">
                                <b-btn
                                    :size="'sm'"
                                    variant="danger"
                                    @click="removeProduct(data.index)"
                                >
                                    <i class="fa fa-trash"></i>
                                </b-btn>
                    </template>
                        </b-table>
                  <!-- table -->
                </b-col>
              </b-row>
            </div>
          </b-card>
          <!-- sec card -->
        </b-col>
      </b-row>
      <!-- sec row -->
      <b-modal
                size="lg"
                v-model="showModalProducts"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
                :scrollable="true"
                @shown="focusElement('receiving_id')"
              >
                <div slot="modal-title">
                  <!-- modal title -->
                  Product List
                </div>
                <!-- modal title -->

                <b-row class="mb-2">
                  <!-- row button and search input -->
                  <b-col sm="4"></b-col>

                  <b-col sm="4">
                    <span></span>
                  </b-col>

                  <b-col sm="4">
                     <b-form-input
                    v-model="filters.products.criteria"
                    type="text"
                    placeholder="Search"
                ></b-form-input>
                  </b-col>
                </b-row>
                <!-- row button and search input -->

                <b-col sm="12">
                  <b-table
                    :scrollable="true"
                    responsive
                    selectable
                    select-mode="single"
                    fixed
                    striped
                    hover
                    selected-variant="primary"
                    small
                    bordered
                    show-empty
                    :filter="filters.goodsreceiptitems.criteria"
                    :fields="tables.goodsreceiptitems.fields"
                    style
                    :items.sync="tables.goodsreceiptitems.items"
                    :current-page="paginations.goodsreceiptitems.currentPage"
                    :per-page="paginations.goodsreceiptitems.perPage"
                    @filtered="onFiltered($event, 'goodsreceiptitems')"
                    @row-selected="selectedRow = $event"
                  >
                  
                    <!-- table -->
                  </b-table>
                </b-col>
                <!-- modal body -->
                <div></div>

                <b-row>
                            <!-- Pagination -->
                            <b-col sm="12" class="my-1">
                                <b-pagination
                                size="sm"
                                align="right"
                                :total-rows="paginations.goodsreceiptitems.totalRows"
                                :per-page="paginations.goodsreceiptitems.perPage"
                                v-model="paginations.goodsreceiptitems.currentPage"
                                class="my-0"
                                />
                            </b-col>
                            </b-row>
                            <!-- Pagination -->

                <div slot="modal-footer">
                  <!-- modal footer buttons -->
                  <b-button
                    variant="primary"
                    @click="rowSelected"
                  >
                    <icon ></icon>
                    <i class="fa fa-check"></i>
                    Accept
                  </b-button>
                  <b-button variant="secondary" @click="showModalProducts=false">Close</b-button>
                </div>
                <!-- modal footer buttons -->
              </b-modal>
    </div>
    <!-- sec div -->
  </div>
  <!-- main container -->
</template>

<script>
export default {
  name: "goodsreceipts",
  data() {
    return {
      selectedRow: [],
      entryMode: "Add",
      showEntry: false, //if true show modal
      showModalProducts: false,
      showModalDelete: false,
      showNationality: false,
      showModalIdType: false,
      forms: {
        goodsreceipt: {
          isSaving: false,
          isDeleting: false,
          fields: {
            psoh_hash: null,
            total_amount: 0,
          }
        }
      },
      tables: {
        goodsreceiptitems: {
          fields: [
            {
              key: "item_no",
              label: "Product Code",
              thStyle: { width: "12%" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "description",
              label: "Description",
              thStyle: { width: "12%" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "uom_code",
              label: "UOM",
              thStyle: { width: "10%" },
              tdClass: "align-middle",
              sortable: true
            },
            // {
            //   key: "cost",
            //   label: "Cost",
            //   thClass: "text-right",
            //   tdClass: "align-middle text-right",
            //   sortable: true
            // },
            {
              key: "order_qty",
              label: "Order Qty.",
              thStyle: { width: "10%" },
              // thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: true
            },
            {
              key: "receipt_qty",
              label: "Prev. Receipt Qty.",
              thStyle: { width: "10%" },
              // thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: true
            },
            // {
            //   key: "new_receipt_qty",
            //   label: "Receipt Qty.",
            //   thStyle: { width: "10%" },
            //   thClass: "text-right",
            //   tdClass: "align-middle text-right",
            //   sortable: true
            // },
            // {
            //   key: "act_cost",                                              
            //   label: "Actual Cost",
            //   thStyle: { width: "10%" },
            //   thClass: "text-right",
            //   tdClass: "align-middle text-right",
            //   sortable: true
            // },
            //  {
            //   key: "total_amnt",                                              
            //   label: "Total Amount",
            //   thStyle: { width: "14%" },
            //   // thClass: "text-right",
            //   tdClass: "align-middle text-right",
            //   sortable: true,
            //   formatter: (value, key, item) => {
            //     item.total_amnt = item.new_receipt_qty * item.act_cost;
            //     return this.formatNumber(item.total_amnt);
            //     text: "align-right"
            //   }
            // },
            // {
            //   key: "sale_price",
            //   label: "Sale Price",
            //   thStyle: { width: "14%" },
            //   thClass: "text-right",
            //   tdClass: "align-middle text-right",
            //   sortable: true
            // },
          ],
          items: []
        },
        inlo: {
          fields: [
            {
              key: "item_no",
              label: "Product Code",
              thStyle: { width: "12%" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "description",
              label: "Description",
              thStyle: { width: "12%" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "uom_code",
              label: "UOM",
              thStyle: { width: "10%" },
              tdClass: "align-middle",
              sortable: true
            },
            // {
            //   key: "cost",
            //   label: "Cost",
            //   thClass: "text-right",
            //   tdClass: "align-middle text-right",
            //   sortable: true
            // },
            {
              key: "order_qty",
              label: "Order Qty.",
              thStyle: { width: "10%" },
              // thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: true
            },
            {
              key: "receipt_qty",
              label: "Prev. Receipt Qty.",
              thStyle: { width: "10%" },
              // thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: true
            },
            {
              key: "new_receipt_qty",
              label: "Receipt Qty.",
              thStyle: { width: "10%" },
              // thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: false
            },
            {
              key: "act_cost",                                              
              label: "Actual Cost",
              thStyle: { width: "10%" },
              // thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: false
            },
             {
              key: "total_amnt",                                              
              label: "Total Amount",
              thStyle: { width: "14%" },
              // thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: true,
              formatter: (value, key, item) => {
                item.total_amnt = item.new_receipt_qty * item.act_cost;
                return this.formatNumber(item.total_amnt);
                text: "align-right"
              }
            },
            {
              key: "sale_price",
              label: "Sale Price",
              thStyle: { width: "10%" },
              // thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: false
            },
            {
              key: "expiry_date",
              label: "Expiration Date",
              thStyle: { width: "15%" },
              // thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: true
            },
            {
              key: "action",
              label: "",
              thStyle: { width: "5%" },
              tdClass: "center",
              sortable: true
            },
          ],
          items: []
        },
        products: {
          fields: [
            {
              key: "item_no",
              label: "Product Code",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "description",
              label: "Description",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "uom_code",
              label: "Unit",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "product_cost",
              label: "Cost",
              tdClass: "align-middle",
              sortable: true
            }
          ],
          items: []
        }
      },
      filters: {
        goodsreceipts: {
          criteria: null
        },
         goodsreceiptitems: {
          criteria: null
        },
         inlo: {
          criteria: null
        },
        products: {
          criteria: null
        },
      },
      paginations: {
        goodsreceipts: {
                totalRows: 0,
                currentPage: 1,
                perPage: 10
            },
            products: {
                totalRows: 0,
                currentPage: 1,
                perPage: 10
            },
            goodsreceiptitems: {
                totalRows: 0,
                currentPage: 1,
                perPage: 10
            },
        },
      options: {
        psoh: {
          items: []
        }
      },
      psgh_hash: null,
      row: []
    };
  },
  methods: {
    valiDATE:function(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 

    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("expiry_date").setAttribute("min", today);
    },
    getPoInfo: function(value,data)  {
      if (data.length > 0) {
        // this.entryMode = 'Edit'
        var po= this.options.psoh.items[data[0].element.index]
         this.forms.goodsreceipt.fields.psoh_hash = po.psoh_hash
        //  this.forms.goodsreceipt.fields.purchase_order_datetime = po.purchase_order_datetime
         this.$http.get("api/getpoitems/"+po.psoh_hash,{
             headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
          }).then(response => {
            this.tables.goodsreceiptitems.items = response.data
          })
          .catch(err=>{
            console.log(err)
          })
      }
    },
    checkQty: function(value,data)  {
      if (this.data.item.new_receipt_qty != null) {
        console.log(this.data.item.new_receipt_qty)
        // var qty= this.options.psoh.items[data[0].element.index]
        //  this.forms.goodsreceipt.fields.psoh_hash = po.psoh_hash
        //  this.$http.get("api/checkQty/"+this.data.item.new_receipt_qty,{
        //      headers: {
        //             Authorization: 'Bearer ' + localStorage.getItem('token')
        //         }
        //   }).then(response => {
        //     // this.tables.goodsreceiptitems.items = response.data
        //   })
        //   .catch(err=>{
        //     console.log(err)
        //   })
      }
    },
    ongoodsreceiptsEntry() {
      this.forms.goodsreceipt.fields.items = this.tables.inlo.items
      if(this.forms.goodsreceipt.fields.ord_req_no == null) {
        Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Please Select',
                  text:  'Request Order No.',
                  showConfirmButton: false,
                  timer: 2000
                  })
      } else if (this.tables.inlo.items <= [0]) {
          Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Please Add Product',
                  showConfirmButton: false,
                  timer: 1500
                  })
      }else{
          if (this.entryMode == "Add") {
              // this.createEntity("goodsreceipt", false, "goodsreceipts");
              this.forms.goodsreceipt.isSaving = true;
              this.resetFieldStates('goodsreceipt');
              this.$http
                .post("api/goodsreceipt", this.forms.goodsreceipt.fields, {
                  headers: {
                    Authorization: "Bearer " + localStorage.getItem("token")
                  }
                })
                .then(response => {
                  this.forms.goodsreceipt.isSaving = false;
                  this.clearFields('goodsreceipt');
                  Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Successfully Created.',
                  showConfirmButton: false,
                  timer: 2000
                  })
                  this.loadgoodsreceipt()
                  this.tables.goodsreceiptitems.items = []
                  this.tables.inlo.items = []
                
                })
                .catch(error => {
                  this.forms.goodsreceipt.isSaving = false;
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
                    a++;
                  }
                });
            } else {
              this.updateEntity(
                "goodsreceipt",
                "psgh_hash",
                false,
                this.row
              );
            }
      }
    },
    ongoodsreceiptsDelete() {
      this.deleteEntity(
        "goodsreceipt",
        this.psgh_hash,
        true,
        "goodsreceipts",
        "psgh_hash"
      );
    },
    onProductlistDelete() {
      this.deleteEntity(
        "productlist",
        this.inmr_hash,
        true,
        "productlist",
        "inmr_hash"
      );
    },
    async setDelete(data) {
      if (
        (await this.checkIfUsed(
          "goodsreceipt",
          data.item.psgh_hash
        )) == true
      ) {
        this.$notify({
          type: "error",
          group: "notification",
          title: "Error!",
          text:
            "Unable to delete, this record is being used by other transactions."
        });
        return;
      }
      this.psgh_hash = data.item.psgh_hash;
      this.showModalDelete = true;
    },
    setUpdate(data) {
      this.row = data.item;
      this.$http.get('api/goodsreceipt/'+ data.item.psgh_hash, {
          headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
          }
      }).then(response => {
          this.forms.goodsreceipt.fields = response.data.goodsreceipts
          this.tables.goodsreceiptitems.items = response.data.goodsreceiptitems
          this.showEntry = true
          this.entryMode = "Edit"
      }).catch(err => {
          console.log(err)
      })
    },
    rowSelected() {
      if(this.selectedRow.length > 0){
        // if(this.tables.goodsreceiptitems.items.filter(i => i.inmr_hash == this.selectedRow[0].inmr_hash).length > 0){
        //    this.$notify({
        //             type: "error",
        //             group: "notification",
        //             title: "Error!",
        //             text: "Product is already added."
        //         })
        //         return
        //     }
           this.tables.inlo.items.push({
                inmr_hash: this.selectedRow[0].inmr_hash,
                psol_hash: this.selectedRow[0].psol_hash,
                item_no: this.selectedRow[0].item_no,
                description: this.selectedRow[0].description,
                uom_code: this.selectedRow[0].uom_code,
                order_qty: this.selectedRow[0].order_qty,
                receipt_qty: this.selectedRow[0].receipt_qty,
                new_receipt_qty: this.selectedRow[0].new_receipt_qty,
                act_cost: this.selectedRow[0].act_cost,
                sale_price: this.selectedRow[0].sale_price,
                expiry_date: this.selectedRow[0].expiry_date,
           })
        }
  },
  removeProduct(index){
        this.tables.inlo.items.splice(index, 1)
    },
    loadgoodsreceipt() {
    this.$http.get('api/goodsreceipts', {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
    }).then(response => {
        this.options.psoh.items = response.data.psoh
    }).catch(error => {
        console.log(error)
    })
  },
  },
  
  created() {
      this.loadgoodsreceipt();
  },
  computed: {
    getTotalItems() {
      this.forms.goodsreceipt.fields.total_amount = 0;
      this.tables.goodsreceiptitems.items.forEach(item => {
        //console.log(item);
        this.forms.goodsreceipt.fields.total_amount +=
          Number(item.new_receipt_qty) * Number(item.act_cost);
      });
      return this.forms.goodsreceipt.fields.total_amount;
    }
  },
  
  mounted(){   
  
  }

};
</script>

