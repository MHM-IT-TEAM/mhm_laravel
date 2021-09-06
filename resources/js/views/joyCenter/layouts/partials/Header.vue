<template>
  <div>
    <nav class="navbar navbar-expand-md shadow-sm navbar-dark fixed-top" style="background-color: #0093D7">
      <div class="container-fluid">
        <router-link :to="{ name: 'joyHome' }" class="navbar-brand" href="#">
          JoyCenter
        </router-link>
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
              <router-link
                :to="{ name: 'patients.crud' }"
                class="nav-link"
                href=""
                >PATIENTS</router-link
              >
            </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      ADMISSION
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <router-link
                          :to="{ name: 'admission.new' }"
                          class="dropdown-item">
                          <i class="glyphicon glyphicon-plus"></i>
                          New
                      </router-link>
                      <router-link
                          :to="{ name: 'admission.list' }"
                          class="dropdown-item">
                          <i class="glyphicon glyphicon-plus"></i>
                          List
                      </router-link>
                  </div>
              </li>
              <li class="nav-item">
                  <router-link :to="{ name: 'consultation.list' }" class="nav-link"
                  >DISCHARGE</router-link>
              </li>

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
  name: "Header",
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
