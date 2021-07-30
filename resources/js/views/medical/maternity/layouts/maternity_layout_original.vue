<template>
    <div class="wrapper">

        <Header></Header>


        <v-row class="content">
            <v-col cols="2">
                <sidebar></sidebar>
            </v-col>
            <v-col cols="10">
                <transition
                    name="fade"
                    mode="out-in">
                    <router-view />
                </transition>
            </v-col>
        </v-row>

    </div>


</template>

<script>

    import Header from "./partials/Header"
    import Sidebar from "./partials/sidebar";
    export default {
        name: "obstetrics_layout",
        components:{Sidebar, Header},
        created() {

        },
        methods:{

        },
        computed:{

        }

    }
</script>

<style scoped>
.content{
    margin-top: 45px;
}


</style>
