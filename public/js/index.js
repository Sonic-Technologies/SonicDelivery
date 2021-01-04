(()=>{

    $(document).ready(function(){
        $('.collapsible').collapsible();
        $('.materialboxed').materialbox();
        $('select').formSelect();
        $('.modal').modal({
            dismissible: false
        });
    });

    const delivery = document.getElementById('delFee');
    const grand = document.getElementById('grand');
    const total = document.getElementById('total');

})();