<template>
  <div>
    <a
      class="text-blueGray-500 block"
      href="#pablo"
      v-on:click="toggleDropdown($event)"
      ref="btnDropdownRef"
    >
      <div class="items-center flex">
        <span
          class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"
        >
          <img
            alt="..."
            class="w-full rounded-full align-middle border-none shadow-lg"
            src="/career-clinic/public/assets/img/team-1-800x800.jpg"
          />
        </span>
      </div>
    </a>
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
        currentUser: {},
        token: localStorage.getItem('token')
      };
    },
    methods: {
      toggleDropdown: function(event) {
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
        axios.post('/career-clinic/api/logout').then((response) => {
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
      axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
      axios.get('/career-clinic/api/user').then((response) => {
        if (response.data.user_type == 'user') {
          this.$router.push('/')
        }else{
          this.currentUser = response.data
        }
      }).catch((errors) => {
          console.log(errors)
      })
    }
  };
</script>
