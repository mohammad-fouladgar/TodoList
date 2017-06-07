<template>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Login</div>
        <div class="panel-body">
            <div class="alert alert-danger" v-if="error" >
                {{ error }}
            </div>

            <div class="alert alert-success" v-if="success" >
                {{ success }}
            </div>

            <form  action="login" class="form-horizontal" role="form" method="POST" >
                
                <div class="form-group" :class="{'has-error': errors.has('email') }">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                    <div class="col-md-6">
                        <input id="email"  v-model='email' type="text" class="form-control" name="email" v-validate="'required|email'"  autofocus>
                        <span class="help-block" v-show="errors.has('email')">
                            <strong>{{ errors.first('email') }}</strong>
                        </span>
                         <!--  <span v-show="fields.email && fields.email.dirty">I'm Dirty</span>
  <span v-show="fields.email && fields.email.touched">I'm touched</span>
  <span v-show="fields.email && fields.email.valid">I'm valid</span> -->
                    </div>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('password') }">
                    <label for="password" class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" v-model='password' v-validate="'required'" >
                        <span class="help-block" v-show="errors.has('password')">
                            <strong>{{ errors.first('password') }}</strong>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" v-model="remember" > Remember Me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" :disabled="!isValid" @click="validateForm">
                            Login
                        </button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>

export default {
    name: 'loginform',
    props:{
        action: {
            type: String,
            required: true
        },
    },
  data: () => ({
    email: '',
    password : '',
    remember:'',
    error : '',
    success : ''
  }),
  computed: {
    
    isValid() {
        return true;
        // console.log(Object.keys(this.fields));
        // Object.keys(this.fields).each(function(){

        // });
   // return this.$validator.errors;
      // are some fields dirty?
      // return Object.keys(this.fields).some(key => this.fields[key].valid);
    }
  },
 methods: {
    validateForm(e) {
        e.preventDefault();

      this.$validator.validateAll().then(() => {
          
          this.login();

      }).catch(() => {
          // eslint-disable-next-line
          
      });
     
    },

    login(){

      var $this = this;

      axios.post(this.action,{email : this.email, password : this.password, remember : this.remember
      })
        .then(function (response) {
        // console.log(response);
          $this.success = response.data.message;
          $this.error = '';
          setTimeout(function(){
            window.location = response.data.responseURL;
          }, 200);

        })
        .catch(function (error) {
            $this.error = error.response.data.email;
        });
    }
  }
};
</script>
