<template>
  <div>
    <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark shadow-sm">
      <div class="container-fluid">
        <router-link
          :to="{ name: 'obstetrics_welcome' }"
          class="navbar-brand"
          href="#"
        >
          MHM Maternity
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
          <ul class="navbar-nav ml-4 mx-auto">

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
            <th>CPN</th>
            <th>US</th>
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
                        <v-icon>mdi-arrow-right</v-icon>
                      {{ adm.id }}
                    </router-link>
                  </li>
                </ul>
              </td>
              <td>
                  <ul>
                      <li v-for="us of result.ultra_sound_admissions">
                          <router-link
                              :to="{ name: 'ultrasound_form', params: { id: us.id } }"
                              @click.native="reset"
                          >
                              <v-icon>mdi-arrow-right</v-icon>
                              {{ us.id }}
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
      this.gotResult=false;
    },
    onClickOutside() {
      this.gotResult = false;
    },
      toEmpty(firstName){
          if(firstName===null ) return ''
          return firstName
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
    padding-top: 5px;
}
.search_input >>> .v-text-field__slot input{
    color:white;
}
.search_input >>> .v-text-field__slot input::placeholder{
    color:rgba(191,191,191,0.6);
}
.search_input >>> .v-icon{
    color:lightgrey !important;
}
.v-icon{
    color:lightgrey !important;
}
#result {
  width: 500px;
  margin-left: 41%;
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
ul{
    list-style: none;
}
</style>
