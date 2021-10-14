<template>
    <div class="container-fluid">
        <v-app>
            <div class="row">
                <div class="col-2 border">
                    <v-list >
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon>mdi-book</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title @click="accessory.selected_item='A'"><router-link :to="{name:main_form_link,params:{admission:admission}}">Main</router-link></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <v-list-group
                            v-for="item in accessory.items"
                            :key="item.title"
                            v-model="item.active"
                            :prepend-icon="item.icon"
                            no-action
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title v-text="item.title"></v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item
                                v-for="child in item.items"
                                :key="child.title"
                            >
                                <v-list-item-icon>
                                    <v-icon v-text="child.icon"></v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title @click="accessory.selected_item=child.code"><a href="#">{{child.title}}</a></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>
                    </v-list>
                </div>
                <div class="col-10">
                    <div v-if="accessory.selected_item==='A'">
                        <router-view/>
                    </div>
                    <internal_referral v-if="accessory.selected_item==='E1'" :admission="admission"/>
                    <internal_lab v-if="accessory.selected_item==='C1'" :admission="admission"/>
                </div>
            </div>
        </v-app>
    </div>
</template>

<script>
import Internal_referral from "./internal_referral";
import Internal_lab from "../views/medical/labwork/internal/internal_lab";
export default {
    name: "medical_form_layout",
    components: {Internal_lab, Internal_referral},
    data(){
        return{
            admission:'',
            accessory:{
                items: [
                    {
                        title: 'C. Lab-work',
                        icon: 'mdi-flask-plus',
                        items:[
                            {title:'internal',url:'test',icon:'mdi-alpha-i-circle',code:'C1'},
                            {title:'external',url:'tt',icon:'mdi-alpha-o-circle',code:'C2'}
                        ]
                    },
                    {
                        title: 'D. Consultation',
                        icon: 'mdi-stethoscope',
                        items:[
                            {title:'internal',url:'test',icon:'mdi-alpha-i-circle',code:'D1'},
                            {title:'external',url:'tt',icon:'mdi-alpha-o-circle',code:'D2'}
                        ]
                    },
                    {
                        title: 'E. Referral',
                        icon: 'mdi-truck',
                        items:[
                            {title:'internal',url:'test',icon:'mdi-application-export',code:'E1'},
                            {title:'external',url:'tt',icon:'mdi-city',code:'E2'}
                        ]
                    },{
                        title: 'F. Special',
                        icon: 'mdi-chemical-weapon',
                        items:[
                            {title:'internal',url:'test',icon:'mdi-application-export',code:'F1'},
                            {title:'external',url:'tt',icon:'mdi-city',code:'F2'}
                        ]
                    },
                ],
                selected_item:'C1'
            }
        }
    },
    created(){
        this.init()
        this.$router.push({name:this.main_form_link,params:{admission:this.admission}})
    },
    methods:{
       init(){
           if(Object.keys(this.$route.params).length>0 ){
               this.admission= this.$route.params.admission
           }
       }
    },
    computed:{
        main_form_link(){
            switch(this.admission.service_activity_id){
                case 6:
                    return 'generalist_form'
                break;
            }

        }
    }
}
</script>

<style scoped>

</style>
