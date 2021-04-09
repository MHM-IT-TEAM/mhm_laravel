<template>
    <div>

        <Header></Header>
        <transition
            name="fade"
            mode="out-in">
            <router-view />
        </transition>

    </div>


</template>

<script>

    import Header from "./partials/Header"
    export default {
        name: "joyLayout",
        components:{Header},
        created() {

        },
        methods:{

        },
        computed:{

        }

    }
</script>

<style scoped>


</style>
