jQuery(document).ready(function(){
    var sum = 0;
    // iterate through each td based on class and add the values
    $(".price").each(function() {

        var value = $(this).text();
        // add only if the value is number
        if(!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
        }
    });
    $(".sumResult").text(sum+".00");
    
});
function formatDollar(num) {
    var p = parseFloat(num).toFixed(2).split(".");
    return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? "" : "") + acc;
    }, "") + "." + p[1];
}
  
function updateTextInput(val) {
    var format = formatDollar(val);
    document.getElementById('cash').value=format; 
}
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
$(function() {
    $( "#datepicker" ).datepicker({
        dateFormat: 'dd-mm-y'
    });
});
function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}