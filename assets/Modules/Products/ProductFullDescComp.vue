<template>
    <div id="description" class="mt-4 container container-color">
            <div class="row mb-4">
                <h3>Description </h3>
            </div>
           <div class="row">
               <div class="col-10">
                   <span v-text="this.descrText"></span>
               </div>
           </div>

    </div>
</template>
<script>
export default {
    name: "ProductFullDescComp",
    props:['productDesc'],
    data(){
        return {
            descrText:  '',
        }
    },
    watch: {
        'productDesc': {
            handler(value) {
                this.descrText = value.FullDescription
            }
        }
    },
}
</script>

<style scoped>

</style>