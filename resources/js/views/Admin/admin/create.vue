<template> 
    <div>
        <sidebar-component></sidebar-component>
        <div class="relative md:ml-64 bg-blueGray-100">
            <navbar-component></navbar-component>
            <!-- Header -->
            <div class="relative bg-white-600 md:pt-8 pb-8 pt-12">
                <div class="px-4 md:px-10 mx-auto w-full">
                    <div>
                        <div class="grid grid-cols-1">
                            <span v-bind:class="{ hidden: !closeCat, block: closeCat }" class="bg-red-500 grid grid-flow-col text-gray-50 w-42 h-auto p-4" v-if="errors.name">
                                <i class="fas fa-warning text-left w-full"></i>
                                <i class="text-center w-full">{{errors.name[0]}}</i>
                                <a href="#" class="fas fa-close text-right w-full" @click.prevent="closeNcat"></a>
                            </span><br>
                            <span class="hidden" v-if="errors"></span>
                        </div>
                        <div class="grid grid-cols-2">
                            <div>
                                <a href="admin" class="rounded bg-red-600 p-2 text-white ml-4 w-auto">
                                    < Back
                                </a>
                            </div>
                            <div>
                                <a href="#" @click.prevent="addNcat" class="rounded ml-72 bg-indigo-600 p-2 text-white w-auto">
                                    Add New Category
                                </a>
                                <div class="absolute px-6 border-2 border-gray-200 bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-2xlg mt-2 right-28"
                                    v-bind:class="{ hidden: !addCat, block: addCat }" style="min-width: 32rem">
                                    <input v-model="categoryData.name" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="text" placeholder="Web Designer">
                                    <a href="#" @click.prevent="createCategory" class="my-3 w-full flex justify-center bg-green-500 text-gray-100 p-4 rounded-full tracking-wide
                                        font-semibold  focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                                        Create
                                    </a>
                                </div>
                            </div>
                            <br>
                        </div>
                        
                        <div class="sm:max-w-7xl w-full p-4 bg-white rounded-xl z-10">
                            <div class="text-center">
                                <h2 class="mt-5 text-3xl font-bold text-gray-900">
                                    Add Admin!
                                </h2>
                                <p class="mt-2 text-sm text-gray-400">Fill in all provided fields.</p>
                            </div>
                            <form class="mt-8 space-y-3" action="#" method="POST">
                                <div class="grid grid-cols-2">
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">First Name</label>
                                        <input v-model="adminData.first_name" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="text" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Middle Name</label>
                                        <input v-model="adminData.middle_name" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="text" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Last Name</label>
                                        <input v-model="adminData.last_name" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="text" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">admin Specialisation</label>
                                        <select v-model="adminData.account_type" class="text-gray-500 text-base border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
                                            <option v-for="(category, cat) in categories" :key="cat" :value="category.id">{{category.name}}</option>
                                        </select>
                                    </div>
                                    <div class="p-2">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Profile Picture</label>
                                        <div class="flex items-center justify-center w-full">
                                            <label class="flex flex-col rounded-lg border-4 border-dashed w-full h-1/2 p-10 group text-center">
                                                <div class="h-1/2 w-full text-center flex flex-col justify-center items-center  ">
                                                    <p class="pointer-none text-gray-500" v-if="adminData.photo == ''">
                                                        <span class="text-sm">Drag and drop </span> 
                                                        profile photo here <br /> or 
                                                        <a href="#" @click.prevent="" id="" class="text-blue-600 hover:underline">select a photo</a> 
                                                        from your computer
                                                    </p>
                                                    <p class="pointer-none text-gray-500" v-else>
                                                        <span class="text-blue-600 grid grid-flow-col border-2 border-gray-100">
                                                            <div class="text-white text-center border-none inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-white">
                                                                <img v-if="adminData.photo.type == 'image/jpeg' || adminData.photo.type == 'image/png'" alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="" v-bind:ref="'photo'"/>
                                                                <p class="fas fa-close text-5xl p-2 text-red-600" v-else></p>
                                                            </div>
                                                            <i class="p-2">{{adminData.photo.name}}</i>
                                                            <a href="#" class="fas fa-close text-red-600 p-2" @click.prevent="removePhoto"></a>
                                                        </span> <br />
                                                    </p>
                                                </div>
                                                <input type="file" class="hidden" v-on:change="getPhoto">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Background Picture</label>
                                        <div class="flex items-center justify-center w-full">
                                            <label class="flex flex-col rounded-lg border-4 border-dashed w-full h-1/2 p-10 group text-center">
                                                <div class="h-1/2 w-full text-center flex flex-col justify-center items-center  ">
                                                    <p class="pointer-none text-gray-500" v-if="adminData.background == ''">
                                                        <span class="text-sm">Drag and drop </span> 
                                                        Background photo here <br /> or 
                                                        <a href="#" @click.prevent="" id="" class="text-blue-600 hover:underline">select a photo</a> 
                                                        from your computer
                                                    </p>
                                                    <p class="pointer-none text-gray-500" v-else>
                                                        <span class="text-blue-600 grid grid-flow-col border-2 border-gray-100">
                                                            <div class="text-white text-center border-none inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-white">
                                                                <img v-if="adminData.background.type == 'image/jpeg' || adminData.background.type == 'image/png'" alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="" v-bind:ref="'background'"/>
                                                                <p class="fas fa-close text-5xl p-2 text-red-600" v-else></p>
                                                            </div>
                                                            <i class="p-2">{{adminData.background.name}}</i>
                                                            <a href="#" class="fas fa-close text-red-600 p-2" @click.prevent="removeBackground"></a>
                                                        </span> <br />
                                                    </p>
                                                </div>
                                                <input type="file" class="hidden" v-on:change="getBackground">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Date of Birth</label>
                                        <input v-model="adminData.dob" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="date" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">City</label>
                                        <input v-model="adminData.city" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="text" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">State</label>
                                        <input v-model="adminData.state" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="text" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Country</label>
                                        <input v-model="adminData.country" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="text" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Address</label>
                                        <input v-model="adminData.address" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="text" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">User Name</label>
                                        <input v-model="adminData.user_name" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="text" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Password</label>
                                        <input v-model="adminData.password" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="password" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Email</label>
                                        <input v-model="adminData.email" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="email" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Phone Number 1</label>
                                        <input v-model="adminData.phone_1" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="number" placeholder="">
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Phone Number 2 (Optional)</label>
                                        <input v-model="adminData.phone_2" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="number" placeholder="">
                                    </div>
                                </div>
                                <span v-bind:class="{ hidden: !closeCat, block: closeCat }" class="bg-red-500 grid grid-flow-col text-gray-50 w-42 h-auto p-4" v-if="errors.name">
                                    <i class="fas fa-warning text-left w-full"></i>
                                    <i class="text-center w-full">{{errors.name[0]}}</i>
                                    <a href="#" class="fas fa-close text-right w-full" @click.prevent="closeNcat"></a>
                                </span><br>
                                <div class="grid grid-cols-2">
                                    <div>
                                        <a href="#" @click.prevent="showSocial" v-bind:class="{ hidden: !sociai, block: sociai }" class="my-5 w-full flex justify-center bg-indigo-500 text-gray-100 p-4 tracking-wide
                                            font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                                            Add Social Media Accounts?
                                        </a>
                                        <a href="#" @click.prevent="removeSocial" v-bind:class="{ hidden: !sociah, block: sociah }" class="my-5 w-2/3 flex justify-center bg-red-500 text-gray-100 p-4 tracking-wide
                                            font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                                            Close
                                        </a>
                                    </div>
                                    <div v-bind:class="{ hidden: !sociah, block: sociah }">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Number Of Social Media Account to be Added</label>
                                        <input @keyup="getNo_icon" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="number" placeholder="">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2" v-for="(no_icon, no_i) in adminData.no_icon" :key="no_i" v-bind:class="{ hidden: !sociah, block: sociah }">
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Social Media</label>
                                        <select v-model="adminData.name[no_i]" class="text-gray-500 text-base border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
                                            <option value="Facebook">Facebook</option>
                                            <option value="Twitter">Twitter</option>
                                            <option value="Instagram">Instagram</option>
                                            <option value="Linkedin">Linkedin</option>
                                            <option value="Pinterest">Pinterest</option>
                                        </select>
                                    </div>
                                    <div class="hidden">
                                        <i v-if="adminData.name[no_i] == 'Facebook'">{{adminData.icon[no_i] = '<i class="fas fa-facebook-official" aria-hidden="true"></i>'}}</i>
                                        <i v-if="adminData.name[no_i] == 'Twitter'">{{adminData.icon[no_i] = '<i class="fas fa-twitter-square" aria-hidden="true"></i>'}}</i>
                                        <i v-if="adminData.name[no_i] == 'Instagram'">{{adminData.icon[no_i] = '<i class="fas fa-instagram" aria-hidden="true"></i>'}}</i>
                                        <i v-if="adminData.name[no_i] == 'Linkedin'">{{adminData.icon[no_i] = '<i class="fas fa-linkedin" aria-hidden="true"></i>'}}</i>
                                        <i v-if="adminData.name[no_i] == 'Pinterest'">{{adminData.icon[no_i] = '<i class="fas fa-pinterest-square" aria-hidden="true"></i>'}}</i>
                                    </div>
                                    <div class="p-3">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Social Link</label>
                                        <input v-model="adminData.link[no_i]" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="url" placeholder="">
                                    </div>
                                </div>
                                <div>
                                    <a href="#" @click.prevent="createAdmin" class="my-5 w-full flex justify-center bg-green-500 text-gray-100 p-4  rounded-full tracking-wide
                                        font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                                        Create
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>
<style>
	.has-mask {
		position: absolute;
		clip: rect(10px, 150px, 130px, 10px);
	}
