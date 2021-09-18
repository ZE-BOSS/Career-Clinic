<template>
    <div class="mt-0 pt-0">
        <div v-for="(question_reply, qr) in question_replies" :key="'qr'+qr" class="mt-2 pt-0">
            <div v-if="question_reply.question_id == question_id" class="relative border-t-2 border-gray-250 ml-10 w-11/12 bg-white border mt-0 shadow-sm px-16 py-4 rounded-lg">
                <div class="flex items-center" v-if="currentUser.id == question_reply.user_id && currentUser.user_type == question_reply.user_category">
                    <div class="text-white text-center border-none inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                        <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="/assets/img/team-1-800x800.jpg"/>
                    </div>
                    <div class="ml-2">
                        <span class="font-normal text-lg text-blueGray-700">
                        {{currentUser.first_name+' '+currentUser.middle_name+' '+currentUser.last_name}}
                        </span>
                        <h5 class="text-blueGray-200 uppercase font-italic text-xs">
                        @{{currentUser.user_name}} <i class="fas fa-clock"></i> {{moment(question_reply.created_at).fromNow()}}
                        </h5>
                    </div>
                    <div class="relative w-auto pl-5 flex-initial"></div>
                </div>
                <div v-else>
                    <div v-if="question_reply.user_category == 'admin'">
                        <div v-for="(admin, ad) in admins" :key="'ad'+ad">
                            <div class="flex items-center" v-if="admin.id == question_reply.user_id && admin.user_type == question_reply.user_category">
                                <div class="text-white text-center border-none inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                                    <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="/assets/img/team-1-800x800.jpg"/>
                                </div>
                                <div class="ml-2">
                                    <span class="font-normal text-lg text-blueGray-700">
                                        {{admin.first_name+' '+admin.middle_name+' '+admin.last_name}}
                                    </span>
                                    <h5 class="text-blueGray-200 uppercase font-italic text-xs">
                                        @{{admin.user_name}} <i class="fas fa-clock"></i> {{moment(question_reply.created_at).fromNow()}}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div v-else-if="question_reply.user_category == 'user'">
                        <div v-for="(user, us) in users" :key="'us'+us">
                            <div class="flex items-center" v-if="user.id == question_reply.user_id && user.user_type == question_reply.user_category">
                                <div class="text-white text-center border-none inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                                    <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" src="/assets/img/team-1-800x800.jpg"/>
                                </div>
                                <div class="ml-2">
                                    <span class="font-normal text-xl text-blueGray-700">
                                        {{user.first_name+' '+user.middle_name+' '+user.last_name}}
                                    </span>
                                    <h5 class="text-blueGray-200 uppercase font-italic text-xs">
                                        @{{user.user_name}} <i class="fas fa-clock"></i> {{moment(question_reply.created_at).fromNow()}}
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
                            @Unknown <i class="fas fa-clock"></i> {{moment(question_reply.created_at).fromNow()}}
                          </h5>
                        </div>
                    </div>
                </div>
                <p class="text-gray-800 text-sm mx-16 mt-2 leading-normal md:leading-relaxed">{{question_reply.reply}}</p>
                <br/>
                <div class="flex flex-wrap text-gray-500">
                    <a class="relative w-3 pl-20 max-w-full flex-grow flex-1">
                        <h6 class="text-gray-500 uppercase font-italic text-xs" v-if="question_reply_associations.length <= 0"><br></h6>
                        <h6 class="text-gray-500 uppercase font-italic text-xs" v-else>{{question_reply_associations.length}}</h6>
                        <span class="font-normal text-lg text-blueGray-700">
                        <a href="" @click.prevent="replyAssociation" class="fas fa-users"></a>
                        </span>
                    </a>
                    <i class="hidden">{{com_i = 0}}</i>
                    <i class="hidden" v-for="(question_r_c, qrid) in question_reply_comments" :key="'qrid'+qrid">
                        <i v-if="question_r_c.reply_id == question_reply.id">
                            {{com_i++}}
                        </i>
                    </i>
                    <a class="relative w-6 flex-grow">
                        <h6 class="text-gray-500 uppercase font-italic text-xs" v-if="com_i <= 0"><br></h6>
                        <h6 v-else class="text-gray-500 uppercase font-italic text-xs">
                            {{com_i}}
                        </h6>
                        <span class="font-normal text-lg text-blueGray-700">
                        <a href="" @click.prevent="replyComment(question_reply.id, commentReplyShow.frame)" class="fas fa-comments"></a>
                        </span>
                    </a>
                    <a v-if="question_post_id == currentUser.id && question_post_cat == currentUser.user_type" class="relative w-auto pr-20 flex-initial">
                        <h6 class="text-gray-500 uppercase font-italic text-xs"><br></h6>
                        <span class="font-normal text-lg text-blueGray-700">
                        <a href="" @click.prevent="userFeedback" class="fas fa-check-circle"></a>
                        </span>
                    </a>
                    <a v-else class="relative w-auto pr-20 flex-initial">
                        <h6 class="text-gray-500 uppercase font-italic text-xs" v-if="question_reply_ratings.length <= 0"><br></h6>
                        <h6 v-else class="text-gray-500 uppercase font-italic text-xs">{{question_reply_ratings.length}}</h6>
                        <span class="font-normal text-lg text-blueGray-700">
                        <a href="" @click.prevent="userRating" class="fas fa-star"></a>
                        </span>
                    </a>
                </div>
            </div>
            <div v-for="(user, adm) in users" :key="'adm'+adm">
                <div v-if="user.id == currentUser.id && user.user_type == currentUser.user_type">
                    <div v-if="question_reply.id == commentReplyShow.frame" v-bind:class="{ hidden: !commentReplyShow.display, block: commentReplyShow.display }">
                        <add-reply-comment-component :user_id="user.id" :user_category="user.user_type" :reply_id="question_reply.id"></add-reply-comment-component>
                        <reply-comment-component :user_id="user.id" :user_category="user.user_type" :reply_id="question_reply.id"></reply-comment-component>
                    </div>
                    <div v-else v-bind:class="{ hidden: !commentReplyShow.diplay }">
                        <add-reply-comment-component :user_id="user.id" :user_category="user.user_type" :reply_id="question_reply.id"></add-reply-comment-component>
                        <reply-comment-component :user_id="user.id" :user_category="user.user_type" :reply_id="question_reply.id"></reply-comment-component>
                    </div>
                </div>
            </div>
            <div v-if="currentUser.id == null">
                <div v-if="question_reply.id == commentReplyShow.frame" v-bind:class="{ hidden: !commentReplyShow.display, block: commentReplyShow.display }">
                    <div class="px-64 py-2 flex flex-row items-center p-4 ml-6 w-full h-10 border-l-4 border-red-600 border-t-0 border-r-0 border-b-0 bg-gray-300">
                        <i class="text-black p-4">Login to comment on this post</i>
                    </div>
                    <reply-comment-component :user_id="0" :user_category="'Unknown'" :reply_id="question_reply.id"></reply-comment-component>
                </div>
                <div v-else v-bind:class="{ hidden: !commentReplyShow.diplay }">
                    <div class="px-72 py-2 flex flex-row items-center p-4 ml-6 w-full h-10 border-l-4 border-red-600 border-t-0 border-r-0 border-b-0 bg-gray-300">
                        <i class="text-black p-4"> Login to comment on this post</i>
                    </div>
                    <reply-comment-component :user_id="0" :user_category="'Unknown'" :reply_id="question_reply.id"></reply-comment-component>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import replyCommentComponent from "./replyComment.vue";
    import addReplyCommentComponent from "./addReplyComment.vue";
    import axios from 'axios';
    export default {
      name: "comment",
      components: {
          replyCommentComponent,
          addReplyCommentComponent
      },
      props:['user_id', 'user_category', 'question_id', 'question_post_id', 'question_post_cat'],
      data() {
          return {
            com_i: 0,
            commentReplyShow: {display: false},
            date: new Date().getFullYear(),
            questions: {},
            users: {},
            admins: {},
            question_replies: {},
            question_reply_imgs: {},
            question_reply_associations: {},
            question_reply_comments: {},
            question_reply_ratings: {},
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
            this.question_replies = response.data.question_reply_ccs
            this.question_reply_imgs = response.data.question_reply_img_ccs
            this.question_reply_associations = response.data.question_reply_association_ccs
            this.question_reply_comments = response.data.question_reply_comment_ccs
            this.question_reply_ratings = response.data.question_reply_ratings
            this.question_user_feedbacks = response.data.question_user_feedback_ccs
            this.question_reply_comment_imgs = response.data.question_reply_comment_img_ccs
          }).catch((errors) => {
            console.log(errors)
          });
        },
        replyComment(id, frame) { 
          if (this.commentReplyShow.display == true) {
            this.commentReplyShow = {frame: id, display: false};
            if (frame == id) {
                
            } else {
                this.commentReplyShow = {frame: id, display: true};
            }
          } else {
            this.commentReplyShow = {frame: id, display: true};
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