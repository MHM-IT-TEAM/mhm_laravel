<template>
    <div class="wrapper">

        <v-row class="content">
            <v-col>
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

    export default {
        name: "overview_layout",
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
