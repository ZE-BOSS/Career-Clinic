<template> 
  <div>
    <div class="relative bg-blueGray-100">
      <navbar-component></navbar-component>
      <!-- Header -->
      <div class="relative md:mx-96 bg-white-600 md:pt-8 pb-8 pt-12 border-2 mt-10 mb-10 bg-gray-400 border-gray-200 rounded-lg">
        <div class="px-4 md:px-10 mx-auto w-full">
          <div>
            <div class="grid grid-cols-1">
                <span v-bind:class="{ hidden: !closeCat, block: closeCat }" class="bg-red-500 grid grid-flow-col text-gray-50 w-42 h-auto p-4" v-if="errors.email">
                    <i class="fas fa-warning text-left w-full"></i>
                    <i class="text-center w-full">{{errors.email[0]}}</i>
                    <a href="#" class="fas fa-close text-right w-full" @click.prevent="closeNcat"></a>
                </span><br>
                <span class="hidden" v-if="errors"></span>
            </div>
            <div class="sm:max-w-7xl w-full p-4 bg-white rounded-xl z-10">
              <div class="text-center">
                  <h2 class="mt-5 text-3xl font-bold text-gray-900">
                      User Login!
                  </h2>
                  <p class="mt-2 text-sm text-gray-400">Sign in with credentials</p>
              </div>
              <form autocomplete="off" method="post">
                <div class="relative w-full mb-3">
                  <label
                    class="block uppercase text-gray-700 text-xs font-bold mb-2"
                    for="email"
                    >Email</label
                  ><input
                    type="email"
                    class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                    id="email" 
                    style="transition: all 0.15s ease 0s;"
                    placeholder="user@example.com"
                    v-model="form.email" required
                  />
                  <!-- <p class="bg-red text-white-700" v-text="errors.email"></p> -->
                </div>
                <div class="relative w-full mb-3">
                  <label
                    class="block uppercase text-gray-700 text-xs font-bold mb-2"
                    for="password"
                    >Password</label
                  ><input
                    type="password"
                    class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                    id="password"
                    style="transition: all 0.15s ease 0s;"
                    v-model="form.password" required
                  />
                  <!-- <p class="bg-red text-white-700" v-text="errors.password"></p> -->
                </div>
                <div>
                  <label class="inline-flex items-center cursor-pointer"
                    ><input
                      id="customCheckLogin"
                      type="checkbox"
                      class="form-checkbox border-0 rounded text-gray-800 ml-1 w-5 h-5"
                      style="transition: all 0.15s ease 0s;" name="remember"
                    /><span class="ml-2 text-sm font-semibold text-gray-700"
                      >Remember me</span
                    ></label
                  >
                </div>
                <div class="text-center mt-6">
                  <button
                    class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                    @click.prevent="login"
                    style="transition: all 0.15s ease 0s;"
                  >
                    Sign In
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import NavbarComponent from "../components/Navbar.vue";
  import axios from 'axios';
  export default {
    name: "login",
    components: {
      NavbarComponent,
    },
    data() {
      return {
        form: {
          email: "",
          password: "",
          device_name: 'browser'
        },
        addCat: false,
        closeCat: true,
        errors: {}
      };
    },
    methods: {
      login() {
        axios.post('api/user_login', this.form).then((response) => {
          this.form.email = this.form.password = ''
          this.errors = {}
          localStorage.setItem('token', response.data)
          this.$router.push('/')
        }).catch((errors) => {
          this.errors = errors.response.data.errors
          console.log(errors.response.data.errors)
        });
      },
      closeNcat() { 
        if (this.closeCat) {
            this.closeCat = false;
            this.errors = {};
        }
      },
      addNcat() { 
        if (this.addCat) {
          this.addCat = false;
        } else {
          this.addCat = true;
        }
      },
    }
  }
</script>
