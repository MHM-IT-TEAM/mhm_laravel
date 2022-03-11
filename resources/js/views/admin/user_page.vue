<template>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <td v-for="page in list">{{page.description}}</td>
            </tr>
            <tr>
                <td v-for="page in page_checked">
                    <input type="checkbox" v-model="page.checked" @change="update_db(page)"/>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    name: "user_page",
    props:['user_page','user_id'],
    data(){
        return{
            list:[],
        }
    },
    created(){
        this.init()
    },
    methods:{
        init(){
            axios.get('/api/v1/admin/pages').then(response=>{
                this.list=response.data
                this.list.forEach(list=>list.checked=false)
            })
        },
        update_db(page){
            page.user_id= this.user_id

            axios.post('/api/v1/admin/update_user_page',page)
        }
    },
    computed:{
        page_checked(){
            this.list.forEach(list=>{
                list.checked=false
                this.user_page.forEach(page=>{
                    if(page.description===list.description) list.checked=true
                })
            })
            return this.list
        }
    }
}
</script>

<style scoped>

</style>
