<template>
   <div>
       <v-row v-for="(feed,i) in blog" :key="feed.author">
           <v-col>
               <v-card
                   color="basil"
               >
                   <v-card-title class="text-h5">
                       {{feed.title}}
                       <v-spacer></v-spacer>
                       <v-btn
                           color="red"
                           text
                           v-if="feed.user.id===user.id"
                           @click="deletePost(feed,i)"
                       >
                           Delete
                       </v-btn>
                       <v-btn
                           color="orange"
                           text
                           v-if="feed.user.id===user.id"
                           @click="editPost(feed,i)"
                       >
                           Edit
                       </v-btn>
                   </v-card-title>

                   <v-card-subtitle>{{feed.user.name}} &nbsp ({{feed.created_at}}) </v-card-subtitle>
                   <v-card-text>
                       {{feed.description}}
                   </v-card-text>

                   <v-card-actions>
                       <v-btn text @click="showFeed(feed)">
                           Read more
                       </v-btn>
                   </v-card-actions>
               </v-card>
           </v-col>
       </v-row>
       <v-btn
           class="ma-2"
           outlined
           color="indigo"
           @click="new_appreciation_dialog=true"
       >
           Add new appreciation
       </v-btn>
       <!-- DIALOG BOX--------->
       <v-dialog
           v-model="dialog"
           width="80vw"
       >
           <v-card>
               <v-card-title class="text-h5 grey lighten-2">
                  {{blog_title}}
               </v-card-title>

               <v-card-text>
                   <medical_appreciation_details :feed="feed" />
               </v-card-text>

               <v-divider></v-divider>
           </v-card>
       </v-dialog>
       <v-dialog
           v-model="new_appreciation_dialog"
           width="80vw"
       >
           <v-card>
               <v-card-title class="text-h5 grey lighten-2">
                    <v-text-field label="title" v-model="formData.title"/>
               </v-card-title>

               <v-card-text>
                  <v-textarea label="enter the description here" v-model="formData.description"/>
               </v-card-text>

               <v-divider></v-divider>
               <v-card-actions>
                   <v-btn
                       color="deep-purple lighten-2"
                       text
                       @click="post"
                   >
                       Post
                   </v-btn>
               </v-card-actions>
           </v-card>
       </v-dialog>
   </div>
</template>
<script>
import Medical_appreciation_details from "./medical_appreciation_details";
export default {
    name: "medical_appreciation",
    props:['maternity_admission_id'],
    components: {Medical_appreciation_details},
    data() {
        return {
            blog:[
                // {id:1,author:'Andry',title:'risk of bleeding',description:' the patient shows a bleeding symptome',created_at:'2021-june-21'},
                // {id:2,author:'Tanja',title:'labwork',description:' to be dropped to the district',created_at:'2021-june-25'},
                // {id:3,author:'Sitraka',title:'decision about use of amox',description:' wait for tanja decision',created_at:'2021-july-11'}
            ],
            dialog:false,
            new_appreciation_dialog:false,
            feed:'',
            blog_title:'',
            formData:{
                title:'',
                description:'',
                status:'new'
            },
            user:''
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            this.user=window.auth.user
           await axios.get(`/api/maternity/medical_appreciation/${this.maternity_admission_id}`).then(response=>{
               this.blog=response.data
           })
        },
        showFeed(feed){
            this.dialog=true
            this.feed=feed
            this.blog_title=feed.title
        },
        async post(){
            this.formData.maternity_admission_id= this.maternity_admission_id
            this.formData.user_id=window.auth.user.id
            if(this.formData.status==='new'){
                await axios.post('/api/maternity/medical_appreciation ',this.formData)
                    .then(
                        response=>{
                            this.blog=response.data
                            this.new_appreciation_dialog=false
                            this.reset_form()
                        }
                    )
            }else{
                await axios.put(`/api/maternity/medical_appreciation/${this.formData.id}`,this.formData)
                    .then(
                        response=>{
                            this.blog=response.data
                            this.new_appreciation_dialog=false
                            this.reset_form()
                        }
                    )
            }


        },
        async deletePost(feed,i){
            await axios.delete(`/api/maternity/medical_appreciation/${feed.id}`)
            this.blog.splice(i,1)
        },
        async editPost(feed,i){
            this.new_appreciation_dialog=true
            this.formData.title=feed.title
            this.formData.description=feed.description
            this.formData.status='edit'
            this.formData.id= feed.id

        },
        reset_form(){
            this.formData={
                title:'',
                description:''
            }
        }
    }

}
</script>

<style scoped>

</style>
