<template>
<div>
    <div class="dropShadow">
        <div class="circle">
        </div>
    </div>
    <div class="content">
        <div class="logoBox">
            <img src="/storage/assets/media/system/images/logo.png" alt="MHM logo" class="logo">
        </div>
        <div class="col-md-12">
            <h2>Login</h2>
        </div>
        <form class="mt-4" @submit.prevent="submit">
            <div class="col-md-12">
                <h5>Id</h5>
            </div>
            <div class="col-md-12">
                <input type="number" v-model="formData.staff_id">
            </div>
            <div class="col-md-12 mt-2">
                <h5>Password</h5>
            </div>
            <div class="col-md-12">
                <input type="password" v-model="formData.password" required>
            </div>
            <div class="col-md-12 mt-4">
                <a href="/login">
                    <button type="submit" class="btn button primary-button mr-4">Login</button>
                </a>
            </div>
        </form>
    </div>
</div>
</template>

<script>
import {mapActions,mapGetters} from 'vuex'
export default {
    name: "login",
    data(){
        return{
            formData:{
                staff_id:'',
                password:''
            }
        }
    },
    methods:{
        ...mapActions('auth',['login']),
        async submit(){
            await this.login(this.formData)
             this.$router.push({name:'dashboard'})

        }
    }
}
</script>

<style scoped>
* {
    font-family: sans-serif;
    box-sizing: border-box;
}
body {
    margin: 0;
    padding: 0;
    height: 100vh;
    width: 100%;
}
.content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(50%,-50%);
    width: 400px;
    height: auto;
    background: transparent;
    padding: 50px 30px;
    transition: box-shadow 0.5s;
}
.content:hover {
    box-shadow: 0px 0px 4px 1px rgba(0,147,215, 0.4);
}
h2 {
    text-align: center;
    color: #385d7a;
}
h5 {
    color: #385d7a;
    font-size: 1.3rem;
}
input {
    border: 0;
    padding: 5px;
    outline: none;
    width: 100%;
    border-bottom:  1px solid lightgray;
    color: #333;
    transition: box-shadow 0.5s;
    letter-spacing: 2px;
    font-size:11px;
}
input:focus {
    box-shadow: 3px 2px 2px 1px rgba(0,147,215, 0.4);
}
.dropShadow {
    /*position: absolute;*/
    /*top: 0;*/
    /*left: 0;*/
    height: 100vh;
    filter: drop-shadow(10px 10px 3px rgba(50, 50, 0, 0.5));
}
.circle {
    width: 100vw;
    height: 100vh;
    background-image: url("/storage/assets/media//system/images/cover.jpg");
    background-size: 50%;
    background-repeat: no-repeat;
    /*clip-path: circle(450px at left);*/
    clip-path: circle(650px at left);
}
.logoBox {
    position: relative;
    top: -40px;
}
.logo {
    display: block;
    width: 115px;
    height: 115px;
    margin: 0 auto;
}
button {
    padding: 0.3rem 1.2rem;
    font-style: normal;
    font-weight: 500;
    position: relative;
    border: 3px solid transparent;
    border-radius: 4px;
}
.button.primary-button {
    background: rgb(34,125,199);
    background: linear-gradient(90deg, rgba(34,125,199,1) 0%, rgba(39,207,254,1) 100%);
    background-clip: padding-box;
    color: whitesmoke;
    transition: background .6s ease;
    box-shadow: 0px 10px 30px rgba(57,56,61,0.205);
}
.button.primary-button:hover {
    background: whitesmoke;
    background-clip: padding-box;
    color: #385d7a;
}
.button.primary-button:after, .button.secondary-button:after{
    position: absolute;
    top: -2px;left: -2px;
    bottom: -2px; right: -2px;
    background: rgb(34,125,199);
    background: linear-gradient(90deg, rgba(34,125,199,1) 0%, rgba(39,207,254,1) 100%);
    content: "";
    z-index: -1;
    border-radius: 4px;
}
.button.secondary-button {
    background: white;
    background-clip: padding-box;
    transition: background 0.6s ease;
}
.button.secondary-button:hover {
    background: rgb(34,125,199);
    background: linear-gradient(90deg, rgba(34,125,199,1) 0%, rgba(39,207,254,1) 100%);
    background-clip: padding-box;
    color: whitesmoke;
    box-shadow: 0px 10px 30px rgba(57,56,61,0.205);
}
a {
    text-decoration: none;
    color: black;
}
/*
  ##Device = Desktops
  ##Screen = 1281px to higher resolution desktops
*/

@media (min-width: 1281px) {

    /* CSS */

}

/*
  ##Device = Laptops, Desktops
  ##Screen = B/w 1025px to 1280px
*/

@media (min-width: 1025px) and (max-width: 1280px) {

    /* CSS */

}

/*
  ##Device = Tablets, Ipads (portrait)
  ##Screen = B/w 768px to 1024px
*/

@media (min-width: 768px) and (max-width: 1024px) {
    .dropShadow {
        display: none;
    }
    .circle {
        display: none;
    }
    .content {
        transform: translate(-50%,-50%);
    }
}

/*
  ##Device = Tablets, Ipads (landscape)
  ##Screen = B/w 768px to 1024px
*/

@media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
    .dropShadow {
        display: none;
    }
    .circle {
        display: none;
    }
    .content {
        transform: translate(-50%,-50%);
    }
}

/*
  ##Device = Low Resolution Tablets, Mobiles (Landscape)
  ##Screen = B/w 481px to 767px
*/

@media (min-width: 481px) and (max-width: 767px) {
    .dropShadow {
        display: none;
    }
    .circle {
        display: none;
    }
    .content {
        transform: translate(-50%,-50%);
    }
}

/*
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {
    .dropShadow {
        display: none;
    }
    .circle {
        display: none;
    }
    .content {
        transform: translate(-50%,-50%);
    }
}
</style>
