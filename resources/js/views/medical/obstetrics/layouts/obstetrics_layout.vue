<template>
    <v-app id="inspire" class="content">
        <v-app id="inspire">
            <v-navigation-drawer
                app
                clipped
                v-model="drawer"
                id="drawer"
                :width="240"
            >
                <template v-slot:prepend>
                    <v-list-item two-line>
                        <v-list-item-avatar color="green">
                            <!--                                <img src="https://randomuser.me/api/portraits/women/81.jpg">-->
                            <span class="white--text">{{user.name[0].toUpperCase()}}</span>
                        </v-list-item-avatar>

                        <v-list-item-content>
                            <v-list-item-title>{{user.name}}</v-list-item-title>
                            <v-list-item-subtitle>Logged In</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </template>

                <v-divider></v-divider>

                <v-list  dense>
<!--                    <v-list-item>-->
<!--                        <v-list-item-icon>-->
<!--                            <v-icon>mdi-alpha-p-box</v-icon>-->
<!--                        </v-list-item-icon>-->
<!--                        <v-list-item-content>-->
<!--                            <v-list-item-title ><router-link :to="{name:'ultrasound_queue'}" class="link">Queue</router-link></v-list-item-title>-->
<!--                        </v-list-item-content>-->
<!--                    </v-list-item>-->
<!--                    <v-list-item>-->
<!--                        <v-list-item-icon>-->
<!--                            <v-icon>mdi-clipboard-text-search</v-icon>-->
<!--                        </v-list-item-icon>-->
<!--                        <v-list-item-content>-->
<!--                            <v-list-item-title ><router-link :to="{name:'patient_ultrasound_search'}" class="link">Exam list</router-link></v-list-item-title>-->
<!--                        </v-list-item-content>-->
<!--                    </v-list-item>-->
<!--                    <v-list-item>-->
<!--                        <v-list-item-icon>-->
<!--                            <v-icon>mdi-book-edit</v-icon>-->
<!--                        </v-list-item-icon>-->
<!--                        <v-list-item-content>-->
<!--                            <v-list-item-title ><router-link :to="{name:'item_order_ultrasound'}" class="link">Order</router-link></v-list-item-title>-->
<!--                        </v-list-item-content>-->
<!--                    </v-list-item>-->

                    <v-list-group
                        v-for="item in items"
                        :key="item.title"
                        v-model="item.active"
                        no-action
                    >
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title v-text="item.title" class="title"></v-list-item-title>
                            </v-list-item-content>
                        </template>

                        <v-list-item
                            v-for="child in item.children"
                            :key="child.title"
                        >
                            <v-list-item-content>
                                <v-list-item-title><router-link :to="{name:child.url}" class="link">{{child.title}}</router-link></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>
                </v-list>
            </v-navigation-drawer>

            <v-app-bar
                app
                clipped-left
                color="#F8BBD0"
                class="white-text d-print-none"
                dense
            >
                <v-app-bar-nav-icon @click.stop="drawer = !drawer"  class="white--text"></v-app-bar-nav-icon>
                <v-icon
                    class="mx-4 white--text"
                    large
                >
                    mdi-heart-plus-outline
                </v-icon>
                <v-toolbar-title class="mr-12 align-center">
                    <span class="title text-white">PINK</span>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <!--                <v-row>-->
                <!--                    align="right"-->
                <!--                    style="max-width: 650px"-->
                <!--                    <v-text-field-->
                <!--                        :append-icon-cb="() => {}"-->
                <!--                        placeholder="Search..."-->
                <!--                        single-line-->
                <!--                        append-icon="mdi-magnify"-->
                <!--                        color="white"-->
                <!--                        class="white&#45;&#45;text"-->
                <!--                        hide-details-->
                <!--                    ></v-text-field>-->

                <!--                </v-row>-->
                <span class="text-white mr-2 text-uppercase">{{user.name}}</span>
                <v-icon medium @click="logout" class="text-white"> mdi-exit-to-app</v-icon>
            </v-app-bar>

            <v-main>
                <v-container class="fill-height bg-white print-area" fluid>
                    <transition
                        name="fade"
                        mode="out-in">
                        <router-view />
                    </transition>
                </v-container>
            </v-main>
        </v-app>
    </v-app>
</template>

<script>
export default {
    name: "obstetrics_layout",
    props: {
        source: String,
    },
    data: () => ({
        drawer: null,
        items: [
            {
                title:'Family Planning',
                active:false,
                children:[
                    {url:'family_planning_list',title:'Today List'}
                ]
            },
            {
                title:'Prenatal Checkup',
                active:false,
                icon:'mdi-apps',
                children:[
                    {url:'first_cpn_list',title:'First Checkup'},
                    {url:'cpn_followup_list',title:'Followup'},
                    {url:'patient_cpn_search',title:'Pregnancy Card'},
                ]
            },
            {
                title:'Postpartum',
                active:false,
                icon:'mdi-apps',
                children:[
                    {url:'postpartum_list',title:'List'},
                ]
            },
            {
                title:'Babies',
                active:false,
                children:[
                    {url:'baby_checkup_list',title:'Checkup'},
                    {url:'baby_vaccination_list',title:'Vaccination'},
                    {url:'baby_sickness_list',title:'Sickness'},
                    // {url:'',title:'Injury'},
                    // {url:'',title:'Wound care'},
                ]
            },
            {
                title:'Milk Program',
                active:false,
                children:[
                    {url:'milk_pro_list',title:'Today List'},
                ]
            },
            {
                title:'Inventory',
                active:false,
                children:[
                    {url:'item_order_obstetrics',title:'Order'},
                ]
            },
            // {
            //     title:'Report',
            //     active:false,
            //     children:[
            //         {url:'pink_statistics',title:'General overview'},
            //     ]
            // },
        ],
        user:{
            id:'',
            name:''
        }
    }),
    created () {
        // this.$vuetify.theme.dark = true
        this.user= window.auth.user
    },
    methods:{
        async logout(){
            await axios.post("/logout").then((resp) => console.log(resp));
            window.location.href = "/login";
        }
    }
}
</script>

<style scoped>
.title{
    font-size: 11px !important;
}
</style>

