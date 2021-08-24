<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
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
                >Patients</router-link
              >
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'consultation.list' }" class="nav-link"
                >List of consultations</router-link
              >
            </li>
              <li class="nav-item">
                  <router-link
                      :to="{ name: 'consultation.new' }"
                      class="nav-link"
                  >
                      <i class="glyphicon glyphicon-plus"></i>
                      Consultation</router-link
                  >
              </li>
              <li class="nav-item">
                  <router-link
                      :to="{ name: 'consultation.new' }"
                      class="nav-link"
                  >
                      <i class="glyphicon glyphicon-plus"></i>
                      Hospital Admission
                      </router-link
                  >
              </li>
              <li class="nav-item">
                  <router-link
                      :to="{ name: 'consultation.new' }"
                      class="nav-link"
                  >
                      <i class="glyphicon glyphicon-plus"></i>
                      Emergency Admission
                  </router-link
                  >
              </li>
              <li class="nav-item">
                  <router-link
                      :to="{ name: 'consultation.new' }"
                      class="nav-link"
                  >
                      <i class="glyphicon glyphicon-plus"></i>
                      Pediatric Admission
                  </router-link
                  >
              </li>
              <li class="nav-item">
                  <router-link
                      :to="{ name: 'joycenter.maternity_admission' }"
                      class="nav-link"
                  >
                      <i class="glyphicon glyphicon-plus"></i>
                      Maternity Admission
                  </router-link
                  >
              </li>
          </ul>
          <v-icon medium @click="logout"> mdi-exit-to-app</v-icon>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: "Header",
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
