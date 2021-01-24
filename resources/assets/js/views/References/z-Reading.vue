<template>
    <div>
        <b-card>
        <b-row>
        <b-col lg="3">
          <label>From Date</label>
          <date-picker
            id="from_datetime"
            format="MMMM/DD/YYYY"
            type="date"
            lang="en"
            input-class="form-control mx-input"
            ref="from_datetime"
            v-model="from_datetime"
            :clearable="false"
          ></date-picker>
        </b-col>

        <b-col lg="3">
          <label>To Date</label>
          <date-picker
            id="to_datetime"
            format="MMMM/DD/YYYY"
            type="date"
            lang="en"
            input-class="form-control mx-input"
            ref="to_datetime"
            v-model="to_datetime"
            :clearable="false"
          ></date-picker>
        </b-col>
        <b-col lg="2">
    <b-form-group>
        <label for="cashier">Cashier</label>
        <select2
            ref="cashier"
            id="cashier"
            :allowClear="false"
            :placeholder="'All'"
            v-model="forms.zreading.fields.user_hash"
        >
            <option
                v-for="user in options.user.items"
                :key="user.user_hash"
                :value="user.user_hash"
                >{{user.fullname}}</option>
        </select2>
    </b-form-group>
        </b-col>
        <b-col lg="2">
    <b-form-group>
        <label for="terminal">Terminal</label>
        <select2
            ref="terminal"
            id="terminal"
            :allowClear="false"
            :placeholder="'All'"
            v-model="forms.zreading.fields.term_no"
        >
            <option v-for="term in options.term.items"
                :key="term.term_no"
                :value="term.term_no"
                >{{term.description}}</option>
        </select2>
    </b-form-group>
        </b-col>
        <b-col lg="2">
            <b-button class="mt-4" style="width: 48%" variant="primary" @click="generate">
                Generate
            </b-button>
            <b-button class="mt-4" style="width: 48%" variant="success"  @click="PrintZReading()">
                Print
            </b-button>
        </b-col>
        </b-row>
        <div >
        <b-table
        v-show="tablehide"
        responsive
        striped
        hover
        small
        bordered
        show-empty
        :fields="tables.zreading.fields"
        :items.sync="tables.zreading.items"
        ></b-table>
        </div>
        </b-card>
    </div>
</template>
<script>
export default {
  name: "zreading",
  data: function() {
    return {
      tablehide: false,
      forms: {
        zreading: {
          fields: {
           user_hash: null,
          }
        }
      },
       tables: {
        zreading: {
          fields: [ 
            {
              key: "co_no",
              label: "Company No.",
              thStyle: { width: "150px" },
              tdClass: "align-middle"
            },
            {
              key: "br_no",
              label: "Branch No.",
              tdClass: "align-middle"
            },
            {
              key: "trans_no",
              label: "Transaction No.",
              tdClass: "align-middle"
            },
            {
              key: "trans_date",
              label: "Transaction Date",
              tdClass: "align-middle",
              sortable: true,
              formatter: value => {
                return this.moment(value, "MMMM DD, YYYY");
              }
            },
            {
              key: "sold_to",
              label: "Sold To",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "cash_rendered",
              label: "Cash Rendered",
              tdClass: "text-center"
            }
          ],
          items: []
        }
      },
      options: { 
          user: {
              items: []
          },
          term: {
              items: []
          }
      },
      from_datetime: null,
      to_datetime: null
    };
  },
  methods: {
    PrintZReading() {
        var date_from = 0;
        var date_to = 0;
        if (this.from_datetime == null) {
             Toast.fire({
              position: 'top-right',
              icon: 'error',
              title: 'Please select a From Date.',
              showConfirmButton: false,
              timer: 2000
              })
        } else if (this.to_datetime == null) {
             Toast.fire({
              position: 'top-right',
              icon: 'error',
              title: 'Please select a To Date.',
              showConfirmButton: false,
              timer: 2000
              })
        // } else if (this.forms.zreading.fields.user_hash == null) {
        //      Toast.fire({
        //       position: 'top-right',
        //       icon: 'error',
        //       title: 'Please select a Cashier',
        //       showConfirmButton: false,
        //       timer: 2000
        //       })
        } else if (this.from_datetime != null && this.to_datetime != null && this.forms.zreading.fields.user_hash != null) {
            date_from = this.moment(this.from_datetime, "YYYY-MM-DD");
            date_to = this.moment(this.to_datetime, "YYYY-MM-DD");
            window.open("api/print/betweenname/" + date_from + "/" + date_to + "/" + this.forms.zreading.fields.user_hash);

        }else if (this.from_datetime != null && this.to_datetime != null){
            date_from = this.moment(this.from_datetime, "YYYY-MM-DD");
            date_to = this.moment(this.to_datetime, "YYYY-MM-DD");
            window.open("api/print/betweendate/" + date_from + "/" + date_to);
        }
       
    },
    generate() {
        var date_from = 0;
        var date_to = 0;
        if (this.from_datetime == null) {
             Toast.fire({
              position: 'top-right',
              icon: 'error',
              title: 'Please select a From Date.',
              showConfirmButton: false,
              timer: 2000
              })
        } else if (this.to_datetime == null) {
             Toast.fire({
              position: 'top-right',
              icon: 'error',
              title: 'Please select a To Date.',
              showConfirmButton: false,
              timer: 2000
              })
        // } else if (this.forms.zreading.fields.user_hash == null) {
        //      Toast.fire({
        //       position: 'top-right',
        //       icon: 'error',
        //       title: 'Please select a Cashier',
        //       showConfirmButton: false,
        //       timer: 2000
        //       })
        } else if (this.from_datetime != null && this.to_datetime != null && this.forms.zreading.fields.user_hash != null) {
            console.log('Show me')
             date_from = this.moment(this.from_datetime, "YYYY-MM-DD");
            date_to = this.moment(this.to_datetime, "YYYY-MM-DD");
             this.$http.get("api/betweenname/"+ date_from + "/" + date_to + "/" + this.forms.zreading.fields.user_hash,{
             headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.tables.zreading.items = response.data.betweenname;
                this.tablehide = true
            })
            .catch(err=>{
                console.log(err)
            })
            
        }else if (this.from_datetime != null && this.to_datetime != null ){
            date_from = this.moment(this.from_datetime, "YYYY-MM-DD");
            date_to = this.moment(this.to_datetime, "YYYY-MM-DD");
             this.$http.get("api/betweendate/"+ date_from + "/" + date_to,{
             headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
          }).then(response => {
            this.tables.zreading.items = response.data.betweendate;
            this.tablehide = true
          })
          .catch(err=>{
            console.log(err)
          })
        }
       
      }
  },
  created () {
        this.$http
        .get("api/index", {
            headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
            }
        })
        .then(response => {
            // this.tables.inmr.items = response.data.inmr;
            this.options.user.items = response.data.user;
            this.options.term.items = response.data.term;
        })
        .catch(error => {
            console.log(error);
        });

       },
};
</script>
