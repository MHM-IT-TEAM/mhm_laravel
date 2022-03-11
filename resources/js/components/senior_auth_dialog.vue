<template>
  <v-dialog
    :value="value"
    @input="isOpenChanged"
    max-width="175px"
    >
      <v-card>
        <v-card-text>
          <v-card-title>Login</v-card-title>
          <span :style="{'opacity': error_message ? 1 : 0}" class="text-danger" style="transition: opacity 0.5s ease-out;">{{ error_message }}</span>
          <v-text-field
            label="id"
            v-model="id"
          ></v-text-field>
          <v-text-field label="password" type="password" v-model="password" v-on:keyup.enter="login"></v-text-field>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn
          text
          color="primary"
          x-small
          @click="login"
        >
          Ok
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "seniorAuthDialog",
  data: function () {
    return {
      id:'',
      password:'',
      error_message: null,
    };
  },
  watch: {
    value(val, oldVal) {
      if (val && !oldVal) {
        this.id = '';
        this.password = '';
        this.error_message = null;
      }
    }
  },
  methods: {
    async login() {
      this.error_message = null;
      await axios.post('/api/v1/extra/auth/credentials',{id: this.id, password: this.password})
        .then(response=>{
          if(response.data.success===true) {
            this.$emit('authorized');
          }
          else {
            this.error_message = "Login failed";

            this.id = '';
            this.password = '';
          }
      }).catch(error => {
        this.error_message = "Login failed";
        this.id = '';
        this.password = '';
      });
    },
    isOpenChanged(val) {
      this.$emit('input', val);
    }
  },
  props: {
    value: Boolean
  },
};
</script>
