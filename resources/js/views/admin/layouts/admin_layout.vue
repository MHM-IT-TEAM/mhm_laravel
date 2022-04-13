<template>
    <v-app id="inspire" class="content">
        <v-app id="inspire">
            <v-navigation-drawer
                app
                clipped
                v-model="drawer"
                id="drawer"
                :width="250"
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

                <v-list >
<!--                    <v-list-item>-->
<!--                        <v-list-item-icon>-->
<!--                            <v-icon>mdi-alpha-p-box</v-icon>-->
<!--                        </v-list-item-icon>-->
<!--                        <v-list-item-content>-->
<!--                            <v-list-item-title ><router-link :to="{name:'dentist_patient_list'}" class="link">Patient list</router-link></v-list-item-title>-->
<!--                        </v-list-item-content>-->
<!--                    </v-list-item>-->
<!--                    <v-list-item>-->
<!--                        <v-list-item-icon>-->
<!--                            <v-icon>mdi-book-edit</v-icon>-->
<!--                        </v-list-item-icon>-->
<!--                        <v-list-item-content>-->
<!--                            <v-list-item-title ><router-link :to="{name:'dentist_item_order'}" class="link">Order</router-link></v-list-item-title>-->
<!--                        </v-list-item-content>-->
<!--                    </v-list-item>-->

                    <v-list-group
                        v-for="item in items"
                        :key="item.title"
                        v-model="item.active"
                        :prepend-icon="item.action"
                        no-action
                    >
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title v-text="item.title" class="title"></v-list-item-title>
                            </v-list-item-content>
                        </template>

                        <v-list-item
                            v-for="child in item.items"
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
                color="#1390C6"
                class="white-text d-print-none"
                dense
            >
                <v-app-bar-nav-icon @click.stop="drawer = !drawer"  class="white--text"></v-app-bar-nav-icon>
<!--                <v-icon-->
<!--                    class="mx-4 white&#45;&#45;text"-->
<!--                    large-->
<!--                >-->
<!--                    mdi-tooth-->
<!--                </v-icon>-->
                <v-toolbar-title class="mr-12 align-center">
                    <span class="title text-white">Admin</span>
                </v-toolbar-title>
                <v-spacer></v-spacer>
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
        name: "admin_layout",
        props: {
            source: String,
        },
        data: () => ({
            drawer: null,
            items: [
                {
                    title:'Administration',
                    active:false,
                    action:'mdi-briefcase',
                    items:[
                        {
                            title:'Users',
                            active:false,
                            url:"admin_user_crud"
                        },
                        {
                            title:'Pages',
                            active:false,
                            url:"admin_page_crud"
                        }
                    ]
                },
                {
                    title:'Reports',
                    active:false,
                    action:'mdi-ballot-outline',
                    items:[
                        {
                            title:'General overview',
                            active:false,
                            url:"admin_statistics"
                        }
                    ]
                },
                {
                    title:'CRM',
                    active:false,
                    action:'mdi-dip-switch'
                }
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
.link{
    font-size: 9px !important;
}
.title{
    font-size: 12px !important;
}

@media print{
    #drawer{
        display:none;
    }
}
</style>
