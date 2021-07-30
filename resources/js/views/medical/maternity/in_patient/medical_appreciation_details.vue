<template>
    <div>
        <v-card
            class="mx-auto mt-4"
            tile
        >
            <v-list dense>
                <v-subheader>REPORTS</v-subheader>
                <v-list-item-group
                    v-model="selectedItem"
                    color="primary"
                >
                    <v-list-item
                        v-for="(item, i) in comments"
                        :key="i"
                    >
                        <v-list-item-icon>
                            <strong>{{item.user.name}}</strong>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title v-text="item.comment"></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
                <v-textarea label="write your comment" v-model="formData.comment">
                </v-textarea>
                <button type="button" class="btn btn-sm btn-outline-info m-2" @click="post">post</button>
            </v-list>
        </v-card>
    </div>
</template>

<script>
export default {
    name: "medical_appreciation_details",
    props:['feed'],
    data(){
        return {
            selectedItem:1,
            comments:[
                // {id:1,author:'Andry',comment:' mila amboarina ilay izy fa tsy mitombina',created_at:'2021-june-21'},
                // {id:1,author:'Nosy',comment:' efa vita',created_at:'2021-june-21'},
            ],
            formData:{
                comment:'',
                author:'',
            }
        }
    },
    created(){
        this.init()
    },
    methods:{
        async init(){
            this.comments=this.feed.medical_appreciation_comments
        },
        async post(){
            this.formData.author= window.auth.user.name
            if(this.formData.comment !==''){
                this.formData.medical_appreciation_id= this.feed.id
                this.formData.user_id=window.auth.user.id
                await axios.post('/api/maternity/medical_appreciation_comment',this.formData).then(response=>{
                    this.comments.push(response.data)
                })
                //this.comments.push({...this.formData})
                this.formData.comment=''
            }
        }
    }
}
</script>

<style scoped>

</style>
