<template>
  <!-- Navbar -->
  <nav
    class="relative top-0 left-0 w-full z-10 bg-red-500 md:flex-row md:flex-nowrap md:justify-start flex items-center p-4"
  >
    <div
      class="w-full mx-autp items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4"
    >
      <!-- Brand -->
      <router-link v-if="$route.name == 'dashboard'"  class="text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold" to="/main_controller_panel/"><i class="fas fa-tv text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold"></i> Dashboard</router-link>
      <router-link v-if="$route.name == 'user'"  class="text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold" to="/main_controller_panel/user"><i class="fas fa-user-circle text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold"></i> Users</router-link>
      <router-link v-if="$route.name == 'create_user'"  class="text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold" to="/main_controller_panel/create_user"><i class="fas fa-user-circle text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold"></i> Create User</router-link>
      <router-link v-if="$route.name == 'post'"  class="text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold" to="/main_controller_panel/post"><i class="fas fa-newspaper text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold"></i> Posts</router-link>
      <router-link v-if="$route.name == 'create_post'"  class="text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold" to="/main_controller_panel/create_post"><i class="fas fa-newspaper text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold"></i> Ask a Question</router-link>
      <router-link v-if="$route.name == 'admin'"  class="text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold" to="/main_controller_panel/admin"><i class="fas fa-user text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold"></i> Admins</router-link>
      <router-link v-if="$route.name == 'create_admin'"  class="text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold" to="/main_controller_panel/create_admin"><i class="fas fa-user text-gray-50 text-sm uppercase hidden lg:inline-block font-semibold"></i> Create Admin</router-link>

      <!-- User -->
      <ul
        class="relative flex-col md:flex-row list-none items-center hidden md:flex"
      >
        <user-dropdown-component></user-dropdown-component>
      </ul>
    </div>
  </nav>

  <!-- End Navbar -->
</template>
<script>
  import UserDropdownComponent from "./UserDropdown.vue";
  export default {
    components: {
      UserDropdownComponent
    }
  };
</script>
