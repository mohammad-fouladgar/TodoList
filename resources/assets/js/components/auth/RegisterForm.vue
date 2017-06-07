<template>
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                 <div class="alert alert-danger" v-if="error" >
                {{ error }}
                </div>
                  <div class="alert alert-success" v-if="success" >
                    {{ success }}
                </div>
                    <form class="form-horizontal" role="form" method="post">
                        <div class="form-group" :class="{'has-error': errors.has('name') }">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" 
                                v-model= 'name' v-validate="'required'"  autofocus>
                                <span class="help-block" v-show="errors.has('name')">
                                    <strong>{{ errors.first('name') }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group" :class="{'has-error': errors.has('email') }">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                v-model= 'email' v-validate="'required|email'"
                                >
                                <span class="help-block" v-show="errors.has('email')">
                                    <strong>{{ errors.first('email') }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group" :class="{'has-error': errors.has('password') }">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password"
                                 v-model='password' v-validate="'required||min:6|confirmed:pw_confirm'"
                                >

                                <span class="help-block" v-show="errors.has('password')">
                                    <strong>{{ errors.first('password') }}</strong>
                                </span>

                                
                            </div>
                        </div>

                        <div class="form-group" :class="{'has-error': errors.has('pw_confirm') }">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="pw_confirm" v-model='pw_confirm' v-validate="'required|min:6'">
                                <span class="help-block" v-show="errors.has('pw_confirm')">
                                    <strong>{{ errors.first('pw_confirm') }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" @click="validateForm">
                                    Register
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
    name: 'registerform',
    props:{
        action: {
            type: String,
            required: true
        },
    },
  data: () => ({
    name: '',
    email : '',
    password:'',
    pw_confirm : '',
    success : '',
    error: ""
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
          
          this.register();

      }).catch(() => {
          // eslint-disable-next-line
          
      });
     
    },

    register(){

      var $this = this;

      axios.post(this.action,
        {email : this.email, password : this.password, name : this.name, password_confirmation:this.pw_confirm
      })
        .then(function (response) {
            // console.log(response);
            $this.success = response.data.message;
            $this.error = '';
        })
        .catch(function (error) {
            console.log(error)
            $this.error = error.response.data.email;
            $this.success = '';
        });
    }
  }
};
</script>
