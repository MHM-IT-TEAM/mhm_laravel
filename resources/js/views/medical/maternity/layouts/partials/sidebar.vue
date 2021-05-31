<template>
    <div class="sidebar">
        <v-app>
            <v-card height="100vh">
                <v-navigation-drawer
                    permanent
                    left
                >
                    <template v-slot:prepend>
                        <v-list-item two-line>
                            <v-list-item-avatar>
<!--                                <img src="https://randomuser.me/api/portraits/women/81.jpg">-->
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title>Jane Smith</v-list-item-title>
                                <v-list-item-subtitle>Logged In</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </template>

                    <v-divider></v-divider>

                    <v-list >
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon>mdi-home</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title ><router-link to="hospital_admission" class="link">Admission</router-link></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <v-list-group
                            v-for="item in items"
                            :key="item.title"
                            v-model="item.active"
                            :prepend-icon="item.action"
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
                                <v-list-item-content>
                                    <v-list-item-title><router-link to="hospital_admission" class="link">{{child.title}}</router-link></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>
                    </v-list>
                </v-navigation-drawer>
            </v-card>
        </v-app>
    </div>
</template>

<script>
export default {
    name: "sidebar",
    data: () => ({
        items: [
            {
                action: 'mdi-baby-face',
                items: [{ title: 'Registration' },{title:'Declaration'},{title:'Delivery Book'}],
                title: 'Delivery',


            },
            {
                action: 'mdi-mother-nurse',

                items: [
                    { title: 'Planning' },
                    { title: 'Actions & Treatments' },
                    { title: 'Overview &report' },
                ],
                title: 'In-Patient ',
            },
            {
                action: 'mdi-truck-delivery',
                items: [
                    { title: 'Internal referral' },
                    { title: 'External referral' },
                    { title: 'Discharge' },
                ],
                title: 'Referral & Discharge ',
            },
            {
                action: 'mdi-chemical-weapon',
                items: [{ title: 'Request' },{title:'Lab result'},{title:'overview'}],
                title: 'Lab Works',

            },
            {
                action: 'mdi-warehouse',
                items: [{ title: 'Order request' },{title:'report'}],
                title: 'Inventory',

            },

        ],
    }),
}
</script>

<style scoped>
.sidebar{
    position:fixed;
}
.link{
    color:black !important;
}

</style>
