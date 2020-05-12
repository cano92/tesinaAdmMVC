$(document).ready( function () {
    $('#table_id').DataTable();
    } );


function confirmarEliminarUser(){ 
        if (confirm('¿Estas seguro de eliminar el usuario?')){ 
           document.tuformulario.submit() 
        } 
} 
