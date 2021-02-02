<template>
    <div>
        <b-card>
           <template #header>
                        <div style="height:25px;">
                        <b-row>
                        <b-col lg="4">
                        <h5>  <!-- table header -->
                            <span style="color: #FFA500;">
                                
                                X - Reading
                                <!-- <small class="font-italic">List of all registered Card type.</small> -->
                                </span>


                        </h5>
                        </b-col>
                        </b-row>
                        </div>
                        </template>

                        <b-row>
                         <b-col lg="4">
                            <label>Date</label>
                            <date-picker
                                id="date"
                                format="MMMM/DD/YYYY"
                                type="date"
                                lang="en"
                                input-class="form-control mx-input"
                                ref="date"
                                v-model="date"
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
                            v-model="forms.xreading.fields.user_hash"
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
                                    v-model="forms.xreading.fields.term_no"
                                >
                                    <option v-for="term in options.term.items"
                                    :key="term.term_no"
                                    :value="term.term_no"
                                    >{{term.description}}</option>
                                </select2>
                            </b-form-group>
                            </b-col>
                              <b-col lg="4">
                                <b-button class="mt-4" style="width: 48%" variant="primary" @click="generate">
                                    Generate
                                </b-button>
                                <b-button class="mt-4" style="width: 48%" variant="success"  @click="PrintXReading()">
                                    Print
                                </b-button>
                            </b-col>
                        </b-row>
                    <div>
                    <b-table
                    v-show="tablehide"
                    responsive
                    striped
                    hover
                    small
                    bordered
                    show-empty
                    :fields="tables.xreading.fields"
                    :items.sync="tables.xreading.items"
                    ></b-table>
                    </div>
                    </b-card>
    </div>
</template>
<script>
export default {
    name: "xreading",
    data: function() {
        return {
            tablehide: false,
            date: null,
            forms: {
                xreading: {
                fields: {
                user_hash: null,
                }
                }
            },
             tables: {
        xreading: {
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
        }
    },
    methods: {
        PrintXReading() {
        var this_date = 0;
        if (this.date == null) {
             Toast.fire({
              position: 'top-right',
              icon: 'error',
              title: 'Please select a From Date.',
              showConfirmButton: false,
              timer: 2000
              })
      
        } else if (this.date != null ) {
            this_date = this.moment(this.date, "YYYY-MM-DD");
            window.open("api/print/date/" + this_date ,);
        }
        },
        generate() {
           var this_date = 0;
           
           if (this.date != null ){
            this_date = this.moment(this.date, "YYYY-MM-DD");
             this.$http.get("api/date/"+ this_date,{
             headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
          }).then(response => {
            this.tables.xreading.items = response.data.date;
            this.tablehide = true
          })
          .catch(err=>{
            console.log(err)
          })
        }
        }
    },
    created() {
         this.$http
        .get("api/index", {
            headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
            }
        })
        .then(response => {
            this.options.user.items = response.data.user;
            this.options.term.items = response.data.term;
        })
        .catch(error => {
            console.log(error);
        });
    }
}
</script>