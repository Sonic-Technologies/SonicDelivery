(()=>{
    $(document).ready(function(){
        $('.sidenav').sidenav();
        $('select').formSelect();
        $('.tabs').tabs();
        $('.modal').modal();
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
})();