<template>
<div>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-purple fixed-top">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">MHM</a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item "><router-link :to="{name:'inventory_dashboard'}" class="nav-link" >Dashboard</router-link></li>
                        <li class="nav-item "><router-link :to="{name:'item_index'}" class="nav-link" >Items</router-link></li>
                        <li class="nav-item "><router-link :to="{name:'item_authorization'}" class="nav-link" >Authorization</router-link></li>
                        <li class="nav-item "><router-link :to="{name:'in_list'}" class="nav-link" >In</router-link></li>
                        <li class="nav-item "><router-link :to="{name:'out_list'}" class="nav-link" >Out</router-link></li>
                        <li class="nav-item "><router-link :to="{name:'cart_list'}" class="nav-link" >Shopping List</router-link></li>
                    </ul>
                    <ul class="navbar-nav">
<!--                        <li class="nav-item dropdown dropstart">-->
<!--                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
<!--                               {{user.name}}-->
<!--                            </a>-->
<!--                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">-->
<!--                                <li><a class="dropdown-item" href="#"><button class="btn" @click="logout_user">Logout</button></a></li>-->
<!--                                <li><a class="dropdown-item" href="#">Change Password</a></li>-->
<!--                            </ul>-->
<!--                        </li>-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{user.name.toUpperCase()}}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#"><button class="btn" @click="logout_user">Logout</button></a>
                                <a class="dropdown-item" href="#">Change Password</a>
                            </div>
                        </li>
                    </ul>
<!--                    <form class="d-flex">-->
<!--                        <input class="form-control me-2" type="search" id="search_input" placeholder="Search" aria-label="Search">-->
<!--                        <button class="btn btn-outline  text-white border-white" type="submit">Search</button>-->
<!--                    </form>-->
                </div>
            </div>
        </nav>
    </header>
</div>
</template>

<script>
import {mapGetters,mapActions} from "vuex";

export default {
    name: "siteHeader",
    data(){
        return{
          user:{
              id:'',
              name:''
          }
        }
    },
    created(){
        this.user= window.auth.user
    },
    methods:{
        ...mapActions('auth',['logout']),
        async logout_user(){
            await this.logout()
            .then(this.$router.push({name:'welcome'}))
        }
    },

}
</script>

<style scoped>
nav{
    padding: 2px;
    background-color: mediumslateblue;
    color:white;
    display: flex;
}
nav ul{
    list-style: none;
}
button:hover{
    background-color: white;
    color:mediumslateblue !important;
}
.navbar-brand{
    font-weight: bold;
}
@media screen and(max-width: 768px){
    .form-control{
        display:none !important;
    }
}
</style>
