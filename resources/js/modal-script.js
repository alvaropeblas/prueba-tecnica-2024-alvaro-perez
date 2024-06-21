document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('diasFestivosLink').addEventListener('click', function (event) {
        event.preventDefault(); 
        $('#diasFestivosModal').modal('show'); 
    });
});
