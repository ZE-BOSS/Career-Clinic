<template>   
    <div class="chat-footer flex-none ml-8">
        <div class="flex flex-row items-center p-4">
            <div class="relative flex flex-wrap">
                <label>
                    <input v-model="commentReplyData.reply" class="rounded px-64 py-2 w-full border border-gray-300 focus:border-gray-700 bg-gray-100 focus:bg-gray-100 focus:outline-none text-black-900 focus:shadow-md transition duration-300 ease-in" type="text" placeholder="Add Comment">
                </label>
                <div class="border-gray-300 focus:border-gray-700 px-2 py-2">
                    <a href="#" @click.prevent="createReplyComment" class="fas fa-send text-2xl"></a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
      name: "create-comment",
      props:['user_id', 'user_category', 'reply_id'],
      data() {
          return {
            commentReplyData: {
              user_id: this.user_id,
              user_category: this.user_category,
              reply_id: this.reply_id,
              reply: "",
              link: "none"
            },
          }
      },
      methods: {
        createReplyComment() { 
          axios.post('/career-clinic/api/createReplyComment', this.commentReplyData).then((response) => {
            this.commentReplyData.reply = ''
          }).catch((errors) => {
            console.log(errors)
          });
        },
      },
    };
</script>