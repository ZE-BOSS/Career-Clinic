<template>
    <div class="mt-0 pt-0">
        <div v-for="(question_reply_comment, qr) in question_reply_comments" :key="qr" class="mt-2 pt-0">
            <div v-if="question_reply_comment.reply_id == reply_id" class="relative border-t-2 border-gray-250 ml-20 lg:w-10/12 xl:w-8/12 bg-white border shadow-sm px-4 py-4 rounded-lg w-full">
                <div class="flex items-center" v-if="currentUser.id == question_reply_comment.user_id && currentUser.user_type == question_reply_comment.user_category">
                    <div class="text-white text-center border-none inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                        <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="/assets/img/team-1-800x800.jpg"/>
                    </div>
                    <div class="ml-2">
                        <span class="font-normal text-lg text-blueGray-700">
                        {{currentUser.first_name+' '+currentUser.middle_name+' '+currentUser.last_name}}
                        </span>
                        <h5 class="text-blueGray-200 uppercase font-italic text-xs">
                        @{{currentUser.user_name}} <i class="fas fa-clock"></i> {{moment(question_reply_comment.created_at).fromNow()}}
                        </h5>
                    </div>
                    <div class="relative w-auto pl-5 flex-initial"></div>
                </div>
                <div v-else>
                    <div v-if="question_reply_comment.user_category == 'admin'">
                        <div v-for="(admin, ad) in admins" :key="ad">
                            <div class="flex items-center" v-if="admin.id == question_reply_comment.user_id && admin.user_type == question_reply_comment.user_category">
                                <div class="text-white text-center border-none inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                                    <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="/assets/img/team-1-800x800.jpg"/>
                                </div>
                                <div class="ml-2">
                                    <span class="font-normal text-lg text-blueGray-700">
                                        {{admin.first_name+' '+admin.middle_name+' '+admin.last_name}}
                                    </span>
                                    <h5 class="text-blueGray-200 uppercase font-italic text-xs">
                                        @{{admin.user_name}} <i class="fas fa-clock"></i> {{moment(question_reply_comment.created_at).fromNow()}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div v-else-if="question_reply_comment.user_category == 'user'">
                        <div v-for="(user, us) in users" :key="us">
                            <div class="flex items-center" v-if="user.id == question_reply_comment.user_id && user.user_type == question_reply_comment.user_category">
                                <div class="text-white text-center border-none inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                                    <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="/assets/img/team-1-800x800.jpg"/>
                                </div>
                                <div class="ml-2">
                                    <span class="font-normal text-xl text-blueGray-700">
                                        {{user.first_name+' '+user.middle_name+' '+user.last_name}}
                                    </span>
                                    <h5 class="text-blueGray-200 uppercase font-italic text-xs">
                                        @{{user.user_name}} <i class="fas fa-clock"></i> {{moment(question_reply_comment.created_at).fromNow()}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="flex items-center" v-else>
                        <div class="text-white text-center border-none inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                            <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src=""/>
                        </div>
                        <div class="ml-2">
                            <span class="font-normal text-xl text-red-700">
                            Unknown
                          </span>
                          <h5 class="text-red-200 uppercase font-italic text-xs">
                            @Unknown <i class="fas fa-clock"></i> {{moment(question_reply_comment.created_at).fromNow()}}
                          </h5>
                        </div>
                    </div>
                </div>
                <p class="text-gray-800 text-sm mx-16 mt-2 leading-normal md:leading-relaxed">{{question_reply_comment.reply}}</p>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
      name: "post",
      props:['user_id', 'user_category', 'reply_id'],
      data() {
          return {
            date: new Date().getFullYear(),
            questions: {},
            users: {},
            admins: {},
            questions: {},
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
          axios.get('/career-clinic/api/post').then(response => {
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
      },
      mounted() {
        this.getPost()
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
        axios.get('/career-clinic/api/user').then((response) => {
            this.currentUser = response.data
        }).catch((errors) => {
            console.log(errors)
        })
      }
    };
</script>