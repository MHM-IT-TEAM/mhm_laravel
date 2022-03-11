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
            <li class="nav-item dropdown" id="navOrder">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="glyphicon glyphicon-plus-sign"></i>Menu
                <span class="caret"></span
              ></a>
              <ul class="dropdown-menu">
                <router-link
                  :to="{ name: 'first_cpn_list'}"
                  class="dropdown-item"
                >
                  <i class="glyphicon glyphicon-plus"></i>
                  Prenatal Care First Checkup
                </router-link>
                <router-link
                  :to="{ name: 'cpn_followup_list'}"
                  class="dropdown-item"
                >
                  <i class="glyphicon glyphicon-plus"></i>
                  Prenatal Care Followup
                </router-link>
                <router-link
                  :to="{ name: 'ultrasound_list' }"
                  class="dropdown-item"
                >
                    Ultrasound
                </router-link>
                  <router-link
                      :to="{ name: 'baby_checkup_list' }"
                      class="dropdown-item"
                  >
                      Baby Checkup
                  </router-link>
                  <router-link
                      :to="{ name: 'baby_vaccination_list' }"
                      class="dropdown-item"
                  >
                      Vaccin
                  </router-link>
              </ul>
            </li>
            <li class="nav-item">
              <v-text-field
                dense
                append-icon="mdi-magnify"
                placeholder="Type your search here"
                class="search_input"
                v-model="search_text"
                @change="fetch"
              ></v-text-field>
            </li>
          </ul>
            <span>{{user.name}}</span>
          <v-icon medium @click="logout"> mdi-exit-to-app</v-icon>
        </div>
      </div>
    </nav>
    <v-card id="result" max-height="700px" v-click-outside="onClickOutside">
      <p v-if="noResult">No matching data</p>
      <div v-for="result of results" class="result_content" v-if="gotResult">
        <p>
          Id: &nbsp{{ result.id }}
          <span class="float-right">
            {{ result.firstName + " " + toEmpty(result.lastName) }}</span
          >
        </p>
        <table class="table table-sm">
          <thead>
            <th>Prenatal Care First Checkup</th>
            <th>Ultrasound</th>
            <th>Birth</th>
            <th>Post Partum</th>
          </thead>
          <tbody>
            <tr>
              <td>
                <ul>
                  <li v-for="adm of result.cpn_admissions">
                    <table>
                      <tr>
                        <td>{{ adm.id }} ({{ formatDate(new Date(adm.created_at)) }})</td>
                        <td class="text-nowrap">
                          <router-link
                            :to="{ name: 'cpn_admission', params: { id: adm.id } }"
                            @click.native="reset"
                          >
                              <v-icon>mdi-arrow-right</v-icon>
                              First Checkup
                          </router-link>
                          <br/>
                           <router-link
                             :to="{ name: 'cpn_followup', params: { cpn_ref: adm.id } }"
                             @click.native="reset"
                            >
                              <v-icon>mdi-arrow-right</v-icon>
                              Followups ({{ adm.followups.length }})
                          </router-link>
                          <br/>
                          <router-link
                              :to="{ name: 'obstetrics_overview', params: { cpn_ref: adm.id, } }"
                              @click.native="reset"
                          >
                              <v-icon>mdi-arrow-right</v-icon>
                              Overview
                          </router-link>
                        </td>
                      </tr>
                    </table>
                  </li>
                </ul>
              </td>
              <td>
                  <ul>
                      <li v-for="us of result.ultra_sound_admissions">
                          <router-link
                              :to="{ name: 'ultrasound_form', params: { ref: us.id } }"
                              @click.native="reset"
                          >
                              <v-icon>mdi-arrow-right</v-icon>
                              {{ us.id }} ({{ formatDate(new Date(us.created_at)) }})
                          </router-link>
                      </li>

                  </ul>
              </td>
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
      user:null
    };
  },
  watch: {
    // search_text(val) {
    //   // val === "" ? (this.isResult = false) : (this.isResult = true);
    //   this.fetch(val);
    // },
  },
    created(){
      this.user=window.auth.user
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
      let response = await axios.get("/api/v1/patient_system/out_patient/obstetrical/search", {
        params: { search: this.search_text },
      });
      this.results = response.data;
      this.gotResult = true;
    },
    reset() {
      this.isResult = false;
      this.search_text = "";
      this.gotResult=false;
    },
    onClickOutside() {
      this.gotResult = false;
    },
      toEmpty(firstName){
          if(firstName===null ) return ''
          return firstName
      },
    formatDate(date) {
      if (!date)
        return '';

      return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
    }
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
.navbar{
    height:45px !important;
    padding:5px !important;
}
.search_input {
  width: 500px;
  margin-left: 26px;
}
#result {
  width: 500px;
  margin-left: 305px;
  position: absolute;
  z-index: 1000;
  border-radius: 0;
  overflow-y: scroll;
}
#result td {
  white-space: nowrap;
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
ul{
    list-style: none;
}
.section-title {
  text-align: center;
  margin: auto;
  margin-right: 20px;
  width: 60px;
}
</style>
