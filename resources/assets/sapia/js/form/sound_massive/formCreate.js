/**
 * Created by jdelacruz on 23/11/2017.
 */

$('#formCreateSoundMassive').submit(function(e) {
  let data = $(this).serialize()
  changeButtonForm('btnForm','btnLoad')
  $.ajax({
    type        : 'POST',
    url         : 'create_sound_massive',
    cache       : false,
    headers     : {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
    data        : data,
    success: function(data){
      if(data.message === 'Success'){
        changeButtonForm('btnLoad','btnForm')
        showNotificacion('success', 'Se ha creado!', 'Success', 2000, false, true)
        clearModal('modalAsterisk', 'div.dialogAsterisk')
        buscar()
      }else{
        showNotificacion('error', 'Ocurrio un problema!', 'Error', 10000, false, true)
      }
      changeButtonForm('btnLoad','btnForm')
    },
    error : function(data) {
      showNotificacion('error', 'Problema al hacer el ajax', 'Error', 10000, false, true)
      changeButtonForm('btnLoad','btnForm')
      showErrorForm(data, '.formError')
    }
  })
  e.preventDefault()
})