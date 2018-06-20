/**
 * Created by jdelacruz on 23/11/2017.
 */
$('#formSoundMassiveStatus').submit(function(e) {
    let data = $(this).serialize()
    changeButtonForm('btnForm','btnLoad')
    $.ajax({
        type        : 'POST',
        url         : 'saveformSoundMassiveStatus',
        cache       : false,
        headers     : {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        data        : data,
        success: function(data){
            if(data.message === 'Success'){
                changeButtonForm('btnLoad','btnForm')
                showNotificacion('success', 'Se acaba de activar este masivo con exito !!!', 'Success', 2000, false, true)
                clearModal('modalAsterisk', 'div.dialogAsterisk')
                buscar()
            }else{
                showNotificacion('error', 'Problemas al actualizar el dato en la base de datos', 'Error', 10000, false, true)
            }
            changeButtonForm('btnLoad','btnForm')
        },
        error : function(data) {
            showNotificacion('error', 'Problema al comunicarse con la ruta "saveformSoundMassiveStatus"', 'Error', 10000, false, true)
            changeButtonForm('btnLoad','btnForm')
            showErrorForm(data, '.formError')
        }
    })
    e.preventDefault()
})