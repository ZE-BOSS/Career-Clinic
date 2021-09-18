<template>   
    <div class="chat-footer flex-none">
        <div class="flex flex-row items-center p-4">
            <div class="relative flex flex-wrap">
                <label>
                    <input v-model="commentData.reply" class="rounded px-72 py-2 w-full border border-gray-300 focus:border-gray-700 bg-gray-100 focus:bg-gray-100 focus:outline-none text-black-900 focus:shadow-md transition duration-300 ease-in" type="text" placeholder="Add Comment">
                </label>
                <div class="border-gray-300 focus:border-gray-700 px-2 py-2">
                    <a href="#" @click.prevent="createComment" class="fas fa-send text-2xl"></a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
      name: "create-comment",
      props:['user_id', 'user_category', 'question_id'],
      data() {
          return {
            commentData: {
              user_id: this.user_id,
              user_category: this.user_category,
              question_id: this.question_id,
              reply: "",
              link: "none"
            },
          }
      },
      methods: {
        createComment() { 
          axios.post('api/createComment', this.commentData).then((response) => {
            this.commentData.reply = ''
          }).catch((errors) => {
            console.log(errors)
          });
        },
      },
    };
</script>