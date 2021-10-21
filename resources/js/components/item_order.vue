<template>
    <div class="container">
        <h2 class="text-center title"> Order for medicines & consumables </h2>
        <div class="border table-container position-relative">
            <table class="table table-sm table-borderless" id="out_details">
                <thead>
                <th colspan="2" style="width:60%">Item</th>
                <th>Quantity in Stock</th>
                <th>Quantity to order</th>
                <th>Action</th>
                </thead>
                <tbody>
                <tr class="table-border" >
                    <td colspan="2">
                        <multiselect
                            v-model="accessory.line.item"
                            label="description"
                            track-by="description"
                            :id="'multiSelect'"
                            open-direction="below"
                            :options="accessory.medicines_temp_list"
                            :searchable="true"
                            :internal-search="false"
                            :clear-on-select="true"
                            :close-on-select="true"
                            :show-no-results="false"
                            :hide-selected="true"
                            @search-change="fetchMedicine"
                            class="multiSelect"
                            autocomplete="off"
                        >
                        </multiselect>
                    </td>
                    <td>
                        <div class="text-center">
                            <input type="number" class="form-control" disabled v-model="accessory.line.item.inventory.graceCenter"/>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control" v-model="accessory.line.qty" @keypress.enter="add_row"/>
                    </td>
                    <td></td>
                </tr>
                <tr v-for="(line,i) in formData.items" v-if="formData.items.length>0">
                    <td colspan="2">
                        [ &nbsp {{line.item.code}} &nbsp] {{line.item.description}}
                    </td>
                    <td>
                        {{line.item.inventory.graceCenter}}
                    </td>
                    <td>
                        {{line.qty}}
                    </td>
                    <td>
                        <v-btn small color="warning" @click="delete_row(i)" text>
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="remark p-2">
                <div class="form-group">
                    <label>Remark</label>
                    <textarea class="form-control" v-model="formData.remark"/>
                </div>
            </div>
            <div class="text-right position-absolute submit-container">
                <v-btn
                    @click="submit"
                    :color="accessory.form_submitted ? 'success' : 'warning'"
                    x-small
                    v-if="!accessory.form_submitted"
                    :loading="accessory.form_is_submitting"
                >
                    Submit
                </v-btn>
                <v-chip
                    class="ma-2"
                    color="green"
                    text-color="white"
                    v-if="accessory.form_submitted"
                >
                    Submitted
                </v-chip>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "item_order",
    data(){
        return{
            formData:{
                orderer_id:'',
                items:[],
                remark:''
            },
            accessory:{
                line:{
                    item:{inventory:{}},
                    qty:'',
                },
                medicines_temp_list: [],
                form_is_submitting: false,
                form_submitted:false
            }
        }
    },
    methods:{
        async fetchMedicine(code) {
            this.accessory.medicines_temp_list = [];
            if (code.length > 2) {
                await axios({
                    method: 'GET',
                    url: '/api/v1/inventory_system/item',
                    params: {search_text: code},
                }).then((response) => {
                    this.accessory.medicines_temp_list = response.data.data
                });
            }
        },
        add_row(){
            if(this.accessory.line.qty !==''){
                this.formData.items.push(
                    {item:this.accessory.line.item,qty:this.accessory.line.qty}
                )
                this.accessory.line={item:{inventory:{}}, qty:''}
            }
        },
        delete_row(i){
            this.formData.items.splice(i,1)
        },
        submit(){
            this.accessory.form_is_submitting=true
        }

    }
}
</script>

<style scoped>
.title{
    color:white;
    background-color: #1390C6;
    font-weight:bold;
}
.subtitle{
    color:#1390C6;
    font-weight: bold;
}
.btn{
    color:white;
    background-color: #1390C6;
}
.result{
    width:50px;
}
.form-title{
    font-family: 'Enriqueta', arial, serif;
    line-height: 1.25;
    margin: 0 0 10px; font-size: 40px;
    font-weight: bold;
    color: #7c795d;
}
.table-container{
    min-height: 90vh;
}
.submit-container{
    bottom:10px;
    right:10px;
}
</style>
