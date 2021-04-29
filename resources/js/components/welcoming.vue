<template>
    <div>
        <v-app>
            <v-card
                class="d-flex  justify-center align-center "
                height="100vh"
            >
                <h1 >Welcome</h1>

            </v-card>
        </v-app>
    </div>

</template>

<script>
export default {
    name: "welcoming",
    created(){
        this.init()
    },
    methods:{
        init(){
            axios.get('/api/connected_user')
        }
    }
}
</script>

<style scoped>

</style>
