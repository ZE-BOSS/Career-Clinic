<template> 
    <div>
        <div class="relative bg-blueGray-100">
            <navbar-component></navbar-component>
            <!-- Header -->
            <div class="relative md:mx-52 bg-white-600 md:pt-8 pb-8 pt-12">
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
                                <a href="post" class="rounded bg-red-600 p-2 text-white ml-4 w-auto">
                                    < Back
                                </a>
                            </div>
                            <div>
                                <a href="#" @click.prevent="addNcat" class="rounded ml-52 bg-indigo-600 p-2 text-white w-auto">
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
                                    Ask a Question!
                                </h2>
                                <p class="mt-2 text-sm text-gray-400">Fill in all provided fields.</p>
                            </div>
                            <form class="mt-8 space-y-3" action="#" method="POST">
                                <div class="grid grid-cols-2">
                                    <div class="p-2">
                                        <div class="p-3">
                                            <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Title</label>
                                            <input v-model="postData.title" class="text-base p-4 border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="text" placeholder="what is computer science?">
                                        </div>
                                        <div class="p-3">
                                            <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Question Category</label>
                                            <select v-model="postData.link" class="text-gray-500 text-base border w-full h-10 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
                                                <option v-for="(category, cat) in categories" :key="cat" :value="category.id">{{category.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Attach Document (Optional)</label>
                                        <div class="flex items-center justify-center w-full">
                                            <label class="flex flex-col rounded-lg border-4 border-dashed w-full h-1/2 p-10 group text-center">
                                                <div class="h-1/2 w-full text-center flex flex-col justify-center items-center  ">
                                                    <p class="pointer-none text-gray-500" v-if="postData.image.length <= 0">
                                                        <span class="text-sm">Drag and drop </span> 
                                                        files here <br /> or 
                                                        <a href="#" @click.prevent="" id="" class="text-blue-600 hover:underline">select a file</a> 
                                                        from your computer
                                                    </p>
                                                    <p class="pointer-none text-gray-500" v-else>
                                                        <span class="text-sm">
                                                            ({{postData.image.length}}) Files Added <br>
                                                        </span> <br />
                                                        <span class="text-blue-600 grid grid-flow-col border-2 border-gray-100"
                                                         v-for="(imag, img) in postData.image" :key="img" :title="imag.name">
                                                            <img class="w-16 h-16 p-2" v-bind:ref="'file' +parseInt(img)" v-if="imag.type == 'image/jpeg' || imag.type == 'image/png'"/>
                                                            <p class="fas fa-file text-2xl p-2" v-else></p>
                                                            <span class="grid grid-flow-row p-2">
                                                                <i>{{imag.name}}</i>
                                                                <i>({{imag.type}})</i>
                                                            </span>
                                                            <a href="#" class="fas fa-close text-red-600 p-2" @click.prevent="removeImage(img)"></a>
                                                        </span> <br />
                                                    </p>
                                                </div>
                                                <input type="file" class="hidden" multiple v-on:change="getImage">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-6">
                                    <label class="text-sm font-bold w-full h-8 text-gray-500 tracking-wide">Details</label>
                                    <textarea v-model="postData.details" class="text-base border p-4 w-full h-32 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" placeholder="More Details"></textarea>
                                </div>
                                <div>
                                    <a href="#" @click.prevent="createPost" class="my-5 w-full flex justify-center bg-green-500 text-gray-100 p-4  rounded-full tracking-wide
                                        font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                                        Post
                                    </a>
                                </div>
                            </form>
                            <i class="hidden">
                                {{postData.user_id = currentUser.id}}
                                {{postData.user_category = currentUser.user_type}}
                            </i>
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
    import axios from 'axios';
    import Button from '../../../../../vendor/laravel/breeze/stubs/inertia-vue/resources/js/Components/Button.vue';
    export default {
      name: "create_post",
      components: {
          NavbarComponent,
          Button
      },
      data() {
          return {
            postData: new MyFormData({
              user_id: '',
              user_category: '',
              title: '',
              details: '',
              link: '',
              name: {},
              image: [],
              set_file: false
            }),
            reloadkey: 0,
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
        getImage(e) {
            let file = e.target.files;
            for(let i = 0; i < file.length; i++)
            {
                if(this.postData.image.length < 4){
                    this.postData.image.push(file[i]);

                    this.postData.set_file = true;
                }else{
                    this.errors = {name: ['Maximum Number of Files to be Uploaded is 4']};
                }
            }
            for(let i = 0; i < this.postData.image.length; i++)
            {
                if(this.postData.image[i].type == 'image/jpeg' || this.postData.image[i].type == 'image/png'){
                    let reader = new FileReader();
                    reader.addEventListener('load', function(){
                        this.$refs['file' +parseInt( i )][0].src = reader.result;
                    }.bind(this), false);

                    reader.readAsDataURL(this.postData.image[i]);
                }else{

                }
            }
        },
        removeImage(i) {
            var file = this.postData.image;
            var index = file.indexOf(file[i]);

            file.splice(index, 1);

            if (file.length <= 0) {
                this.postData.set_file = false;
            }
            this.reloadkey++;
        },
        getCategory() { 
          axios.get('api/create_post').then((response) => {
            this.categories = response.data.post_categories
          }).catch((errors) => {
            console.log(errors)
          });
        },
        createPost() { 
          this.postData.post('api/createPost')
            .catch(errors => {
                throw errors;
            })
            .then((response) => {
                this.$router.push('post')
            });
        },
        createCategory() { 
          axios.post('api/createCategory', this.categoryData).then((response) => {
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
        if(this.token != null){
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
            axios.get('api/user').then((response) => {
                this.currentUser = response.data
            }).catch((errors) => {
                //console.log(errors)
            })
        }
      }
    };
</script>