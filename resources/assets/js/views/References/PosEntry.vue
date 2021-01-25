<style>
.b {
  border: 1px solid black;
  background-color: lightgray;
  color: black;
  font-size: 11px;
  cursor: pointer;
  width: 100px;
}
.success {
  border-color: gray;
  color: black;
}
.success:hover {
  background-color: rgb(157, 209, 240);
  color: black;
}
.i {
  size: 10px;
}
.imgsize {
  width: 35px;
  height: 23px;
}
.barr:focus {
  background-color: #f8a04d;
}
.input:focus {
  background-color: #e8e376;
}
.hr {
  border: 0.5px solid black;
  margin-top: -2%;
}
.hr-a {
  border: 0.5px solid #f8a04d;
  margin-top: -2%;
}
.types {
  margin-left: 5%;
  margin-top: -2%;
}
.typeboxx:focus {
  background-color: #f8a04d;
}
.typebox {
  margin-top: -2%;
  margin-bottom: 3%;
  text-align: right;
}
.typeboxx {
  height:49px; 
  font-size:49px; 
  width:97.5%;
  padding-right: 10px; 
  margin-left: 1%;
  margin-top: -2%;
  margin-bottom: 3%;
  text-align: right;
}
.seldisc {
  width:97.5%;
}
.paybtn {
  background-color: #f8a04d;
  border-radius: 5px;
  height: 70.5px;
  width: 121px;
  /* margin-left: 1%;
  margin-top: 1%; */
  text-align: center;
  color: black;
  font-size: 220%;
  text-shadow: 0.5px 0.5px black;
}
.paybtn:hover {
  background-color: rgb(157, 209, 240);
}
.btnqty {
  background-color: #f8a04d;
  border-radius: 5px;
  height: 70.5px;
  width: 31%;
  margin-left: 1%;
  margin-top: 1%;
  text-align: center;
  color: black;
  /* font-family: "Times New Roman", Times, serif; */
  font-size: 14px;
  text-shadow: 0.5px 0.5px black;
  /* font-weight: bold; */
}
.btnqty:hover {
  background-color: rgb(157, 209, 240);
}
.enter {
  background-color: aqua;
  border-radius: 0px;
  height: 90px;
  width: 97%;
  margin-left: 3%;
  margin-top: 1%;
  padding: 0%;
  font-family: "Times New Roman", Times, serif;
  font-size: 240%;
  color: red;
  text-shadow: 0.5px 0.5px black;
  font-weight: bold;
}
.cardmodal {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  transition: 0.3s;
  border-radius: 0px;
  margin-left: -4%;
  margin-top: 0.5%;
  margin-bottom: 0%;
  height: 43%;
  width: 108%;
}
.titlelabel {
  font-size: 11px;
  margin-left: 3%;
}
.iconcard {
  background-color: lightgrey;
  margin-top: -1%;
  width: 99%;
  margin-left: 0.1%;
  height: 43px;
  grid-column: 2/4;
}
.checkbox {
  margin-top: 2%;
  margin-left: 86%;
}
.btnplus {
  border: none;
  padding: initial;
  margin-top: -2%;
  background: none;
  margin-left: 3%;
  width: 6%;
  height: 5%;
  transform: rotate(360deg);
}
.btnplus:active::after {
  border: none;
  background: none;
  transform: rotate(360deg);
}
.aa {
  height: 100%;
  width: 100%;
  overflow: hidden;
  /* position: fixed;
     */
}
.a {
  background-color: white;
  padding: 10px;
  border-right: 1px solid lightgray;
  height: 100%;
}
.btngroup {
  width: 1000%;
}
.f{
  height: 100%;
}
.ba {
  background-color: white;
  height: 100%;
  width: 100%;
}
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  margin: 0;
}
</style>

