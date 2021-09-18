<template>
  <div>
    <div class="relative bg-blueGray-100">
      <navbar-component></navbar-component>
      <!-- Header -->
      <div class="relative bg-white-600 md:ml-56 md:pt-8 pb-8 pt-12">
        <div class="px-4 md:px-10 mx-auto w-full">
          <div>
            <div class="relative">
              <a href="create_post" class="rounded bg-green-500 p-2 text-white ml-4 w-auto">
                Ask a Question
              </a><br><br>
            </div>
            <div class="flex flex-wrap mt-10" v-for="(question, index) in questions" :key="'index'+index">
              <div class="w-full lg:w-10/12 xl:w-10/12 px-4">
                <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg border-4 border-gray-100">
                  <div class="flex-auto p-4">
                    <div class="flex flex-wrap">
                      <div class="relative w-auto pl-0 flex-initial">
                        <div class="text-white text-center border-none inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                          <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="/career-clinic/public/assets/img/team-1-800x800.jpg"/>
                        </div>
                      </div>
                      <div class="relative w-auto pl-5 flex-initial"></div>
                      <div class="relative w-full pr-4 max-w-full flex-grow flex-1" v-if="currentUser.id == question.user_id && currentUser.user_type == question.user_category">
                        <span class="font-normal text-lg text-blueGray-700">
                          {{currentUser.first_name+' '+currentUser.middle_name+' '+currentUser.last_name}}
                        </span>
                        <h5 class="text-blueGray-200 uppercase font-italic text-xs">
                          @{{currentUser.user_name}} <i class="fas fa-clock"></i> {{moment(question.created_at).fromNow()}}
                        </h5>
                      </div>
                      <div class="relative w-full pr-4 max-w-full flex-grow flex-1" v-else>
                        <div v-if="question.user_category == 'admin'">
                          <div v-for="(admin, ad) in admins" :key="'ads'+ad">
                            <div v-if="admin.id == question.user_id && admin.user_type == question.user_category">
                              <span class="font-normal text-xl text-blueGray-700">
                                {{admin.first_name+' '+admin.middle_name+' '+admin.last_name}}
                              </span>
                              <h5 class="text-blueGray-200 uppercase font-italic text-xs">
                                @{{admin.user_name}} <i class="fas fa-clock"></i> {{moment(question.created_at).fromNow()}}
                              </h5>
                            </div>
                          </div>
                        </div>
                        <div v-else-if="question.user_category == 'user'">
                          <div v-for="(user, us) in users" :key="'use'+us">
                            <div v-if="user.id == question.user_id && user.user_type == question.user_category">
                              <span class="font-normal text-xl text-blueGray-700">
                                {{user.first_name+' '+user.middle_name+' '+user.last_name}}
                              </span>
                              <h5 class="text-blueGray-200 uppercase font-italic text-xs">
                                @{{user.user_name}} <i class="fas fa-clock"></i> {{moment(question.created_at).fromNow()}}
                              </h5>
                            </div>
                          </div>
                        </div>
                        <div v-else>
                          <span class="font-normal text-xl text-red-700">
                            Unknown
                          </span>
                          <h5 class="text-red-200 uppercase font-italic text-xs">
                            @Unknown <i class="fas fa-clock"></i> {{moment(question.created_at).fromNow()}}
                          </h5>
                        </div>
                      </div>
                    </div>
                    <div class="flex flex-row">
                      <i class="relative" v-for="(question_img, qimg) in question_imgs" :key="'qimg'+qimg">
                          <i class="border-none items-center justify-center w-full h-96 shadow-lg pt-10" v-if="question_img.question_id == question.id">
                            <a href="#" @click="showImage(question_img.id)" class="w-full h-full" v-if="question_img.name == 'jpeg' || question_img.name == 'jpg' || question_img.name == 'png' || question_img.name == 'JPEG' || question_img.name == 'JPG' || question_img.name == 'PNG'">
                              <img class="h-full w-full p-1" :src="'public'+question_img.image" :alt="question_img.name">
                            </a>
                            <i v-else-if="question_img.name == 'pdf' || question_img.name == 'txt' || question_img.name == 'docx' || question_img.name == 'PDF' || question_img.name == 'TXT' || question_img.name == 'DOCX'">
                              <i class="fas fa-file-pdf-o" aria-hidden="true"></i>
                              <i> {{question_img.image}}</i>
                            </i>
                            <i v-else-if="question_img.name == 'mp4' || question_img.name == 'mkv' || question_img.name == 'webm' || question_img.name == 'MP4' || question_img.name == 'MKV' || question_img.name == 'WEBM'">
                              <i class="fas fa-file-video-o" aria-hidden="true"></i>
                              <i> {{question_img.image}}</i>
                            </i>
                            <i v-else>
                              <i class="fas fa-file-archive-o" aria-hidden="true"></i>
                              <i> {{question_img.image}}</i>
                            </i>
                          </i>
                        </i>
                    </div>
                    <p class="text-blueGray-400 mt-4 font-semibold px-16 text-xl">
                      <span class="text-emerald-500 mr-2 ">{{ question.title }}</span>
                    </p>
                    <p class="text-sm text-blueGray-400 px-20 mt-4">
                      <span class="whitespace-nowrap">
                        {{ question.details }}
                      </span>
                    </p>
                    <br/><br/>
                    <div class="flex flex-wrap">
                        <i class="hidden">{{assos = 0}}</i>
                        <i class="hidden" v-for="(question_a, qaid) in question_associations" :key="'qaid'+qaid">
                            <i v-if="question_a.question_id == question.id">
                              <i v-if="question_a.user_id == currentUser.id && question_a.user_category == currentUser.user_type">
                                
                              </i>
                              {{assos++}}
                            </i>
                        </i>
                        <a class="relative w-full pl-20 max-w-full flex-grow flex-1">
                            <h5 class="text-gray-500 uppercase font-italic text-xs" v-if="assos <= 0"><br></h5>
                            <h5 v-else class="text-gray-500 uppercase font-italic text-xs">
                              {{assos}} 
                            </h5>
                            <span class="font-normal text-xl text-blue-700">
                              <a href="#" @click.prevent="association(question.id)" class="fas fa-users"></a>
                            </span>
                        </a>
                        <i class="hidden">{{com = 0}}</i>
                        <i class="hidden" v-for="(question_r, qid) in question_replies" :key="'qid'+qid">
                            <i v-if="question_r.question_id == question.id">
                                {{com++}}
                            </i>
                        </i>
                        <a class="relative w-auto flex-grow">
                            <h5 class="text-gray-500 uppercase font-italic text-xs" v-if="com <= 0"><br></h5>
                            <h5 v-else class="text-gray-500 uppercase font-italic text-xs">
                              {{com}}
                            </h5>
                            <span class="font-normal text-xl text-blueGray-700">
                              <a href="#" @click.prevent="comment(question.id, commentShow.frame)" class="fas fa-comments"></a>
                            </span>
                        </a>
                        <i class="hidden">{{shar = 0}}</i>
                        <i class="hidden" v-for="(question_s, qsid) in question_shares" :key="'qsid'+qsid">
                            <i v-if="question_s.question_id == question.id">
                                {{shar++}}
                            </i>
                        </i>
                        <a class="relative w-auto pr-20 flex-initial">
                            <h5 class="text-gray-500 uppercase font-italic text-xs" v-if="shar <= 0"><br></h5>
                            <h5 v-else class="text-gray-500 uppercase font-italic text-xs">
                              {{shar}}
                            </h5>
                            <span class="font-normal text-xl text-blueGray-700">
                            <a href="#" @click.prevent="share(question.id)" class="fas fa-share"></a>
                            </span>
                        </a>
                        <i class="hidden">
                          {{associationData.question_id = question.id}}
                          {{shareData.question_id = question.id}}
                        </i>
                    </div>
                  </div>
                </div>
              </div>
              <div v-for="(user, adm) in users" :key="'adm'+adm">
                <div v-if="user.id == currentUser.id && user.user_type == currentUser.user_type">
                  <div v-if="question.id == commentShow.frame" v-bind:class="{ hidden: !commentShow.display, block: commentShow.display }">
                    <add-comment :user_id="user.id" :user_category="user.user_type" :question_id="question.id"></add-comment>
                    <comment-component :user_id="user.id" :user_category="user.user_type" :question_post_id="question.user_id" :question_post_cat="question.user_category" :question_id="question.id"></comment-component>
                  </div>
                  <div v-else v-bind:class="{ hidden: !commentShow.diplay }">
                    <add-comment :user_id="user.id" :user_category="user.user_type" :question_id="question.id"></add-comment>
                    <comment-component :user_id="user.id" :user_category="user.user_type" :question_post_id="question.user_id" :question_post_cat="question.user_category" :question_id="question.id"></comment-component>
                  </div>
                </div>
              </div>
              <div v-if="currentUser.id == null">
                <div v-if="question.id == commentShow.frame" v-bind:class="{ hidden: !commentShow.display, block: commentShow.display }">
                  <div class="px-64 py-2 flex flex-row items-center p-4 ml-6 w-full h-10 border-l-4 border-red-600 border-t-0 border-r-0 border-b-0 bg-gray-300">
                    <i class="text-black p-4">Login to comment on this post</i>
                  </div>
                  <comment-component :user_id="0" :user_category="'Unknown'" :question_post_id="question.user_id" :question_post_cat="question.user_category" :question_id="question.id"></comment-component>
                </div>
                <div v-else v-bind:class="{ hidden: !commentShow.diplay }">
                  <div class="px-72 py-2 flex flex-row items-center p-4 ml-6 w-full h-10 border-l-4 border-red-600 border-t-0 border-r-0 border-b-0 bg-gray-300">
                    <i class="text-black p-4"> Login to comment on this post</i>
                  </div>
                  <comment-component :user_id="0" :user_category="'Unknown'" :question_post_id="question.user_id" :question_post_cat="question.user_category" :question_id="question.id"></comment-component>
                </div>
              </div>
              <i class="hidden">
                {{associationData.user_id = currentUser.id}}
                {{associationData.user_category = currentUser.user_type}}
                {{shareData.user_id = currentUser.id}}
                {{shareData.user_category = currentUser.user_type}}
              </i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
    import NavbarComponent from "../components/Navbar.vue";
    import commentComponent from "./comment.vue";
    import addComment from './addComment.vue';
    import axios from 'axios';
    import Button from '../../../../../vendor/laravel/breeze/stubs/inertia-vue/resources/js/Components/Button.vue';
    export default {
      name: "post",
      components: {
          NavbarComponent,
          commentComponent,
          addComment,
          Button
      },
      data() {
          return {
            associationData: {
              user_id: '',
              user_category: '',
              question_id: ''
            },
            shareData: {
              user_id: '',
              user_category: '',
              question_id: '',
              platform: "Web",
              shared_to: "Copied"
            },
            assos: 0,
            com: 0,
            shar: 0,
            commentShow: {display: false},
            date: new Date().getFullYear(),
            questions: {},
            users: {},
            admins: {},
            question_imgs: {},
            question_associations: {},
            question_replies: {},
            question_shares: {},
            question_reply_imgs: {},
            question_reply_associations: {},
            question_reply_comments: {},
            question_user_feedbacks: {},
            question_reply_comment_imgs: {},
            currentUser: {},
            token: localStorage.getItem('token')
          }
      },
      methods: {
        getPost() { 
          axios.get('api/post').then((response) => {
            this.questions = response.data.question_post_ccs
            this.admins = response.data.admin_ccs
            this.users = response.data.user_ccs
            this.question_imgs = response.data.question_img_ccs
            this.question_associations = response.data.question_association_ccs
            this.question_replies = response.data.question_reply_ccs
            this.question_shares = response.data.question_share_ccs
            this.question_reply_imgs = response.data.question_reply_img_ccs
            this.question_reply_associations = response.data.question_reply_association_ccs
            this.question_reply_comments = response.data.question_reply_comment_ccs
            this.question_user_feedbacks = response.data.question_user_feedback_ccs
            this.question_reply_comment_imgs = response.data.question_reply_comment_img_ccs
          }).catch((errors) => {
            console.log(errors)
          });
        },
        association(id) { 
          axios.post('api/createAssociation', this.associationData).then((response) => {
            this.getPost()
            //this.commentData.reply = ''
          }).catch((errors) => {
            console.log(errors)
          });
        },
        share(id) { 
          axios.post('api/createShare', this.shareData).then((response) => {
            this.getPost()
            //this.commentData.reply = ''
          }).catch((errors) => {
            console.log(errors)
          });
        },
        showImage(id) { 
          
        },
        comment(id, frame) { 
          if (this.commentShow.display == true) {
            this.commentShow = {frame: id, display: false};
            if (frame == id) {
                
            } else {
                this.commentShow = {frame: id, display: true};
            }
          } else {
            this.commentShow = {frame: id, display: true};
          }
        },
      },
      mounted() {
        this.getPost()
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