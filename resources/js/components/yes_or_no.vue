<template>
  <div class="group-container" :style="{ width: (row ? '150px' : ''), height: (row ? '' : '100px') }">
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
<style>
  .v-input--selection-controls__ripple {
    transform: scale(0.65);
  }
  .v-input--radio-group .v-input__control .v-messages {
    display: none;
  }
</style>
<style scoped>
.group-container {
    display: inline-block;
}
.small{
    max-height: 10px;
}
.small >>> i{
    font-size: 12px;

}
.radio{
    font-size:11px !important;
}
.radio >>>label{
    font-size:12px !important;
}
</style>
