<template>
  <div>
    <v-app>
      <v-data-table
        :headers="headers"
        :items="patients"
        sort-by="calories"
        class="elevation-1"
        :loading="loading"
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Patient list</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="100vw">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  color="teal darken-1"
                  dark
                  class="mb-2"
                  v-bind="attrs"
                  v-on="on"
                  small
                >
                  New Patient
                </v-btn>
              </template>
              <v-card>
                <patient_form
                  :isEdit="isEdit"
                  v-on:close="dialog = false"
                ></patient_form>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">
                    Cancel
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="500px">
              <v-card>
                <v-card-title class="headline"
                  >Are you sure you want to delete this item?</v-card-title
                >
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="closeDelete"
                    >Cancel</v-btn
                  >
                  <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                    >OK</v-btn
                  >
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon small class="mr-2" @click="editItem(item)">
            mdi-pencil
          </v-icon>
          <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
        </template>
        <!---->
      </v-data-table>
    </v-app>
  </div>
</template>
<script>
import patient_form from "./patient_form";
import { mapActions, mapGetters } from "vuex";
export default {
  name: "patient_table",
  components: { patient_form },
  props: ["data", "loading"],
  data: () => ({
    dialog: false,
    dialogDelete: false,
    headers: [
      { text: "Id", value: "id" },
      { text: "First name", value: "firstName" },
      { text: "Last name", value: "lastName" },
      { text: "Address", value: "adress" },
      { text: "Birth date", value: "birthDate" },
      { text: "Tel", value: "tel" },
      { text: "Actions", value: "actions", sortable: false },
    ],
    patients: [],
    isEdit: false,
    editedIndex: -1,
    editedPatient: {
      patId: "",
      firstName: "",
      lastName: "",
      gender: "",
      dob: "",
      martialStatus: "",
      bloodGroup: "",
      nationality: "",
      education: "",
      occupation: "",
      idCard: "",
      idDate: "",
      idPlace: "",
      adress: "",
      tel: "",
      email: "",
      mom_name: "",
      dad_name: "",
      avatar: null,
    },
    defaultPatient: {
      patId: "",
      firstName: "",
      lastName: "",
      gender: "",
      dob: "",
      martialStatus: "",
      bloodGroup: "",
      nationality: "",
      education: "",
      occupation: "",
      idCard: "",
      idDate: "",
      idPlace: "",
      adress: "",
      tel: "",
      email: "",
      mom_name: "",
      dad_name: "",
      avatar: null,
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
    get() {
      return (this.patients = this.data);
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
    data(val) {
      this.patients = val;
    },
  },

  created() {},

  methods: {
    ...mapActions("patient", [
      "selectPatient",
      "resetSelectedPatient",
      "deletePatient",
    ]),
    initialize() {},
    async editItem(item) {
      this.editedIndex = this.patients.indexOf(item);
      this.editedPatient = Object.assign({}, item);
      await this.selectPatient(this.editedPatient);
      this.isEdit = true;
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.patients.indexOf(item);
      this.editedPatient = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.patients.splice(this.editedIndex, 1);
      this.deletePatient(this.editedPatient.id);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedPatient = Object.assign({}, this.defaultPatient);
        this.editedIndex = -1;
      });
      this.isEdit = false;
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.desserts[this.editedIndex], this.editedItem);
      } else {
        this.desserts.push(this.editedItem);
      }
      this.close();
    },
  },
};
</script>
