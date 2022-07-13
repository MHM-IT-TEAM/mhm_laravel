<template>
    <v-app id="inspire" class="content">
        <v-app id="inspire">
            <v-navigation-drawer
                app
                clipped
                v-model="drawer"
                id="drawer"
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
<!--                            <v-icon>mdi-home</v-icon>-->
<!--                        </v-list-item-icon>-->
<!--                        <v-list-item-content>-->
<!--&lt;!&ndash;                            <v-list-item-title ><router-link :to="{name:'maternity_admission'}" class="link">Admission</router-link></v-list-item-title>&ndash;&gt;-->
<!--                            <v-list-item-title ><router-link :to="{name:'maternity_list'}" class="link">Admission</router-link></v-list-item-title>-->

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
                color="purple"
                class="white--text d-print-none"
                dense
            >
                <v-app-bar-nav-icon @click.stop="drawer = !drawer"  class="white--text"></v-app-bar-nav-icon>
                <v-icon
                    class="mx-4 white--text"
                    large
                >
                    mdi-mother-nurse
                </v-icon>
                <v-toolbar-title class="mr-12 align-center">
                    <span class="title">SURGERY</span>
                </v-toolbar-title>
                <v-spacer></v-spacer>
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

    import Sidebar from "./partials/sidebar";
    export default {
        name: "surgery_layout",
        components:{Sidebar},
        props: {
            source: String,
        },
        data: () => ({
            drawer: null,
            items: [
                {
                    action: 'mdi-baby-face',
                    items: [{ title: 'Pre surgery list',url:'pre_surgery_list' },{ title: 'Confirmed List',url:'surgery_list' }],
                    title: 'Menu',

                },
                // {
                //     action: 'mdi-mother-nurse',
                //
                //     items: [
                //         { title: 'Admission request',url:'stork_incoming_patient' },
                //         { title: 'Currently in patients',url:'stork_patient_list' },
                //         { title: 'In Patient Book',url:'in_patient_book' },
                //         { title: 'External Referral Book',url:'stork_external_referral_book' },
                //     ],
                //     title: 'In-Patient ',
                // },
                // {
                //     action: 'mdi-warehouse',
                //     items: [{ title: 'Order',url:'stork_order' },{title:'report',url:''}],
                //     title: 'Inventory',
                //
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
            async logout() {
                await axios.post("/logout").then((resp) => console.log(resp));
                window.location.href = "/login";
            },
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
