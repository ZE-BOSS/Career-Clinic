<template>
  <div>
    
    <div class="items-center flex" v-if="$route.name == 'user_login' || $route.name == 'user_register'">

    </div>
    <div class="items-center flex mr-10" v-else>
      <span v-if="currentUser.id == ''"
        class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center"
      >
        <a
          href="register"
          class="relative text-lg hover:text-indigo-600 py-2 mr-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
        >
          Register
        </a>
        <p class="text-white ml-4">|</p>
        <a
          href="login"
          class="relative text-lg hover:text-indigo-600 py-2 ml-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
        >
          Login
        </a>
      </span>
      <span v-else
        class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"
      >
        <img
          alt="..."
          class="w-full rounded-full align-middle border-none shadow-lg"
          :src="'/career-clinic/public/storage/user/image/'+currentUser.photo"
          @click.prevent="drop($event)"
        />
      </span>
    </div>
    <div
      ref="popoverDropdownRef"
      class="absolute bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-2xlg mt-1 right-0"
      v-bind:class="{
        hidden: !dropdownPopoverShow,
        block: dropdownPopoverShow
      }"
      style="min-width: 12rem"
    >
      <a
        href="#Profile"
        class="relative text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
      >
        Profile
      </a>
      <div class="relative h-0 my-2 border border-solid border-blueGray-100" />
      <a
        href="#"
        class="relative text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
        @click.prevent="logout"
      >
        Logout
      </a>
    </div>
  </div>
</template>
<script>
  import Popper from 'vue-popperjs';
  import 'vue-popperjs/dist/vue-popper.css';
  import axios from 'axios';
  export default {
    data() {
      return {
        dropdownPopoverShow: false,
        currentUser: {id: ''},
        token: localStorage.getItem('token')
      };
    },
    methods: {
      drop(event) {
        event.preventDefault();
        if (this.dropdownPopoverShow) {
          this.dropdownPopoverShow = false;
        } else {
          this.dropdownPopoverShow = true;
          // createPopper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
          //   placement: "bottom-end"
          // });
        }
      },
      logout() {
        axios.post('api/user_logout').then((response) => {
            localStorage.removeItem('token')
            this.$router.push('login')
            //this.$toaster.info('Logout Successful!')
            console.log(response.data)
        }).catch((error) => {
            console.log(error)
            //this.$toaster.error(error, {timeout: 80000})
        });
      }
    },
    mounted() {
      if(this.token != null){
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
        axios.get('api/user').then((response) => {
          if (response.data.user_type == 'admin') {
            this.$router.push('/main_controller_panel/')
          }else{
            this.currentUser = response.data
          }
        }).catch((errors) => {
            //console.log(errors)
        })
      }
    }
  };
</script>
