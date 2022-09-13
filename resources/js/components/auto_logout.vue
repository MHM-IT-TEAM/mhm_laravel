<template>
<div class="container">
</div>
</template>

<script>
export default {
    name: "auto_logout",
    data(){
        return{
            events:['click','mousemove','mousedown','scroll','keypress','load'],
            warning_timer:null,
            logout_timer:''
        }
    },
    mounted(){
        this.events.forEach(e=>{
            window.addEventListener(e,this.resetTimer)
        },this)
        this.setTimer()
    },
    methods:{
        setTimer(){
            this.warning_timer=setTimeout(this.log_user_out,15*1000*60)
        },
        resetTimer(){
            clearTimeout(this.warning_timer)
            this.setTimer()
        },
        async log_user_out(){
            alert('You have been inactive since 5 minutes')
            await axios.post("/logout").then((resp) => console.log(resp));
            window.location.href = "/login";
        }
    }
}
</script>

<style scoped>

</style>