<template>
  <div class="aa">
    <!-- <div> -->
    <notifications group="notification" />
    <div>
        <b-row no-gutters>
        <b-col lg="12">
          <div class="a">
               <br>
            <b-row no-gutters>
              <b-col lg="9">
                  <label style="font-size: 20px; color: #FF8C00; padding-left:10px;">POS Entry</label>
              </b-col>
              <b-col lg="3">
                  <b-form-group style="float:right; margin-top:3px;">
                    <b-button variant="danger" @click="removeProduct"><i class="fa fa-ban"></i> Cancel</b-button>
                    <!-- <b-button variant="outline-primary"><i class="fa fa-eraser"></i> Clear</b-button> -->
                    <b-button variant="primary" @click="showModalPayment = true"><i class="fa fa-check"></i> Proceed</b-button>
                    </b-form-group>
              </b-col>
            </b-row>
            <br>&emsp;
            <hr class="hr-a">
              <b-row>
                <b-col lg="6">
                  &emsp;<span>Press:</span>
                  &emsp;<span>Ctrl + F1 - Scan Barcode</span>
                  &emsp;<span>Ctrl + F2 - Search Product</span>
                  &emsp;<span>Ctrl + F3 - Edit Quantity</span>
                </b-col>
              </b-row>
            </div>
        </b-col>
        </b-row>
      <b-row no-gutters>
        <b-col lg="9">
          <div class="a">
            <b-row no-gutters>
              <b-col sm="6">
                <b-form-input
                placeholder="SCAN BARCODE HERE"
                @input="barcodeCheck"
                v-model="forms.pos.fields.barcode"
                  class="barr"
                  style=" font-weight:bold; font-size: 15px; "
                  ref="barcode"
                  name="barcode"
                  id="barcode"
                  type="text"
                ><option
                  v-for="pur in tables.products.items"
                  :key="pur.barcode"
                  :value="pur.barcode"
                ></option>
                </b-form-input>
              </b-col>
              <b-col sm="2">
                 <b-btn :size="'sm'" variant="primary" @click="showModalProducts = true">
                      <span style="font-size: 16px; "><i class="fa fa-search"></i></span>
                    </b-btn>
              </b-col>
              <b-col sm="2">
                  <!-- <b-button variant="primary"><i class="fa fa-edit"></i> </b-button>
                  <b-button variant="danger"><i class="fa fa-trash"></i> </b-button> -->
              </b-col>
               <b-col sm="2">
                <label style="font-weight:bold; font-size: 15px;">Total Quantity:</label>
                <label style="font-weight:bold; font-size: 15px;">0</label>
              </b-col>
            </b-row>
            <br>
            <b-row>
              <!-- row table -->
              <b-col sm="12">
                <b-table
                  selectable
                  select-mode="single"
                  responsive
                  fixed
                  striped
                  hover
                  small
                  bordered
                  show-empty
                  selected-variant="primary"
                  :filter="filters.posentry.criteria"
                  :fields="tables.posentry.fields"
                  style=" height:100%; min-height:515px;"
                  :items.sync="tables.posentry.items"
                  @filtered="onFiltered($event, 'products')"
                  @row-selected="selectedRow = $event"
                >

                <template v-slot:cell(action)="data">
                                <b-btn
                                    :size="'sm'"
                                    variant="danger"
                                    @click="removeProduct(data.index)"
                                >
                                    <i class="fa fa-minus"></i>
                                </b-btn>
                    </template>
                  <!-- table -->
                </b-table>
                <!-- table -->
              </b-col>
            </b-row>
            <!-- row table -->
            <br>
            <br>
          </div>
        </b-col>


        <b-col lg="3">
          <div class="ba">
            <div>
            <b-row no-gutters>
          <b-col sm="12">
          <table class="w-100">
               <tr bgcolor="#fff">
              <td valign="top">
                <!-- <img src="images/pos/jdev-logo.png" height="30%" width="100%"/> -->
                <img height="auto" width="100%" src="/images/1.jpg" alt="img">
              </td>
            </tr>
            <tr>
              <td valign="top">
                <span style="font-size: 15px; color: black">Gross Total:</span>
                <span
                  ref="gross_amount"
                  id="gross_amount"
                  style="font-size: 15px; color:black"
                  class="float-right"
                >{{formatNumber(this.getTotalItems)}}</span>
                <br><br>
                <span style="font-size: 15px; color: black">Total Discount:</span>
                <span style="font-size: 15px; color: black" class="float-right">0.00</span>
              </td>
            </tr>
            <br>
            <tr bgcolor="#FF8C00">
              <td valign="top">
                <!-- <span style="font-size: 15px; color: white">Gross Total:</span> -->
                <span
                  ref="gross_amount"
                  id="gross_amount"
                  style="font-size: 50px; color:white"
                  class="float-right"
                >{{formatNumber(this.getTotalItems)}}</span>
              </td>
            </tr>
            <br>
             <!-- <hr class="hr-a"> -->
            <tr>
              <td valign="top">
                <span style="font-size: 15px; color: black">Mode of Payment:</span>
                <span style="font-size: 15px; color: black">Cash</span>
                <br><br><br><br><br><br>
              </td>
            </tr>
            <tr>
              <td valign="top">
                <b-row no-gutters style="padding-top: 90px">
                    <b-col sm="5">
                        <span style="font-size: 12px; color: black">Cashier:</span>
                        <span style="font-size: 12px; color: black">User</span>
                    </b-col>
                    <b-col sm="7">
                        <span style="font-size: 12px; color: black">Date Time:</span>
                        <span style="font-size: 12px; color: black">{{ datenow }}&nbsp;{{ timenow }}</span>
                    </b-col>
                </b-row>
              </td>
            </tr>
          </table>
          </b-col>
          </b-row>
            </div>

         </div>
        </b-col>
      </b-row>
    </div>

    <!-- modal div -->
    <div>
      <!-- modal div -->
      <b-modal
        size="lg"
        v-model="showModalProducts"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        :scrollable="true"
        @shown="focusElement('inmr_hash')"
      >
        <div slot="modal-title">
          <!-- modal title -->
          Products
        </div>
        <!-- modal title -->

        <b-row class="mb-2">
          <!-- row button and search input -->
          <b-col sm="4"></b-col>

          <b-col sm="4">
            <span></span>
          </b-col>

          <b-col sm="4">
            <b-form-input v-model="filters.products.criteria" type="text" placeholder="Search"></b-form-input>
          </b-col>
        </b-row>
        <!-- row button and search input -->

        <b-table
          selectable
          select-mode="single"
          responsive
          fixed
          striped
          hover
          small
          bordered
          show-empty
          selected-variant="primary"
          :filter="filters.products.criteria"
          :fields="tables.products.fields"
          :per-page="paginations.products.perPage"
          :current-page="paginations.products.currentPage"
          :items.sync="tables.products.items"
          @filtered="onFiltered($event, 'products')"
          @row-selected="selectedRow = $event"
        >
          <!-- table -->
        </b-table>
        <b-row>
          <b-col sm="12" class="my-1">
            <b-pagination
              size="sm"
              align="right"
              v-model="paginations.products.currentPage"
              :per-page="paginations.products.perPage"
              :total-rows="paginations.products.totalRows"
              class="my-0"
            ></b-pagination>
          </b-col>
        </b-row>
        <!-- modal body -->

        <div slot="modal-footer">
          <!-- modal footer buttons -->
          <b-button variant="primary" @click="rowSelected">
            <icon v-if="forms.pos.isSaving" name="sync" spin></icon>
            <i class="fa fa-check"></i>
            Accept
          </b-button>
          <b-button variant="secondary" @click="showModalProducts=false">Close</b-button>
        </div>
        <!-- modal footer buttons -->
      </b-modal>
    </div>

    <!-- modal div -->
    <div>
      <!-- modal div -->
      <b-modal
        size="sm"
        id="modal-center"
        centered
        title="BootstrapVue"
        v-model="showModalQuantity"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('input_quantity')"
      >
        <div slot="modal-title">Product Quantity</div>
        <div>
          <b-col lg="12">
            <b-row>
              <b-col lg="12">
                <br>
                <h4>
                  <center>{{forms.quantity.fields.description}}</center>
                </h4>
                <hr class="hr-a">
                <br>
                <b-row class="my-1">
                  <b-col sm="4">
                    <label>Product Code:</label>
                  </b-col>

                  <b-col sm="8">
                    <b-form-input
                      readonly
                      style="text-align:right"
                      ref="item_no"
                      id="item_no"
                      v-model="forms.quantity.fields.item_no"
                    ></b-form-input>
                  </b-col>
                </b-row>

                <!-- <b-row class="my-1">
                  <b-col sm="4">
                    <label>Prev.Quantity:</label>
                  </b-col>
                  <b-col sm="8">
                    <b-form-input
                      style="text-align:right"
                      readonly
                      id="product_quantity"
                      v-model="forms.quantity.fields.prev_quantity"
                    ></b-form-input>
                  </b-col>
                </b-row> -->

                <b-row class="my-1">
                  <b-col sm="4">
                    <label>Product Cost:</label>
                  </b-col>
                  <b-col sm="8">
                    <b-form-input
                      style="text-align:right"
                      readonly
                      ref="price"
                      id="price"
                      v-model="forms.quantity.fields.price"
                    ></b-form-input>
                  </b-col>
                </b-row>
                <b-row class="my-1">
                  <b-col sm="4">
                    <label>Discount:</label>
                  </b-col>
                  <b-col sm="8">
                    <!-- <vue-autonumeric
                      style="text-align:right"
                      ref="disc_amount"
                      id="disc_amount"
                      v-model="forms.quantity.fields.disc_amount"
                      :options="{minimumValue: '0', maximumValue: '999999', emptyInputBehavior:'0',}"
                    ></vue-autonumeric> -->
                    <select2
                          ref="disc_amount"
                          :allowClear="false"
                          :placeholder="'Select Discount'"
                          v-model="forms.pos.fields.disc_code_1"
                        >
                          <option
                            v-for="ct in options.special.items"
                            :key="ct.disc_rate"
                            :value="ct.disc_rate"
                          >{{ct.disc_code}}</option>
                        </select2>
                  </b-col>
                </b-row>
                <br>
                <h4>
                  <center>Please input quantity:</center>
                </h4>
                <br>
                <b-form-input
                  type="number"
                  @keypress.enter="acceptQuantity"
                  class="inputqty"
                  ref="input_quantity"
                  id="product_quantity"
                  v-model="forms.quantity.fields.product_quantity"
                  style="text-align:center; height:49px; font-size:49px; width:97.5%; margin-left: 1%;"
                  :options="{
                          minimumValue: '1',
                          maximumValue: '999999',
                          emptyInputBehavior:'1',
                          decimalPlaces: 0}"
                ></b-form-input>
                <b-button class="btnqty" @click="forms.quantity.fields.product_quantity = 0, forms.pos.fields.disc_code_1 = ''">CLEAR</b-button>
                  <b-button class="btnqty" @click="showModalQuantity=false">CANCEL</b-button>
                  <b-button class="btnqty" @click="acceptQuantity" >ENTER</b-button>
              </b-col>

              <!-- <b-col lg="6">
                <div>
                  <b-button style="margin-left: 2%;" class="btnqty" @click="addPayment1(7)">7</b-button>
                  <b-button class="btnqty" @click="addPayment1(8)">8</b-button>
                  <b-button class="btnqty" @click="addPayment1(9)">9</b-button>

                  <b-button style="margin-left: 2%;" class="btnqty" @click="addPayment1(4)">4</b-button>
                  <b-button class="btnqty" @click="addPayment1(5)">5</b-button>
                  <b-button class="btnqty" @click="addPayment1(6)">6</b-button>

                  <b-button style="margin-left: 2%;" class="btnqty" @click="addPayment1(1)">1</b-button>
                  <b-button class="btnqty" @click="addPayment1(2)">2</b-button>
                  <b-button class="btnqty" @click="addPayment1(3)">3</b-button>

                  <b-button style="margin-left: 2%;" class="btnqty" @click="addPayment1(0)">0</b-button>
                  <b-button class="btnqty" @click="forms.quantity.fields.product_quantity = 0">CLEAR</b-button>
                  <b-button class="btnqty" @click="showModalQuantity=false">CANCEL</b-button>

                  <b-button class="enter" @click="acceptQuantity">ENTER</b-button>
                </div>
              </b-col> -->
            </b-row>
          </b-col>
        </div>

        <div slot="modal-footer"></div>
      </b-modal>

      <b-modal v-model="showModalDelete" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
        <div slot="modal-title">Delete</div>
        <b-col lg="12">Are you sure you want to cancel this transaction?</b-col>
        <div slot="modal-footer">
          <b-button
            :disabled="forms.pos.isSaving"
            variant="primary"
            value="Refresh Page"
            onClick="window.location.reload();"
          >
            <icon v-if="forms.pos.isSaving" name="sync" spin></icon>
            <i class="fa fa-check"></i>
            OK
          </b-button>
          <b-button variant="secondary" @click="showModalDelete=false">Close</b-button>
        </div>
      </b-modal>

      <b-modal v-model="showModalVoid" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
        <div slot="modal-title">Delete</div>
        <b-col lg="12">Are you sure you want to void this item?</b-col>
        <div slot="modal-footer">
          <b-button :disabled="forms.pos.isSaving" variant="primary" @click="removeProduct=true">
            <icon v-if="forms.pos.isSaving" name="sync" spin></icon>
            <i class="fa fa-check"></i>
            OK
          </b-button>
          <b-button variant="secondary" @click="showModalVoid=false">Close</b-button>
        </div>
      </b-modal>

      <b-modal
        size="lg"
        id="modal-center"
        centered
        v-model="showModalPayment"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('cash_rendered')"
      >
        <div slot="modal-title" class="titlemodal">
          Payment
        </div>

        <div>

          <b-col lg="12">
            <b-row>
              <b-col lg="6">
                <div class="">
                  <div c lass="card-body">
                    <b-row>
                       <b-form-group>
                      <label style="font-size: 14px">Cash</label>

                      <vue-autonumeric
                        v-model="forms.pos.fields.cash_rendered"
                        ref="cash_rendered"
                        id="cash_rendered"
                        formatNumber="true"
                        class="typeboxx"
                       
                        :options="{
                                        minimumValue: '0', 
                                        maximumValue: '999999',
                                        emptyInputBehavior:'0',}"
                      ></vue-autonumeric>
                       </b-form-group>
                       <b-form-group>
                        <label style="font-size: 14px">Select Discount</label>
                        <select2
                          ref="disc_amount_header"
                          :allowClear="false"
                          :placeholder="'Select Discount'"
                          v-model="forms.pos.fields.disc_code"
                        >
                          <option
                            v-for="ct in options.psds.items"
                            :key="ct.disc_rate"
                            :value="ct.disc_rate"
                          >{{ct.disc_code}}</option>
                        </select2>
                      </b-form-group>
                      <br><br>
                      <br><br>
                      <br><br>
                      <br><br>
                      <br><br>
                      <br><br>
                      <br><br>
                      <br><br>
                        <table>
                      <b-button
                        class="paybtn"
                        @click="forms.pos.fields.cash_rendered = 0, forms.pos.fields.disc_code = ''"
                      >CLEAR</b-button>
                      <b-button class="paybtn" @click="showModalPayment=false">CANCEL</b-button>

                      <b-button class="paybtn" @click="onPosEntry">ENTER</b-button>
                    </table>
                    </b-row>
                  </div>
                </div>
                <br />
                <div>
                  <b-row>
                    
                  </b-row>
                </div>
              </b-col>

              <b-col lg="6">
                <div>
                  <b-row>
                    <table class="w-100">
                      <tr border="#111"  bgcolor="#FF8C00">
                        <td valign="top">
                          <span style="font-size: 18px; color: white">GROSS TOTAL:</span>
                          <span
                            ref="gross_amount"
                            id="gross_amount"
                            style="font-size: 54px; color:white"
                            class="float-right"
                          >{{formatNumber(this.getTotalItems)}}</span>
                        </td>
                      </tr>
                      <br />
                      <tr border="#111" bgcolor="#FF8C00">
                        <td valign="top">
                          <span style="font-size: 18px; color: white">DISCOUNT:</span>
                          <span
                            ref="disc_amount_header"
                            id="disc_amount_header"
                            style="font-size: 54px; color:white"
                            class="float-right"
                          >{{formatNumber(this.forms.pos.fields.disc_code * getTotalItems)}}</span>
                        </td>
                      </tr>
                      <br>
                      <tr border="#111" bgcolor="#FF8C00">
                        <td valign="top">
                          <span style="font-size: 18px; color: white">TOTAL AMOUNT:</span>
                          <span
                            ref="tot_taxable_amount"
                            id="tot_taxable_amount"
                            style="font-size: 54px; color:white"
                            class="float-right"
                          >
                          {{formatNumber(forms.pos.fields.gross_amount - (forms.pos.fields.gross_amount * forms.pos.fields.disc_code))}}
                          </span>
                        </td>
                      </tr>
                      <br>
                      <!-- <th bgcolor="#fff"></th> -->
                      <tr bgcolor="#FF8C00">
                        <td valign="top">
                          <span style="font-size: 18px; color: white">TENDERED:</span>
                          <span
                            ref="cash"
                            id="cash_rendered"
                            style="font-size: 54px; color:white"
                            class="float-right"
                          >{{formatNumber(this.forms.pos.fields.cash_rendered)}}</span>
                        </td>
                      </tr>
                      <br />
                      <tr bgcolor="#FF8C00">
                        <td valign="top">
                          <span style="font-size: 18px; color: white">CHANGE:</span>
                          <span
                            id="total_change"
                            style="font-size: 54px; color:white"
                            class="float-right"
                          >
                          <!-- {{formatNumber(this.getTotalChange)}} -->
                          {{formatNumber(forms.pos.fields.cash_rendered - (forms.pos.fields.gross_amount - (forms.pos.fields.gross_amount * forms.pos.fields.disc_code)))}}
                          </span>
                        </td>
                      </tr>
                    </table>
                      
                  </b-row>
                </div>
              </b-col>
            </b-row>
          </b-col>
        </div>
        <div slot="modal-footer"></div>
      </b-modal>

     
     

      <div>
        <!-- modal div -->
        <b-modal
          v-model="showModalGCPayment"
          :noCloseOnEsc="true"
          :noCloseOnBackdrop="true"
          @shown="focusElement('card_type')"
        >
          <div slot="modal-title">
            <!-- modal title -->
            Add/Edit GC Payment
            <br />
            <small>Add or Edit GC Payment on invoice</small>
          </div>
          <!-- modal title -->

          <b-col lg="12">
            <!-- modal body -->
            <b-form>
              <b-form-group>
                <label for="gc_type_id">* GC Type</label>
                <select2
                  ref="gc_type_id"
                  :allowClear="false"
                  :placeholder="'Select GC Type'"
                  v-model="forms.payment.fields.gc_type_id"
                >
                  <option
                    v-for="gct in options.gctypes.items"
                    :key="gct.gc_type_id"
                    :value="gct.gc_type_id"
                  >{{gct.gc_type_name}}</option>
                </select2>
              </b-form-group>
              <b-form-group>
                <label>* GC No.:</label>
                <b-form-input
                  ref="card_check_gc_no"
                  id="card_check_gc_no"
                  v-model="forms.payment.fields.card_check_gc_no"
                  type="text"
                  placeholder="GC no."
                ></b-form-input>
              </b-form-group>
              <b-form-group>
                <label>* Amount</label>
                <vue-autonumeric
                  ref="payment_amount"
                  id="payment_amount"
                  v-model="forms.payment.fields.payment_amount"
                  type="text"
                  class="form-control text-right"
                  :options="[{ minimumValue: '0' , maximumValue: '200', emptyInputBehavior:'0', decimalCharacter: '.'}]"
                >></vue-autonumeric>
              </b-form-group>
            </b-form>
          </b-col>
          <!-- modal body -->
        </b-modal>
      </div>
      <!-- modal div -->
    </div>
  </div>
