/**
 * Created by jdelacruz on 21/09/2017.
 */
$('#formAssignQueues').submit(function(e) {
    let data = $(this).serialize()
    changeButtonForm('btnForm','btnLoad')
    $.ajax({
        type        : 'POST',
        url         : 'saveformassignQueues',
        cache       : false,
        headers     : {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        data        : data,
        success: function(data){
            if(data.message === 'Success'){
                changeButtonForm('btnLoad','btnForm')
                showNotificacion('success', 'Se guardaron las colas en el usuario, exitosamente !!!', 'Success', 2000, false, true)
                clearModal('modalUsers', 'div.dialogUsers')
                buscar()
            }else{
                showNotificacion('error', 'Problemas al actualizar el dato en la base de datos', 'Error', 10000, false, true)
            }
            changeButtonForm('btnLoad','btnForm')
        },
        error : function(data) {
            showNotificacion('error', 'Problema al comunicarse con la ruta "saveformAssignQueues"', 'Error', 10000, false, true)
            changeButtonForm('btnLoad','btnForm')
            showErrorForm(data, '.formError')
        }
    })
    e.preventDefault()
})

$('#formChangePassword').submit(function(e) {
    let data = $(this).serialize()
    changeButtonForm('btnForm','btnLoad')
    $.ajax({
        type        : 'POST',
        url         : 'saveformchangePassword',
        cache       : false,
        headers     : {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        data        : data,
        success: function(data){
            if(data.message === 'Success'){
                changeButtonForm('btnLoad','btnForm')
                vueFront.statusChangePassword = 1
                showNotificacion('success', 'Se cambio la contraseña al usuario correctamente !!!', 'Success', 2000, false, true)
                clearModal('modalUsers', 'div.dialogUsers')
                buscar()
            }else{
                showNotificacion('error', 'Problemas al actualizar el dato en la base de datos', 'Error', 10000, false, true)
            }
            changeButtonForm('btnLoad','btnForm')
        },
        error : function(data) {
            showNotificacion('error', 'Problema al comunicarse con la ruta "saveformchangePassword"', 'Error', 10000, false, true)
            changeButtonForm('btnLoad','btnForm')
            showErrorForm(data, '.formError')
        }
    })
    e.preventDefault()
})

$('#formChangeRole').submit(function(e) {
    let data = $(this).serialize()
    let nameRole = $('input:radio[name=nameRole]:checked').val()
    let userID = $('input:hidden[name=userId]').val()
    changeButtonForm('btnForm','btnLoad')
    $.ajax({
        type        : 'POST',
        url         : 'saveformchangeRole',
        cache       : false,
        headers     : {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        data        : data,
        success: function(data){
            if(data.message === 'Success'){
                changeButtonForm('btnLoad','btnForm')
                clearModal('modalUsers', 'div.dialogUsers')
                showTabListUser('list_users')
                showNotificacion('success', 'El cambio de rol se realizo exitosamente !!!', 'Success', 5000, false, true)
            }else{
                showNotificacion('error', 'Problemas al actualizar el dato en la base de datos', 'Error', 10000, false, true)
            }
            changeButtonForm('btnLoad','btnForm')
        },
        error : function(data) {
            showNotificacion('error', 'Problema al comunicarse con la ruta "saveformchangePassword"', 'Error', 10000, false, true)
            changeButtonForm('btnLoad','btnForm')
            showErrorForm(data, '.formError')
        }
    })
    e.preventDefault()
})

$('#formChangeStatus').submit(function(e) {
    let data = $(this).serialize()
    changeButtonForm('btnForm','btnLoad')
    $.ajax({
        type        : 'POST',
        url         : 'saveformchangeStatus',
        cache       : false,
        headers     : {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        data        : data,
        success: function(data){
            if(data.message === 'Success'){
                changeButtonForm('btnLoad','btnForm')
                showNotificacion('success', 'Se cambio el estado del usuario correctamente !!!', 'Success', 2000, false, true)
                clearModal('modalUsers', 'div.dialogUsers')
                buscar()
            }else{
                showNotificacion('error', 'Problemas al actualizar el dato en la base de datos', 'Error', 10000, false, true)
            }
            changeButtonForm('btnLoad','btnForm')
        },
        error : function(data) {
            showNotificacion('error', 'Problema al comunicarse con la ruta "saveformchangeStatus"', 'Error', 10000, false, true)
            changeButtonForm('btnLoad','btnForm')
            showErrorForm(data, '.formError')
        }
    })
    e.preventDefault()
})