<template>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Login</div>
        <div class="panel-body">
            <!-- <form  action="login" class="form-horizontal" role="form" method="POST" > -->
                
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
                        <button type="submit" class="btn btn-primary" :disabled="!isValid" @click="login">
                            Login
                        </button>
                    </div>
                </div>
            <!-- </form> -->
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>

export default {
  name: 'loginform',
  data: () => ({
    email: '',
    password : '',
    remember:''
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
    validateForm() {
      this.$validator.validateAll().then(() => {
          // eslint-disable-next-line
      //    this.$http.post('login',{}).then((response) => {
      //             console.log(response);
      //          }, (response) => {
      //             console.log(response);
               
      //          });
          
      }).catch(() => {
          // eslint-disable-next-line
          alert('Correct them errors!');
      });
     
    },
    login(){

      // this.$http.post('login',{}).then((response) => {
      //             console.log(response);
      //          }, (response) => {
      //             console.log(response);
               
      //          });

      axios.post('/login',{
        email : this.email,
        password : this.password,
        remember : this.remember
      })
        .then(function (response) {
        console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });
    }
  }
};
</script>
