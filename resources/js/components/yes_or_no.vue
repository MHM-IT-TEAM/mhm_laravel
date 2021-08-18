<template>
  <div class="group-container">
    <v-radio-group :row="this.row" class="mt-0 p-0 small" :value="value" @change="$emit('input', $event)">
        <v-radio class="radio" label="Yes" :value="true"></v-radio>
        <v-radio class="radio" label="No" :value="false"></v-radio>
    </v-radio-group>
  </div>
</template>

<script>
export default {
  name: "yesOrNo",
  data: function () {
    return {}
  },
  props: {
    value: null,
    row: Boolean
  },
};
</script>
<style scoped>
.group-container {
    display: inline-block;
}
.small{
    max-height: 10px;
}
.small >>> i{
    font-size:17px;

}
.radio{
    font-size:11px !important;
}
.radio >>>label{
    font-size:12px !important;
}
</style>