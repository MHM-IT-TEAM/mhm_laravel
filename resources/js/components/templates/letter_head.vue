<template>
    <div class="content-container">
        <div class="row header">
            <div class="col company">
                <h5>ONG MOBILE HILFE MADAGASKAR</h5>
                Lot 53 Ambovo Ambohidratrimo<br>
                hock@mobile-hilfe-madagaskar.de<br>
                www.mobile-hilfe-madagaskar.de<br>
                NIF: 3000676027  STAT: 94951 11 2011 0 07043<br>
                Tel: 033 84 573 90
            </div>
            <div class="col text-right">
                <img src="/storage/assets/media/images/system/MHMlogo_PRINT.jpg" alt="logo" class="img" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "letter_head"
}
</script>

<style scoped>
.content-container{
    margin:0;
    width:205mm;
    padding:5px;
    font-size: 10px;
}
.company{
    color:#00537f;
}
.img{
    width:220px;
    height:80px;
}
</style>
