$(document).ready(function () {

    $('.btn-eliminar').click(function(){

            var row=$(this).parents('tr');
            var id=row.data('id');
            var form= $('#eliminar_data');
            var url=form.attr('action').replace(':USER_ID',id);
            var data=form.serialize();


        $.post(url,data,function(result){
            if(result==0){

                alertify.error("No se puede eliminar un ticket Padre");
            }else{

                alertify.success(result);
                row.fadeOut();
            }


        });
    });
    $('.btn-eliminar_aplicativo').click(function(){

        var row=$(this).parents('tr');
        var id=row.data('id_ticket');
        var id_aplicativo=row.data('id_aplicativo');
        var form= $('#eliminar_data');
        var url=form.attr('action').replace(':TICKET_ID',id).replace(':APLICATIVO_ID',id_aplicativo);
        var data=form.serialize();

        $.post(url,data,function(result){

            if(result=='No se pudo eliminar el aplicativo del ticket'){

                alertify.error(result);
            }else{

                alertify.success(result);
                row.fadeOut();
            }
        });

    });
    $('.form-control').change(function(){
        var id= $('#areas').val();
        var url="aplicativoConsulta/"+id;
        $.ajax({
            type: "GET",
            url: url,
            success: function(a) {
                $( ".table-responsive" ).html( a );
            }
        });

    });
    $('#registrar').click(function(){
        var id= $('#areas').val();
        var url="aplicativoFaltante/"+id;
        $.ajax({
            type: "GET",
            url: url,
            success: function(result) {

              $("#combobox" ).html(result);
                $('#form_aplicativo').fadeIn('slow');
            }
        });

        return false;
    });
    $('#cerrarPupUPApli').click(function(){

        $('#form_aplicativo').fadeOut('slow');

    });
    $('.close').click(function(){
        $('#form_aplicativo').fadeOut('slow');

    });
    $('#guardarDatoss').click(function(){

        var id= $('#areas').val();
        var id_aplicativo=$('#aplicativo').val();
        var form= $('#guardar_data');
        var url=form.attr('action').replace(':AREA_ID',id).replace(':APLICATIVO_ID',id_aplicativo);
        var data=form.serialize();
        $.post(url,data,function(result){

            if(result=='0'){

                alertify.error(result);
            }else{

                $( ".table-responsive" ).html( result );
                $('#form_aplicativo').fadeOut('slow');
            }
        });
    });
    $('.btn-eliminar').click(function(){

        var row=$(this).parents('tr');
        var id=row.data('id');
        var idArea= $('#areas').val();
        var form= $('#eliminar_data');
        var url=form.attr('action').replace(':ID',id).replace(':AREA_ID',idArea);
        var data=form.serialize();
        $.post(url,data,function(result){

            if(result=='0'){

                alertify.error("no se pudo eliminar");
            }else{

                $( ".table-responsive" ).html( result );
                $('#form_aplicativo').fadeOut('slow');
            }
        });


    });
});