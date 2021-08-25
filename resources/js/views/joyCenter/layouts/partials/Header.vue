<template>
  <div>
    <nav class="navbar navbar-expand-md shadow-sm navbar-light" style="background-color:#92dff7">
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
<!--            <li class="nav-item">-->
<!--              <router-link :to="{ name: 'consultation.list' }" class="nav-link"-->
<!--                >List of consultations</router-link-->
<!--              >-->
<!--            </li>-->
<!--              <li class="nav-item">-->
<!--                  <router-link-->
<!--                      :to="{ name: 'consultation.new' }"-->
<!--                      class="nav-link"-->
<!--                  >-->
<!--                      <i class="glyphicon glyphicon-plus"></i>-->
<!--                      Consultation</router-link-->
<!--                  >-->
<!--              </li>-->
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      OUT PATIENT
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <router-link
                          :to="{ name: 'consultation.new' }"
                          class="dropdown-item">
                          <i class="glyphicon glyphicon-plus"></i>
                          Consultation
                      </router-link>
                      <router-link
                          :to="{ name: 'consultation.list' }"
                          class="dropdown-item">
                          <i class="glyphicon glyphicon-plus"></i>
                          List of consultation
                      </router-link>
                  </div>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      IN PATIENT
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="#">General</a>
                      <router-link
                          :to="{ name: 'joycenter.maternity_admission' }"
                          class="dropdown-item">
                          <i class="glyphicon glyphicon-plus"></i>
                          Obstetrics
                      </router-link>
                  </div>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      PEDIATRIC
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="#">Admission</a>
                  </div>
              </li>
              <li class="nav-item">
                  <router-link :to="{ name: 'consultation.list' }" class="nav-link"
                  >DISCHARGE</router-link>
              </li>

          </ul>
            {{user.name}}
          <v-icon medium @click="logout"> mdi-exit-to-app</v-icon>
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
