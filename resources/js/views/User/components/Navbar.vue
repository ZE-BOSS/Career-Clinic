<template>
  <!-- Navbar -->
  <nav
    class="relative top-0 left-0 w-full z-10 bg-red-500 md:flex-row md:flex-nowrap md:justify-start flex items-center p-4"
  >
    <div
      class="w-full mx-autp items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4"
    >
      <a
        class="md:block text-white text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap uppercase font-black text-2xl p-4 px-0"
        href="/"
      >
        CAREER CLINIC
      </a>
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
