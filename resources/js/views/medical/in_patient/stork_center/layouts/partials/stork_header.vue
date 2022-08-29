<template>
    <div>
        <nav class="navbar navbar-expand-md shadow-sm navbar-dark " style="background-color: #bc51cf">
            <div class="container-fluid">
                <li  class="navbar-brand" >
                    Stork Center
                </li>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ml-4 mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/home">Home</a>
                        </li>
                        <li class="nav-item">
                            <router-link
                                :to="{ name: 'stork_request' }"
                                class="nav-link"
                                href=""
                            >Admission request</router-link
                            >
                        </li>
                        <li class="nav-item">
                            <router-link
                                :to="{ name: 'stork_patient_list'}"
                                class="nav-link"
                                href=""
                            >Patients</router-link
                            >
                        </li>
                        <li class="nav-item">
                            <router-link
                                :to="{ name: 'in_patient_book' }"
                                class="nav-link"
                                href=""
                            >In-patient book</router-link
                            >
                        </li>
                        <li class="nav-item">
                            <router-link
                                :to="{ name: 'stork_external_referral_book' }"
                                class="nav-link"
                                href=""
                            >Referral book</router-link
                            >
                        </li>
                        <li class="nav-item">
                            <router-link
                                :to="{ name: 'stork_internal_lab_list' }"
                                class="nav-link"
                                href=""
                            >Labwork</router-link
                            >
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                Supply
                            </a>
                            <div class="dropdown-menu">
                                <router-link
                                    :to="{ name: 'stork_order' }"
                                    class="dropdown-item"
                                    href=""
                                >Order</router-link>
                                <router-link
                                    :to="{ name: 'stork_supply_list' }"
                                    class="dropdown-item"
                                    href=""
                                >List</router-link>
                            </div>
                        </li>
<!--                        <li class="nav-item dropdown">-->
<!--                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--                                ADMISSION-->
<!--                            </a>-->
<!--                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">-->
<!--                                <router-link-->
<!--                                    :to="{ name: 'admission.new' }"-->
<!--                                    class="dropdown-item">-->
<!--                                    <i class="glyphicon glyphicon-plus"></i>-->
<!--                                    New-->
<!--                                </router-link>-->
<!--                                <router-link-->
<!--                                    :to="{ name: 'admission.list' }"-->
<!--                                    class="dropdown-item">-->
<!--                                    <i class="glyphicon glyphicon-plus"></i>-->
<!--                                    List-->
<!--                                </router-link>-->
<!--                            </div>-->
<!--                        </li>-->
                    </ul>
                    <span class="text-white mr-2 text-uppercase">{{user.name}}</span>
                    <v-icon medium @click="logout" class="text-white"> mdi-exit-to-app</v-icon>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    name: "stork_header",
    data(){
        return{
            user:null
        }
    },
    created(){
        this.user=window.auth.user
    },
    methods: {
        async logout() {
            await axios.post("/logout").then((resp) => console.log(resp));
            window.location.href = "/login";
        },
    },
};
</script>

<style scoped>
</style>
