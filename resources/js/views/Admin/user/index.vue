<template>
  <div>
    <sidebar-component></sidebar-component>
    <div class="relative md:ml-64 bg-blueGray-100">
      <navbar-component></navbar-component>
      <!-- Header -->
      <div class="relative bg-white-600 md:pt-8 pb-8 pt-12">
        <div class="relative">
          <a href="create_user" class="rounded bg-green-500 p-2 text-white ml-4 w-auto">
            Add User
          </a><br><br>
        </div>
        <div class="px-4 md:px-10 mx-auto w-full">
          <div class="px-3 py-4 flex justify-center">
            <table class="w-full text-md bg-white shadow-md rounded mb-4">
                <tbody>
                    <tr class="border-b">
                      <th class="text-left p-3 px-5">Photo</th>
                      <th class="text-left p-3 px-5">User Name</th>
                      <th class="text-left p-3 px-5">Full Name</th>
                      <th class="text-left p-3 px-5">Email</th>
                      <th class="text-left p-3 px-5">Phone Number</th>
                      <th class="text-left p-3 px-5">Category</th>
                      <th class="text-left p-3 px-5">Action</th>
                    </tr>
                    <tr class="border-b hover:bg-orange-100" v-for="(user, id) in users" :key="id">
                        <td class="p-3 px-5">
                          <div class="text-white text-center border-none inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                            <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" :src="'/career-clinic/public/storage/user/image/'+user.photo"/>
                          </div>
                        </td>
                        <td class="p-3 px-5">{{user.user_name}}</td>
                        <td class="p-3 px-5">{{user.first_name}} {{user.middle_name}} {{user.last_name}}</td>
                        <td class="p-3 px-5">{{user.email}}</td>
                        <td class="p-3 px-5" v-if="user.Phone_2 == ''">{{user.Phone_1}}</td>
                        <td class="p-3 px-5" v-else>{{user.Phone_1}}, {{user.Phone_2}}</td>
                        <td class="p-3 px-5">
                          <i v-for="(category, cat) in categories" :key="cat">
                            <i v-if="user.account_type == category.id">{{category.name}}</i>
                          </i>
                        </td>
                        <td class="p-3 px-5 flex justify-end">
                          <button type="button" class="mr-3 text-sm bg-indigo-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Edit</button>
                          <button type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
          </div>
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
    name: "user",
    components: {
        NavbarComponent,
        SidebarComponent,
        Button
    },
    data() {
          return {
            norms: '',
            date: new Date().getFullYear(),
            users: {},
            socials: {},
            categories: {},
            currentUser: {},
            token: localStorage.getItem('token')
          }
      },
      methods: {
        getUser() { 
          axios.get('/career-clinic/api/users').then((response) => {
            this.users = response.data.user_ccs
            this.socials = response.data.socials
            this.categories = response.data.post_categories
          }).catch((errors) => {
            console.log(errors)
          });
        },
      },
    mounted() {
      this.getUser()
      axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
      axios.get('/career-clinic/api/user').then((response) => {
          this.currentUser = response.data
      }).catch((errors) => {
          console.log(errors)
      })
    }
  };
</script>