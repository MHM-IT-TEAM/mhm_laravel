window.addEventListener('DOMContentLoaded',function(){
    //fetchDue()
})
async function showDetail(id){
    $("#care_detail tbody").html("")
    let response= await axios.get(`/api/cash/details/${id}`)
    let table= document.getElementById('care_detail')
    if(table.rows.length===1){
        response.data.forEach(res=>{
            let i=1
            let row= table.insertRow(i)
            row.insertCell(0).innerHTML=res.service_prices.name
            row.insertCell(1).innerHTML=res.service_prices.price
            row.insertCell(2).innerHTML=res.qty
            row.insertCell(3).innerHTML=res.total
            i++
        })
    }
}
function newDueSum(){
    var total= $("#toPay").val()
    var total= $("#toPays").val()
    var paid= $("#paid").val()
    var newDue= parseInt(total)-parseInt(paid)
    $("#new_due").val(newDue)
    $("#new_dues").val(newDue)
}

