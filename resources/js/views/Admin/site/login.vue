<template>
  <div>
    <navbar-component></navbar-component>
    <main>
      <section class="absolute w-full h-full">
        <div
          class="absolute top-0 w-full h-full bg-gray-900"
          style="background-size: 100%; background-repeat: no-repeat;"
          :style="{'background-image': 'url(' + require('/assets/img/register_bg_2.png').default + ')'}"
        ></div>
        <div class="container mx-auto px-4 h-full">
          <div class="flex content-center items-center justify-center h-full">
            <div class="w-full lg:w-4/12 px-4">
              <div
                class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0"
              >
                <div class="rounded-t mb-0 px-6 py-6">
                  <div class="text-center mb-3">
                    <h6 class="text-gray-600 text-sm font-bold">
                      Admin Login
                    </h6>
                  </div>
                  <!-- <div class="btn-wrapper text-center">
                    <button
                      class="bg-white active:bg-gray-100 text-gray-800 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs"
                      type="button"
                      style="transition: all 0.15s ease 0s;"
                    >
                      <img
                        alt="..."
                        class="w-5 mr-1"
                        src="/assets/img/github.svg"
                      />Github</button
                    ><button
                      class="bg-white active:bg-gray-100 text-gray-800 px-4 py-2 rounded outline-none focus:outline-none mr-1 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs"
                      type="button"
                      style="transition: all 0.15s ease 0s;"
                    >
                      <img
                        alt="..."
                        class="w-5 mr-1"
                        src="/assets/img/google.svg"
                      />Google
                    </button>
                  </div> -->
                  <hr class="mt-6 border-b-1 border-gray-400" />
                </div>
                <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                  <div class="text-gray-500 text-center mb-3 font-bold">
                    <small>Sign in with credentials</small>
                  </div>
                  <!-- <form autocomplete="off" @submit.prevent="login" method="post"> -->
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
                      <span class="bg-red-500 text-gray-50 w-42.1 p-2" v-if="errors.email">
                        {{ errors.email[0] }}
                      </span>
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
                      <span class="bg-red-500 text-gray-50 w-42.1 p-2" v-if="errors.password">
                        {{ errors.password[0] }}
                      </span>
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
                  <!-- </form> -->
                </div>
              </div>
              <div class="flex flex-wrap mt-6">
                <div class="w-1/2">
                  <a href="#pablo" class="text-gray-300"
                    ><small>Forgot password?</small></a
                  >
                </div>
                <div class="w-1/2 text-right">
                  <a href="#pablo" class="text-gray-300"
                    ><small>Create new account</small></a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
        <footer-component></footer-component>
      </section>
    </main>
  </div>
</template>
<script>
  import NavbarComponent from "../components/LogNavbar.vue";
  import FooterComponent from "../components/LogFooter.vue";
  import axios from 'axios';
  export default {
    name: "login",
    components: {
      NavbarComponent,
      FooterComponent,
    },
    data() {
      return {
        form: {
          email: "",
          password: "",
          device_name: 'browser'
        },
        errors: {}
      };
    },
    methods: {
      login() {
        axios.post('/career-clinic/api/login', this.form).then((response) => {
          this.form.email = this.form.password = ''
          this.errors = {}
          localStorage.setItem('token', response.data)
          this.$router.push('/main_controller_panel/')
        }).catch((errors) => {
          this.errors = errors.response.data.errors
          console.log(errors.response.data.errors)
        });
      }
    }
  }
</script>
