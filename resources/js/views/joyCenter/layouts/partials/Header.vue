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
                >Queue</router-link
              >
            </li>

            <li class="nav-item dropdown" id="navOrder">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="glyphicon glyphicon-plus-sign"></i> Consultation
                <span class="caret"></span
              ></a>
              <ul class="dropdown-menu">
                <router-link
                  :to="{ name: 'consultation.new' }"
                  class="dropdown-item"
                >
                  <i class="glyphicon glyphicon-plus"></i>
                  Consultation</router-link
                >
                <router-link
                  :to="{ name: 'hospital_admission.new' }"
                  class="dropdown-item"
                >
                  <i class="glyphicon glyphicon-plus"></i> Hospital
                  Admission</router-link
                >
              </ul>
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
      axios
        .post("/logout")
        .then((resp) => console.log(resp))
        .then((window.location.href = "/login"));
    },
  },
};
</script>

<style scoped>
</style>
