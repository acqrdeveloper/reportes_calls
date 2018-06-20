/**
 * Created by jdelacruz on 14/09/2017.
 */
$('#formQueues').submit(function(e) {
    let data = $(this).serialize()
    changeButtonForm('btnForm','btnLoad')
    $.ajax({
        type        : 'POST',
        url         : 'saveformQueues',
        cache       : false,
        headers     : {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        data        : data,
        success: function(data){
            if(data.message === 'Success'){
                changeButtonForm('btnLoad','btnForm')
                let action = (data.action === 'create' ? 'agrego' : 'edito')
                showNotificacion('success', 'Se '+ action +' correctamente la cola !!!', 'Success', 2000, false, true)
                clearModal('modalAsterisk', 'div.dialogAsterisk')
                buscar()
            }else{
                showNotificacion('error', 'Problemas de inserción a la base de datos', 'Error', 10000, false, true)
            }
            changeButtonForm('btnLoad','btnForm')
        },
        error : function(data) {
            showNotificacion('error', 'Problema al comunicarse con la ruta "saveformQueues"', 'Error', 10000, false, true)
            changeButtonForm('btnLoad','btnForm')
            showErrorForm(data, '.formError')
        }
    })
    e.preventDefault()
})

$('#formQueuesStatus').submit(function(e) {
    let data = $(this).serialize()
    changeButtonForm('btnForm','btnLoad')
    $.ajax({
        type        : 'POST',
        url         : 'saveformQueuesStatus',
        cache       : false,
        headers     : {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        data        : data,
        success: function(data){
            if(data.message === 'Success'){
                changeButtonForm('btnLoad','btnForm')
                showNotificacion('success', 'Se cambio el estado de la cola correctamente !!!', 'Success', 2000, false, true)
                clearModal('modalAsterisk', 'div.dialogAsterisk')
                buscar()
            }else{
                showNotificacion('error', 'Problemas al actualizar el dato en la base de datos', 'Error', 10000, false, true)
            }
            changeButtonForm('btnLoad','btnForm')
        },
        error : function(data) {
            showNotificacion('error', 'Problema al comunicarse con la ruta "saveformQueuesStatus"', 'Error', 10000, false, true)
            changeButtonForm('btnLoad','btnForm')
            showErrorForm(data, '.formError')
        }
    })
    e.preventDefault()
})

$('#formAssignUser').submit(function(e) {
    let data = $(this).serialize()
    changeButtonForm('btnForm','btnLoad')
    $.ajax({
        type        : 'POST',
        url         : 'saveformAssignUser',
        cache       : false,
        headers     : {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        data        : data,
        success: function(data){
            if(data.message === 'Success'){
                changeButtonForm('btnLoad','btnForm')
                showNotificacion('success', 'Se guardaron los usuarios en la cola, exitosamente !!!', 'Success', 2000, false, true)
                clearModal('modalAsterisk', 'div.dialogAsteriskLarge')
                buscar()
            }else{
                showNotificacion('error', 'Problemas al actualizar el dato en la base de datos', 'Error', 10000, false, true)
            }
            changeButtonForm('btnLoad','btnForm')
        },
        error : function(data) {
            showNotificacion('error', 'Problema al comunicarse con la ruta "saveformUsersQueues"', 'Error', 10000, false, true)
            changeButtonForm('btnLoad','btnForm')
            showErrorForm(data, '.formError')
        }
    })
    e.preventDefault()
})