<template>
<div class="wrapper">
    <div class="header">
        <site-header/>
    </div>
    <div class="content">
        <router-view v-slot="{ Component }">
            <transition name="fade" mode="out-in">
                <component :is="Component" :key="$route.path" />
            </transition>
        </router-view>
    </div>
    <div class="footer">
        <siteFooter/>
    </div>
</div>
</template>

<script>
import {mapActions,mapGetters} from 'vuex'
import SiteHeader from "./partials/siteHeader";
import SiteFooter from "./partials/siteFooter";
export default {
    name: "inventory_layout_base",
    components: {SiteHeader,SiteFooter},
    async created(){
         this.bootstrap_app()
    },
    methods:{
        ...mapActions(['bootstrap_app']),
    },
    computed:{

    }
}
</script>

<style scoped>
.wrapper{
    position:relative;
    display:grid;
    grid-template-columns: repeat(12,1fr);
    grid-template-rows: 40px auto 40px;
    grid-auto-rows: 100px;
    grid-gap: 1px;
    height:100vh;
}
/*.sideBar{*/
/*    grid-row: 2/3;*/
/*    border-right: 1px solid lightgrey;*/
/*    grid-column: 1/2;*/
/*    min-width: 170px;*/
/*}*/
.content{
    grid-column: 1 /-1;
    border-bottom: 1px solid lightgrey;
    padding:50px;
}
.footer{
    grid-column: 1 /-1;
    /*position:absolute;*/
    /*bottom: 0;*/
    /*border: 1px solid #6f42c1 ;*/
    width:100%;
    height:35px;
    text-align: center;
}
@media screen and (max-width: 768px){
    .sideBar{
        display: none;
    }
    .content{
        grid-column: 1 /-1;
    }
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