</style>
<script>
    import MyFormData from "../../../MyFormData";
    import NavbarComponent from "../components/Navbar.vue";
    import SidebarComponent from "../components/Sidebar.vue";
    import axios from 'axios';
    import Button from '../../../../../vendor/laravel/breeze/stubs/inertia-vue/resources/js/Components/Button.vue';
    export default {
      name: "create_admin",
      components: {
          NavbarComponent,
          SidebarComponent,
          Button
      },
      data() {
          return {
            adminData: new MyFormData({
              first_name: '',
              middle_name: '',
              last_name: '',
              user_name: '',
              photo: '',
              background: '',
              dob: '',
              city: '',
              state: '',
              country: '',
              address: '',
              user_type: '',
              account_type: '',
              workstatus: '',
              phone_1: '',
              phone_2: '',
              email: '',
              password: '',
              name: [],
              link: [],
              icon: [],
              icon_name: [],
              no_icon: [],
            }),
            sociai: true,
            sociah: false,
            errors: {},
            categoryData: { name: '' },
            addCat: false,
            closeCat: true,
            date: new Date().getFullYear(),
            categories: {},
            currentUser: {},
            token: localStorage.getItem('token')
          }
      },
      methods: {
        getPhoto(e) {
            this.adminData.photo = e.target.files[0];

            if(this.adminData.photo.type == 'image/jpeg' || this.adminData.photo.type == 'image/png'){
                let reader = new FileReader();
                reader.addEventListener('load', function(){
                    this.$refs['photo'].src = reader.result;
                }.bind(this), false);

                reader.readAsDataURL(this.adminData.photo);
            }else{
                this.errors = {name: ['Accept Images Only!']};
            }
        },
        removePhoto() {
            this.adminData.photo = '';
        },
        getBackground(e) {
            this.adminData.background = e.target.files[0];

            if(this.adminData.background.type == 'image/jpeg' || this.adminData.background.type == 'image/png'){
                let reader = new FileReader();
                reader.addEventListener('load', function(){
                    this.$refs['background'].src = reader.result;
                }.bind(this), false);

                reader.readAsDataURL(this.adminData.background);
            }else{
                this.errors = {name: ['Accept Images Only!']};
            }
        },
        removeBackground() {
            this.adminData.background = '';
        },
        getNo_icon(e){
            if(this.adminData.no_icon.length > 0){
                this.adminData.no_icon = [];
                this.iconPush(e);
            }else{
                this.iconPush(e);
            }
        },
        iconPush(e) {
            let input = e.target.value;
            
            if(input < 6){
                for(let i = 0; i < input; i++)
                {
                    this.adminData.no_icon.push(i);
                }
            }else{
                this.errors = {name: ['A Total of Only 5 Social Media Handle is Allowed!']};
            }
        },
        showSocial() {
            this.sociah = true;
            this.sociai = false;
        },
        removeSocial() {
            this.sociah = false;
            this.sociai = true;
            this.adminData.no_icon = [];
            this.adminData.name = [];
            this.adminData.link = [];
            this.adminData.icon = [];
            this.adminData.icon_name = [];
        },
        getCategory() { 
          axios.get('/career-clinic/api/create_post').then((response) => {
            this.categories = response.data.post_categories
          }).catch((errors) => {
            console.log(errors)
          });
        },
        createAdmin() { 
            for(let i = 0; i < this.adminData.no_icon.length; i++){
                if(this.adminData.name[i] == 'Facebook'){
                    this.adminData.icon[i] = '<i class="fas fa-facebook-official" aria-hidden="true"></i>';
                }
                if(this.adminData.name[i] == 'Twitter'){
                    this.adminData.icon[i] = '<i class="fas fa-twitter-square" aria-hidden="true"></i>'
                }
                if(this.adminData.name[i] == 'Instagram'){
                    this.adminData.icon[i] = '<i class="fas fa-instagram" aria-hidden="true"></i>'
                }
                if(this.adminData.name[i] == 'Linkedin'){
                    this.adminData.icon[i] = '<i class="fas fa-linkedin" aria-hidden="true"></i>'
                }
                if(this.adminData.name[i] == 'Pinterest'){
                    this.adminData.icon[i] = '<i class="fas fa-pinterest-square" aria-hidden="true"></i>'
                }
            }
          this.adminData.post('/career-clinic/api/createAdmin')
            .catch((errors) => {
                throw errors;
            })
            .then((response) => {
                this.$router.push('admin')
            });
        },
        createCategory() { 
          axios.post('/career-clinic/api/createCategory', this.categoryData).then((response) => {
            this.categoryData.name = ''
            this.addCat = false
            this.getCategory()
          }).catch((errors) => {
            this.errors = errors.response.data.errors
            console.log(errors)
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
      },
      mounted() {
        this.getCategory()
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
        axios.get('/career-clinic/api/user').then((response) => {
            this.currentUser = response.data
        }).catch((errors) => {
            console.log(errors)
        })
      }
    };
</script>