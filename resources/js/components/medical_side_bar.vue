<template>
<div>
    <v-list >
        <v-list-item>
            <v-list-item-icon>
                <v-icon>mdi-book</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
                <v-list-item-title @click="selected_item='A'">Main</v-list-item-title>
            </v-list-item-content>
        </v-list-item>

        <v-list-group
            v-for="item in items"
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
                    <v-list-item-title @click="selected_item=child.code"><a href="#">{{child.title}}</a></v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list-group>
    </v-list>
</div>
</template>

<script>
export default {
    name: "medical_side_bar",
    data(){
       return {
           items: [
               {
                   title: 'Lab-work',
                   icon: 'mdi-flask-plus',
                   items:[
                       {title:'internal',url:'test',icon:'mdi-alpha-i-circle',code:'C1'},
                       {title:'external',url:'tt',icon:'mdi-alpha-o-circle',code:'C2'}
                   ]
               },
               {
                   title: 'Additional consultation',
                   icon: 'mdi-stethoscope',
                   items:[
                       {title:'internal',url:'test',icon:'mdi-alpha-i-circle',code:'D1'},
                       {title:'external',url:'tt',icon:'mdi-alpha-o-circle',code:'D2'}
                   ]
               },
               {
                   title: 'Referral',
                   icon: 'mdi-truck',
                   items:[
                       {title:'internal',url:'test',icon:'mdi-application-export',code:'E1'},
                       {title:'external',url:'tt',icon:'mdi-city',code:'E2'}
                   ]
               },{
                   title: 'Special',
                   icon: 'mdi-chemical-weapon',
                   items:[
                       {title:'internal',url:'test',icon:'mdi-application-export',code:'F1'},
                       {title:'external',url:'tt',icon:'mdi-city',code:'F2'}
                   ]
               },
           ],
           selected_item:''
        }
    }
}
</script>

<style scoped>

</style>
