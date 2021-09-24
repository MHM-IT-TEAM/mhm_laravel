<template>
<div class="wrapper d-flex justify-content-center align-items-center ">
    <div class="card register">
        <div class="card-body">
            <h4 class="card-title text-center">Register</h4>
            <form class="form" @submit.prevent="submit">
                <div class="form-group">
                    <label>Id</label>
                    <input type="number" class="form-control "  v-model="formData.staff_id"/>
                </div>
                <div class="form-group mt-2">
                    <label>Username</label>
                    <input type="text" class="form-control"  v-model="formData.name"/>
                </div>
                <div class="form-group mt-2">
                    <label>Password</label>
                    <input type="password" class="form-control "  v-model="formData.password"/>
                </div>
                <div class="form-group mt-2">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control " v-model="formData.password_confirmation"/>
                    <span class="alert-danger" v-if="form_error.includes('password_confirmation') && formData.password_confirmation!==''">Password not matching</span>
                </div>
                <div class="form-group mt-2">
                    <label>Department</label>
                    <select class="form-control mt-2" v-model="formData.department">
                        <option value=""></option>
                        <option value="grace">Grace</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-4" :disabled="form_error.length>0">Submit</button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "register",
    data(){
        return{
            formData:{
                staff_id:'',
                name:'',
                password:'',
                password_confirmation:'',
                department:''
            },
            accessory:{
                form_valid:false
            }
        }
    },
    methods:{
        async submit(){
            axios.post('/api/register',this.formData).then(response=>{
                this.$router.push({name:'login'})
            })
        }
    },
    computed:{
        form_error(){
            let error=[]
            for (let i in this.formData){
                if(this.formData[i]==="") error.push(i)
            }
            if(this.formData.password!=="" && this.formData.password_confirmation!=="" && this.formData.password !== this.formData.password_confirmation) error.push('password_confirmation')
            return error
        },
        // check_pass(){
        //     if(this.formData.password!=="" && this.formData.password_confirmation!=="" && this.formData.password !== this.formData.password_confirmation)
        // }
    }
}
</script>

<style scoped>
.wrapper{
    height:100vh;
}
.register{
    width:500px;
    height:500px;
    margin: 0 auto;
    /*top:20vh;*/
}
</style>
