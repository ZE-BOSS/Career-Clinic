<template>
  <div>
    <sidebar-component></sidebar-component>
    <div class="relative md:ml-64 bg-blueGray-100">
      <navbar-component></navbar-component>
      <!-- Header -->
      <div class="relative bg-white-600 md:pt-8 pb-8 pt-12">
        <div class="px-4 md:px-10 mx-auto w-full">
          
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import NavbarComponent from "../components/Navbar.vue";
  import SidebarComponent from "../components/Sidebar.vue";
  import axios from 'axios';
  import Button from '../../../../../vendor/laravel/breeze/stubs/inertia-vue/resources/js/Components/Button.vue';
  export default {
    name: "dashboard",
    components: {
        NavbarComponent,
        SidebarComponent,
        Button
    },
  };
</script>