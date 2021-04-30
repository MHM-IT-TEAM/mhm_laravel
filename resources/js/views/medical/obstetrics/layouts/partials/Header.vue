<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container-fluid">
        <router-link
          :to="{ name: 'obstetrics_welcome' }"
          class="navbar-brand"
          href="#"
        >
          Pink Section
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
            <!--            <li class="nav-item">-->
            <!--              <router-link-->
            <!--                :to="{ name: 'cpn_admission' }"-->
            <!--                class="nav-link"-->
            <!--                href=""-->
            <!--                >CPN Admission</router-link-->
            <!--              >-->
            <!--            </li>-->
            <li class="nav-item dropdown" id="navOrder">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="glyphicon glyphicon-plus-sign"></i>Admission
                <span class="caret"></span
              ></a>
              <ul class="dropdown-menu">
                <router-link
                  :to="{ name: 'first_cpn_list' }"
                  class="dropdown-item"
                >
                  <i class="glyphicon glyphicon-plus"></i>
                  CPN</router-link
                >
                <router-link
                  :to="{ name: 'hospital_admission_home' }"
                  class="dropdown-item"
                >
                  <!--                  <i class="glyphicon glyphicon-plus"></i> Echographie-->
                  <!--                </router-link>-->
                  <!--                <router-link-->
                  <!--                  :to="{ name: 'hospital_admission_home' }"-->
                  <!--                  class="dropdown-item"-->
                  <!--                >-->
                  <!--                  <i class="glyphicon glyphicon-plus"></i> Baby Checkup-->
                  <!--                </router-link>-->
                  <!--                <router-link-->
                  <!--                  :to="{ name: 'hospital_admission_home' }"-->
                  <!--                  class="dropdown-item"-->
                  <!--                >-->
                  <!--                  <i class="glyphicon glyphicon-plus"></i> Milk Program-->
                </router-link>
              </ul>
            </li>

            <!--            <li class="nav-item">-->
            <!--              <router-link :to="{ name: 'consultation.list' }" class="nav-link"-->
            <!--                >Queue</router-link-->
            <!--              >-->
            <!--            </li>-->

            <li class="nav-item dropdown" id="navOrder">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="glyphicon glyphicon-plus-sign"></i> Follow up
                <span class="caret"></span
              ></a>
              <ul class="dropdown-menu">
                <router-link
                  :to="{ name: 'cpn_followup' }"
                  class="dropdown-item"
                >
                  <i class="glyphicon glyphicon-plus"></i>
                  CPN</router-link
                >
                <!--                <router-link-->
                <!--                  :to="{ name: 'hospital_admission_home' }"-->
                <!--                  class="dropdown-item"-->
                <!--                >-->
                <!--                  <i class="glyphicon glyphicon-plus"></i> Echographie-->
                <!--                </router-link>-->
                <!--                <router-link-->
                <!--                  :to="{ name: 'hospital_admission_home' }"-->
                <!--                  class="dropdown-item"-->
                <!--                >-->
                <!--                  <i class="glyphicon glyphicon-plus"></i> Baby Checkup-->
                <!--                </router-link>-->
                <!--                <router-link-->
                <!--                  :to="{ name: 'hospital_admission_home' }"-->
                <!--                  class="dropdown-item"-->
                <!--                >-->
                <!--                  <i class="glyphicon glyphicon-plus"></i> Milk Program-->
                <!--                </router-link>-->
              </ul>
            </li>
            <li class="nav-item">
              <!-- <input
                type="text"
                id="searchText"
                placeholder="Type here"
                @change="search"
                v-model="search_text"
                autocomplete="off"
              />
              <span v-show="search_text" class="removeInput" @click="reset"
                >X</span
              > -->
              <v-text-field
                dense
                append-icon="mdi-magnify"
                placeholder="Type your search here"
                class="search_input"
                v-model="search_text"
                @change="fetch"
              ></v-text-field>
            </li>
            <!-- <li>
              <v-autocomplete
                :loading="loading"
                :items="results"
                item-text="firstName"
                :search-input.sync="search_text"
                cache-items
                class="mx-4"
                flat
                dense
                hide-no-data
                hide-details
                label="Type your search here"
                solo-inverted
              ></v-autocomplete>
            </li> -->
          </ul>
          <v-icon medium @click="logout"> mdi-exit-to-app</v-icon>
        </div>
      </div>
    </nav>
    <v-card id="result" max-height="700px" v-click-outside="onClickOutside">
      <p v-if="noResult">No matching data</p>
      <div v-for="result of results" class="result_content" v-if="gotResult">
        <p class="text-headline">
          Id: &nbsp{{ result.id }}
          <span class="float-right">
            {{ result.firstName + " " + result.lastName }}</span
          >
        </p>
        <table class="table table-sm">
          <thead>
            <th>CPN</th>
            <th>Echo</th>
            <th>Birth</th>
            <th>Post Partum</th>
          </thead>
          <tbody>
            <tr>
              <td>
                <ul>
                  <li v-for="adm of result.cpn_admissions">
                    <router-link
                      :to="{ name: 'cpn_admission', params: { id: adm.id } }"
                      @click.native="reset"
                    >
                      {{ adm.id }}
                    </router-link>
                  </li>
                </ul>
              </td>
              <td></td>
              <td>{{ result.birth_id }}</td>
              <td>{{ result.post_partum_id }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </v-card>
  </div>
</template>

<script>
export default {
  name: "Header",
  data() {
    return {
      gotResult: false,
      noResult: false,
      search_text: "",
      results: [],
      loading: false,
    };
  },
  watch: {
    // search_text(val) {
    //   // val === "" ? (this.isResult = false) : (this.isResult = true);
    //   this.fetch(val);
    // },
  },
  methods: {
    async logout() {
      axios
        .post("/logout")
        .then((resp) => console.log(resp))
        .then((window.location.href = "/login"));
    },
    async fetch() {
      this.loading = true;
      let response = await axios.get("/api/obstetrics/search", {
        params: { search: this.search_text },
      });
      this.results = response.data;
      this.gotResult = true;
    },
    reset() {
      this.isResult = false;
      this.search_text = "";
    },
    onClickOutside() {
      this.gotResult = false;
    },
  },
};
// let result = document.getElementById("test");
// document.addEventListener("mousedown", function (event) {
//   if (result.contains(event.target)) {
//     console.log("ok");
//   }
// });
</script>

<style scoped>
.search_input {
  width: 400px;
  margin-left: 100px;
}
#result {
  width: 500px;
  margin-left: 455px;
  position: absolute;
  z-index: 1000;
  border-radius: 0;
  overflow-y: scroll;
}
.result_content {
  padding: 5px;
}
.result_content:hover {
  background-color: lightgray;
  color: black;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.13), 0 3px 5px 0 rgba(0, 0, 0, 0.08);
}
.text-headline {
  font-size: 20px;
  line-height: 30px;
  padding-top: 16px;
  margin-bottom: 12px;
  letter-spacing: 0;
}
.removeInput {
  color: #ddd;
  cursor: pointer;
  top: 0;
  right: 0;
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
