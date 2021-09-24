<template>
    <div class="container-fluid border-primary">
        <div class="navbar fixed-top">
            <ul class="navbar-nav d-grid gap-5 pt-5">
                <li class="nav-item "><router-link :to="{name:'dashboard'}" class="nav-link"><span class="fontaws"><font-awesome-icon icon="home"/></span>Dashboard</router-link></li>
<!--                <li class="nav-item "><a class="nav-link" href="#"><span class="fontaws"><font-awesome-icon icon="industry"/></span>Suppliers</a></li>-->
<!--                <li class="nav-item "><a class="nav-link" href="#"><span class="fontaws"><font-awesome-icon icon="sitemap"/></span>Departments</a></li>-->
                <li class="nav-item "><router-link :to="{name:'item_index'}" class="nav-link" ><span class="fontaws"><font-awesome-icon icon="list"/></span>Items</router-link></li>
                <li class="nav-item "><router-link :to="{name:'in_list'}" class="nav-link" ><span class="fontaws"><font-awesome-icon icon="shopping-cart"/></span>IN</router-link></li>
                <li class="nav-item "><router-link :to="{name:'out_list'}" class="nav-link" ><span class="fontaws"><font-awesome-icon icon="sign-out-alt"/></span>OUT</router-link></li>
                <li class="nav-item "><router-link :to="{name:'cart_list'}" class="nav-link" ><span class="fontaws"><font-awesome-icon icon="shopping-cart"/></span>Shopping List</router-link></li>
            </ul>
        </div>

    </div>
</template>

<script>
export default {
    name: "siteSidebar"
}
</script>

<style scoped>
.container-fluid{
    max-width: 160px;
}
.navbar{
    margin-left: 10px;
    max-width: 150px;
}
.fontaws{
    margin-right: 20px;
}
.nav-link{
    color:grey !important;
    padding-left: 5px;
    padding-right:5px;
}
.nav-link:hover{
    background-color:#6f42c1 ;
    color:white !important;
}
.router-link-active{
    background-color:#6f42c1 ;
    color:white !important;
}
</style>