</template>

<script>
export default {
  name: "posentry",
  data() {
    return {
      entryMode: "Add",
      selectedRow: [],
      showModalEntry: false, //if true show modal
      showModalProducts: false,
      showModalCheckPayment: false,
      showModalCardPayment: false,
      showModalGCPayment: false,
      timenow: null,
      showModalQuantity: false,
      showModalDiscount: false,
      showModalDelete: false,
      showModalVoid: false,
      showModalPayment: false,
      showNationality: false,
      showModalIdType: false,
      forms: {
        quantity: {
          fields: {
            inlo_hash: null,
            item_no: null,
            product_quantity: null,
            prev_quantity: null,
            disc_amount: null,
            price: null,
            description: null,
            barcode: null
          }
        },
        pos: {
          isSaving: false,
          isDeleting: false,
          fields: {
            inlo_hash: null,
            item: null,
            description: null,
            item_no: null,
            uom_code: null,
            price: null,
            product_quantity: null,
            disc_amount: null,
            barcode: null,
            gross_amount: null,
            cash_rendered: null,
            disc_code: null,
            disc_amount_header: null,
            tot_taxable_amount: null
          }
        },
        payment: {
          fields: {
            gc_type_id: null,
            charge_to: null,
            gross_amount: null,
            cash_rendered: null,
            total_change: null,
            check_type_id: null
          }
        },
        totchange: {
          fields: {
            gross_amount: null,
            cash_rendered: null,
            total_change: null
          }
        }
      },
      tables: {
        posentry: {
          fields: [
            {
              key: "product_quantity",
              label: "Qty",

              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "item_no",
              label: "Product Code",

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
              label: "UOM",

              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "price",
              label: "Sales Price",

              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "disc_amount",
              label: "Discount",

              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "extended",
              label: "Total Amount",
              tdClass: "align-middle",
              sortable: true,
              formatter: (value, key, item) => {
                item.extended = (item.price * item.product_quantity) - item.disc_amount;
                return this.formatNumber(item.extended);
              }
            },
            {
              key: "remarks",
              label: "Remarks",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "action",
              label: "",
              thStyle: { width: "80px" },
              tdClass: "text-center"
            }
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
              key: "expiry_date",
              label: "Expiry Date",
              tdClass: "align-middle",
              sortable: true
            }
          ],
          items: []
        }
      },
      filters: {
        posentry: {
          criteria: null
        },
        products: {
          criteria: null
        }
      },
      paginations: {
        posentry: {
          totalRows: 0,
          currentPage: 1,
          perPage: 10
        },
        products: {
          totalRows: 0,
          currentPage: 1,
          perPage: 10
        }
      },
      options: {
        psds: {
          items: []
        },
        special: {
          items: []
        },
        gctypes: {
          items: []
        }
      },
      pssh_hash: null,
      row: []
    };
  },
  methods: {
    onPosEntry() {
      if(this.tables.posentry.items.length > 0) {
        this.forms.pos.fields.items = this.tables.posentry.items
        if (this.entryMode == "Add") {
          this.createEntity("pos", false, "posentry");
          
        } else {
          this.updateEntity(
            "pos",
            "pssh_hash",
            false,
            this.row
          );
        }
      }
      else {
        this.$notify({
          type: 'error',
          group: 'notification',
          title: 'Error!',
          text: 'Please Add an Item'
        })
      }
    },
    onPosDelete() {
      this.deleteEntity("pos", this.pssh_hash, true, "posentry", "pssh_hash");
    },
    async setDelete(data) {
      if ((await this.checkIfUsed("pos", data.item.pssh_hash)) == true) {
        this.$notify({
          type: "error",
          group: "notification",
          title: "Error!",
          text:
            "Unable to delete, this record is being used by other transactions."
        });
        return;
      }
      this.pssh_hash = data.item.pssh_hash;
      this.showModalDelete = true;
    },
    //   setUpdate(data) {
    //     this.row = data.item;
    //     this.resetFieldStates("pos");
    //     this.fillEntityForm("pos", data.item.pssh_hash);
    //     this.showModalEntry = true;
    //     this.entryMode = "Edit";
    //   }
    // },
    rowSelected() {
      if (this.selectedRow.length == 0) {
        console.log("notify");
        this.$notify({
          type: "error",
          group: "notification",
          title: "Error!",
          text: "Please select a product."
        });
        return;
      }
      this.forms.quantity.fields.inlo_hash = this.selectedRow[0].inlo_hash;
      this.forms.quantity.fields.uom_code = this.selectedRow[0].uom_code;
      this.forms.quantity.fields.inmr_hash = this.selectedRow[0].inmr_hash;
      this.forms.quantity.fields.item_no = this.selectedRow[0].item_no;
      this.forms.quantity.fields.description = this.selectedRow[0].description;
      this.forms.quantity.fields.price = this.selectedRow[0].price;
      (this.forms.quantity.fields.prev_quantity = 1),
        (this.forms.quantity.fields.product_quantity = 1),
        (this.forms.quantity.fields.product_total = this.selectedRow[0].price);
      this.showModalQuantity = true;
    },
    barcodeCheck: function(value,data)  {
      if (this.forms.pos.fields.barcode != null) {
         this.$http.get("api/getBarcode/"+this.forms.pos.fields.barcode,{
             headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
                
          }).then(response => {
            if (this.forms.pos.fields.barcode != null) {
            // this.forms.quantity.fields.uom_code = response.data[0].uom_code;
            // this.forms.quantity.fields.inmr_hash = response.data[0].inmr_hash;
            // this.forms.quantity.fields.item_no = response.data[0].item_no;
            // this.forms.quantity.fields.description = response.data[0].description;
            // this.forms.quantity.fields.price = response.data[0].price;
            // (this.forms.quantity.fields.product_quantity = 1),
            // (this.forms.quantity.fields.product_total = response.data[0].price);
            // this.showModalQuantity = true;
            
            this.tables.products.items = response.data
            this.showModalProducts = true;
            
            }
            
          })
          .catch(err=>{
            console.log(err)
          })
      }
    },
    acceptQuantity() {
      if(this.forms.pos.fields.disc_code_1 != null){
      this.tables.posentry.items.push({
        inmr_hash: this.forms.quantity.fields.inmr_hash,
        inlo_hash: this.forms.quantity.fields.inlo_hash,
        item_no: this.forms.quantity.fields.item_no,
        description: this.forms.quantity.fields.description,
        price: this.forms.quantity.fields.price,
        product_quantity: this.forms.quantity.fields.product_quantity,
        disc_amount:
         (Number(this.forms.quantity.fields.product_quantity) * Number(this.forms.quantity.fields.price) ) * Number(this.forms.pos.fields.disc_code_1) ,
          //  this.forms.quantity.fields.disc_amount * this.forms.quantity.fields.product_quantity,
        extended:
        (this.forms.quantity.fields.price * this.forms.quantity.fields.product_quantity) - this.forms.quantity.fields.disc_amount,
        uom_code: this.forms.quantity.fields.uom_code
      });
      this.showModalQuantity = false;
      this.showModalProducts = false;
      this.forms.pos.fields.disc_code_1 = '';
      }else{
         this.tables.posentry.items.push({
        inmr_hash: this.forms.quantity.fields.inmr_hash,
        inlo_hash: this.forms.quantity.fields.inlo_hash,
        item_no: this.forms.quantity.fields.item_no,
        description: this.forms.quantity.fields.description,
        price: this.forms.quantity.fields.price,
        product_quantity: this.forms.quantity.fields.product_quantity,
        disc_amount:
         (Number(this.forms.quantity.fields.product_quantity) * Number(this.forms.quantity.fields.price) ) * Number(0) ,
          //  this.forms.quantity.fields.disc_amount * this.forms.quantity.fields.product_quantity,
        extended:
        (this.forms.quantity.fields.price * this.forms.quantity.fields.product_quantity) - this.forms.quantity.fields.disc_amount,
        uom_code: this.forms.quantity.fields.uom_code
      });
      this.showModalQuantity = false;
      this.showModalProducts = false;
      this.forms.pos.fields.disc_code_1 = '';
      }
    },
    removeProduct(index) {
      this.tables.posentry.items.splice(index, 1);
    }
  },

  created() {
    window.addEventListener('keydown', (e) => {
      if (e.key == 'F1') {

        this.focusElement('barcode');
        return false
      }
    });
    window.addEventListener('keydown', (e) => {
      if (e.key == 'F2') {
        this.showModalProducts = 'true';
        return false
      }
    });
    window.addEventListener('keydown', (e) => {
      if (e.key == 'F3') {
        this.rowSelected();
        return false
      }
    });
    this.$http
      .get("api/pos", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        this.tables.products.items = response.data.products;
        this.paginations.posentry.totalRows = response.data.products.length;
        this.options.psds.items = response.data.psds;
        this.options.special.items = response.data.special;
        // this.options.gctypes.items = response.data.gctypes;
      })
      .catch(error => {
        console.log(error);
      });
  },
  computed: {
    getTotalItems() {
      this.forms.pos.fields.gross_amount = 0;

      this.tables.posentry.items.forEach(item => {
        // console.log(item);
        this.forms.pos.fields.gross_amount +=
          (Number(item.price) * Number(item.product_quantity)) - Number(item.disc_amount);
      });
      return parseFloat(this.forms.pos.fields.gross_amount, 2);
    }
  },
  getTotalPayment() {
    this.forms.pos.fields.payment_amount = 0;

    this.tables.posentry.items.forEach(item => {
      // console.log(item);
      this.forms.payment.fields.payment_amount +=
        Number(item.disc_rate) +
        Number(item.check_type_id) +
        Number(item.gc_type_id) +
        Number(item.charge_to);
    });
    return parseFloat(this.forms.payment.fields.payment_amount, 2);
  },
  getTotalChange() {
     this.forms.pos.fields.total_change = 0;

        // console.log(item);
        this.forms.pos.fields.total_change =
        (Number(forms.pos.fields.cash_rendered) - (Number(forms.pos.fields.gross_amount) - (Number(forms.pos.fields.gross_amount) * Number(forms.pos.fields.disc_code))))
         
      return parseFloat(this.forms.pos.fields.total_change, 2);

    // this.forms.totchange.fields.total_change = 0;

    // this.tables.posentry.items.forEach(item => {
    //   // console.log(item);
    //   this.forms.totchange.fields.total_change =
    //  // {{formatNumber(forms.pos.fields.cash_rendered - (forms.pos.fields.gross_amount * forms.pos.fields.disc_rate) - forms.pos.fields.gross_amount)}}
    //     Number(this.forms.pos.fields.gross_amount) - Number(this.forms.pos.fields.cash_rendered);
    // });
    // return parseFloat(this.forms.totchange.fields.change_total, 2);
  },
  mounted(){   
    // document.querySelector('product_quantity').addEventListener("keypress", function (evt) {
    // if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    // {
    //     evt.preventDefault();
    // }
    // });
    this.focusElement('barcode');
    //  function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
    //   $(document).on("keydown", disableF5);
    setInterval(() => {
      this.timenow = moment().format('LTS');
    }, 1000);
    
  }
};
</script>
