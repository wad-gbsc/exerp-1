<style scoped>
.body {
  margin: 0%;
  overflow: hidden;
}
.sec {
  height: 400%;
  color: white;
  text-align: justify;
  background-attachment: fixed;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
.titlelabeltop {
  font-size: 15px;
}

.titlelabelbot {
  font-size: 12px;
}
  img{
    height: auto!important;
    /* filter: blur(1px); */
    
  }
  .login-block{
    height: 100%!important;
    background: linear-gradient(to bottom, #d6eaf9, #0294fd);
    float:left;
    width:100%;
    padding : 50px 0;
    margin: 0;
  }
  .container{
    min-height: 100%;
    background:#fff; 
    border-radius: 10px;
  }
  .banner-sec{background-size:cover; min-height:100%; border-radius: 10px 0 0 10px; padding:0;}
  .carousel-inner{border-radius:10px 0 0 10px;}
  .carousel-caption{text-align:left; left:5%;}
  .login-sec{padding: 50px 30px; position:relative;}
  .login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
  .login-sec .copy-text i{color:#1f81c7;}
  .login-sec .copy-text a{color:#1f81c7;}
  .login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #000000;}
  .login-sec h2:after{content:" "; width:100px; height:5px; background:#000000; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
  .banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
  .banner-text h2{color:#000000; font-weight:600;}
  .banner-text h2:after{content:" "; width:100px; height:5px; background:#000000; display:block; margin-top:20px; border-radius:3px;}
  .banner-text p{color:#000000;}
</style>
<template>
  <div>
    <notifications group="notification" />
    <section class="login-block">
      <b-container>
        <b-row>
          <b-col md="8" class="banner-sec">
            <div class="carousel-inner carousel">
              <img style="height:100% !important" class="d-block img-fluid" src="images/1.jpg" alt="First slide">
              <div class="carousel-caption d-none d-md-block">
                <div class="banner-text">
                    <!-- <h2>Billing System</h2> -->
                </div>	
              </div>
            </div>
          </b-col>
          <b-col md="4" class="login-sec">
            <h2 class="text-center">Login</h2>
            <b-form @submit.prevent="authLogin()" @input="login.success = null">
              <b-form-group>
                <label class="text-uppercase">Username</label>
                <b-form-input
                  ref="username" 
                  v-model="login.username"
                  type="text" 
                  placeholder="Username">
                </b-form-input>
                <b-form-invalid-feedback>
                    <i class="fa fa-exclamation-triangle text-danger"></i>
                    <span v-if="login.success==false">
                        Incorrect username or password.
                    </span>
                </b-form-invalid-feedback>
              </b-form-group>
              <b-form-group>
                <label for="exampleInputPassword1" class="text-uppercase">Password</label>
                <b-form-input 
                  v-model="login.password"
                  type="password" 
                  placeholder="Password">
                </b-form-input>
              </b-form-group>
            
              <hr>
              <b-row>
                 <b-col lg="12">
                 <div class="input-group mb-3">
                  <span class="input-group-addon">
                    <i class="fa fa-home"></i>
                  </span>
                  <select2
                  id="co_no"
                  ref="co_no"
                  style="width: 87%;"
                  :allowClear="false"
                  :placeholder="'Company'"
                  v-model="login.co_no"
                  >
                <option v-for="comr in options.comr.items"
                :key="comr.comr_hash"
                :value="comr.comr_hash"
                >{{comr.co_code}}</option>
                  </select2>
                </div>

                <div class="input-group mb-3">
                  <span class="input-group-addon">
                    <i class="fa fa-home" aria-hidden="true"></i>
                  </span>
                  <select2
                  id="br_no"
                  ref="br_no"
                  style="width: 87%;"
                  :allowClear="false"
                  :placeholder="'Branch'"
                  v-model="login.br_no"
                  >
                <option v-for="brmr in options.brmr.items"
                :key="brmr.brmr_hash"
                :value="brmr.brmr_hash"
                >{{brmr.br_code}}</option>
                  </select2>
                </div>
                 <div class="input-group mb-3">
                  <span class="input-group-addon">
                    <i class="fa fa-home" aria-hidden="true"></i>
                  </span>
                  <select2
                  id="wh_no"
                  ref="wh_no"
                  style="width: 87%;"
                  :allowClear="false"
                  :placeholder="'Warehouse'"
                  v-model="login.wh_no"
                  >
                <option v-for="whmr in options.whmr.items"
                :key="whmr.whmr_hash"
                :value="whmr.whmr_hash"
                >{{whmr.wh_code}}</option>
                  </select2>
                </div>
                </b-col>
                </b-row>
                <b-btn :disabled="login.is_saving" type="submit" variant="primary" style="width:100%;">Login</b-btn>
            </b-form>
          </b-col>
        </b-row>
      </b-container>
    </section>
  </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      SelectionModal: false,
      login: {
        username: null,
        password: null,
        is_saving: false,
        wh_no: null,
        br_no: null,
        co_no: null
      },
      options: {
        comr: {
          items: []
        },
        brmr: {
          items: []
        },
        whmr: {
          items: []
        }
      }
    };
  },
  methods: {
    onAccessEntry() {
                this.$http
                .post("api/auth/psld", this.login, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token")
                }
                })
                .then(response => {

                }).catch(err => {
                  console.log(err)
                })
        
    },
     authLogin(){

       if (this.login.co_no == null) {
         this.focusElement('co_no')
          Toast.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please Select a Company.'
              })
       }else if (this.login.br_no == null) {
         this.focusElement('br_no')
         Toast.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please Select a Branch.'
              })
       }else if (this.login.wh_no == null) {
          this.focusElement('wh_no')
         Toast.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please Select a Warehouse  .'
              })
       }else{
      this.login.is_saving = true
      this.$http.post('api/auth/login', { 
                    username: this.login.username,
                    password: this.login.password
                }).then(response => {
                    this.onAccessEntry();
                    this.$store.commit('loginUser')
                    this.$store.commit('user', response.data.user)
                    localStorage.setItem('token', response.data.access_token)
                     Toast.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: 'User authenticated successfully.'
                    })
                    
                    setTimeout(function(){
                    this.$router.push({ name: 'Dashboard' })
                    }.bind(this), 1000)
                    this.login.is_saving = false
                    }).catch(err => {
                          Toast.fire({
                          icon: 'error',
                          title: 'Error!',
                          text: 'Incorrect username or password.'
                        })
                          this.login.is_saving = false
                    });
                  }
                  }
                },

    created () {
        this.$http
        .get("api/auth/select", {
            headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
            }
        })
        .then(response => {
            this.options.comr.items = response.data.comr;
            this.options.brmr.items = response.data.brmr;
            this.options.whmr.items = response.data.whmr;
            
        })
        .catch(error => {
            console.log(error);
        });
       },
  mounted() {
    this.focusElement("username");
  }
};
</script>
