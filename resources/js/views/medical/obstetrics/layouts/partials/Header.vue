<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container-fluid">
        <router-link :to="{ name: 'obstetrics_welcome' }" class="navbar-brand" href="#">
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
              <input
                type="text"
                id="searchText"
                placeholder="Type here"
                @change="search"
                v-model="search_text"
                autocomplete="off"
              />
              <span v-show="search_text" class="removeInput" @click="reset"
                >X</span
              >
            </li>
          </ul>
          <v-icon medium @click="logout"> mdi-exit-to-app</v-icon>
        </div>
      </div>
    </nav>
    <v-card id="result" max-height="700px">
      <!-- <button
        class="btn btn-primary btn-sm float-right position-fixed"
        v-if="isResult"
        @click="reset"
      >
        X
      </button> -->
      <p v-if="noResult">No matching data</p>
      <div v-for="result of results" class="result_content" v-if="isResult">
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
      isResult: false,
      noResult: false,
      search_text: "",
      results: [],
    };
  },
  watch: {
    search_text(val) {
      val === "" ? (this.isResult = false) : (this.isResult = true);
    },
  },
  methods: {
    async logout() {
      axios
        .post("/logout")
        .then((resp) => console.log(resp))
        .then((window.location.href = "/login"));
    },
    async search() {
      let response = await axios.get("/api/obstetrics/search", {
        params: { search: this.search_text },
      });
      if (response.data.length > 0) {
        this.results = response.data;
        this.noResult = false;
        this.isResult = true;
      } else {
        this.isResult = false;
        this.noResult = true;
      }
    },
    reset() {
      this.isResult = false;
      this.search_text = "";
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
#searchText {
  width: 500px;
  margin-left: 100px;
  height: 20px;
  margin-top: 10px;
  border: 0;
  border-radius: 0;
  border-bottom: 1px solid grey;
}
#searchText::placeholder {
  color: rgba(0, 0, 0, 0.26);
}
#searchText:focus {
  border: 0;
  outline: none;
  border-bottom: 2px solid #000;
}
#result {
  width: 500px;
  margin-left: 525px;
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
