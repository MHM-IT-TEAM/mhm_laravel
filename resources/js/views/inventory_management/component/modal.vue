<template>
    <div class="modal fade" id="vueModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Reminder</h5>
                    <button type="button" class="close btn btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot name="content"></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeModal">cancel</button>
                    <button type="button" class="btn btn-danger" @click="proceed" data-bs-dismiss="modal">continue</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
let bootstrap=require('bootstrap')
export default {
    name: "modal",
    props:['active'],
    data(){
        return {
            modal_active:''
        }
    },
    watch:{
        active(val){
            return this.openModal()
        },
    },
    methods:{
        openModal(){
            let modal =  new bootstrap.Modal(document.getElementById('vueModal'))
            modal.show()
        },
        closeModal(){
            let modal =  new bootstrap.Modal(document.getElementById('vueModal'))
            modal.hide()
            this.modal_active=0
        },
        proceed(){
            this.$emit('proceed',true)
        }
    }
}
</script>

<style scoped>

</style>
