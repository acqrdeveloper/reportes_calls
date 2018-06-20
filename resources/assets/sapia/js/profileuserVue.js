Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="_token"]').getAttribute('content')
Vue.component('v-select', VueSelect.VueSelect)

var ubigeoID = ''
var idDepartamentoProfile = ''
var idProvinciaProfile = ''
var idDistritoProfile = ''

var vmProfile = new Vue({
  el: '#divProfile',
  data: {
    selectedD: null,
    selectedP: null,
    selectedDi: null,
    departamento: [],
    provincia: [],
    distrito: [],
    firstName: '-',
    numberDni: '-',
    secondName: '-',
    numberTelephone: '-',
    firstLastName: '-',
    secondLastName: '-',
    birthdate: '',
    userName: '-',
    passWord: '-',
    srcAvatar: 'default_avatar.png',
    srcAvatarOriginal: 'default_avatar.png',
    idSex: '-',
    idProfile: '-',
    oldDepartamento: '',
    oldProvincia: ''
  },
  mounted () {
    this.loadData()
  },
  methods: {
    loadData: function () {
      vueFront.ModalLoading = 'modal show'
      let userId = vueFront.getUserId
      let parameters = { userID: userId }
      this.$http.post('viewUsers', parameters).then(response => {
                /* Data tabla users */
        vueFront.ModalLoading = 'modal fade'
        this.firstName = response.body[0].primer_nombre
        this.secondName = response.body[0].segundo_nombre
        this.firstLastName = response.body[0].apellido_paterno
        this.secondLastName = response.body[0].apellido_materno
        this.userName = response.body[0].username
        this.passWord = '-----------------------'
        this.loadDepartamento()
                /* Data tabla users_profile */
        let profile_user = response.body[0].user_profile
        if (profile_user) {
          this.numberDni = profile_user.dni
          this.numberTelephone = profile_user.telefono
          this.birthdate = profile_user.fecha_nacimiento
          this.birthdate = profile_user.fecha_nacimiento
          this.idSex = profile_user.Sexo
          vueFront.srcAvatar = profile_user.avatar
          this.srcAvatar = profile_user.avatar
          this.srcAvatarOriginal = profile_user.avatar
          this.idProfile = profile_user.id
          ubigeoID = profile_user.ubigeo_id
          this.$nextTick(() => {
            this.loadSelect()
          })
        }
      }, response => {
        console.log(response.body)
      })
    },
    loadDepartamento: function () {
      this.$http.post('viewDepartamento').then(response => {
        let arraydepartamento = []
        let objectSearch = 'departamento'
        objectToArray(response.body, arraydepartamento, objectSearch)
        this.departamento = arraydepartamento
      }, response => console.log(response.body))
    },
    loadProvincia: function (nameDepartamento) {
      if (this.oldDepartamento != nameDepartamento) { this.selectedP = '' }
      idDepartamentoProfile = nameDepartamento
      let parameters = { Departamento: nameDepartamento }
      this.$http.post('viewProvincia', parameters).then(response => {
        let arrayprovincia = []
        let objectSearch = 'provincia'
        objectToArray(response.body, arrayprovincia, objectSearch)
        this.provincia = arrayprovincia
      }, response => console.log(response.body))
    },
    loadDistrito: function (nameProvincia) {
      if (this.oldProvincia != nameProvincia) { this.selectedDi = '' }
      idProvinciaProfile = nameProvincia
      let parameters = { Provincia: nameProvincia }
      this.$http.post('viewDistrito', parameters).then(response => {
        let arraydistrito = []
        let objectSearch = 'distrito'
        objectToArray(response.body, arraydistrito, objectSearch)
        this.distrito = arraydistrito
      }, response => console.log(response.body))
    },
    getDistrito: function (nameDistrito) {
      idDistritoProfile = nameDistrito
    },
    loadSelect: function () {
      let parameters = { idUbigeo: ubigeoID }
      this.$http.post('viewUbigeo', parameters).then(response => {
        if (response.body[0]) {
          this.oldDepartamento = response.body[0].departamento
          this.selectedD = response.body[0].departamento
          this.oldProvincia = response.body[0].provincia
          this.selectedP = response.body[0].provincia
          this.selectedDi = response.body[0].distrito
        }
      }, response => console.log(response.body))
    }
  }
})

$('#formPerfil').submit(function (event) {
  const userID = vueFront.getUserId
  let form = new FormData()
  form.append('userId', userID)
  form.append('firstName', $('input[id=firstName]').val())
  form.append('numberDni', $('input[id=numberDni]').val())
  form.append('secondName', $('input[id=secondName]').val())
  form.append('imgAvatar', $('input[name=imgAvatar]')[0].files[0])
  form.append('imgAvatarOriginal', $('input[name=imgAvatarOriginal]').val())
  form.append('numberTelephone', $('input[id=numberTelephone]').val())
  form.append('firstLastName', $('input[id=firstLastName]').val())
  form.append('secondLastName', $('input[id=secondLastName]').val())
  form.append('idSex', $('input[type=radio]').val())
  form.append('userName', $('input[id=userName]').val())
  form.append('birthdate', $('input[id=birthdate]').val())
  form.append('idDepartamento', idDepartamentoProfile)
  form.append('idProvincia', idProvinciaProfile)
  form.append('idDistrito', idDistritoProfile)
  form.append('idProfile', $('input[id=idProfile]').val())

  $.ajax({
    url: 'uploadPerfil',
    data: form,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    beforeSend: (xhr) => {
      const token = $('input[name=_token]').val()
      if (token) {
        return xhr.setRequestHeader('X-CSRF-TOKEN', token)
      }
    },
    success: (data) => {
      vmProfile.loadData()
      vueFront.ModalLoading = 'modal show'
      if (data === 'Ok') {
        setTimeout(function () {
          showNotificacion('success', 'Se edito tu perfil con exito !', 'Success', 2000, false, true)
          vueFront.ModalLoading = 'modal fade'
        }, 1500)
      } else if (data === 'NotImage') {
        showNotificacion('error', 'Solo esta permitida la subida de imagenes en el avatar', 'Error', 4000, false, true)
        vueFront.ModalLoading = 'modal fade'
      } else {
        showNotificacion('error', 'Error al editar el perfil', 'Error', 2000, false, true)
        vueFront.ModalLoading = 'modal fade'
      }
    }
  })
  event.preventDefault()
})

$('#formPerfil').keypress(function (e) {
  if (e.which == 13) {
    return false
  }
})

function objectToArray (object, array, value) {
  object.forEach((item, index) => array.push(item[value]))
}
