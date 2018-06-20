@include('layout.plugins.css-datepicker')
<form id="formPerfil" enctype="multipart/form-data" method="POST">
    <div id="divProfile" class="box box-primary">
        <div role="tab" id="headingOne" class="box-header">
            <h4 class="box-title"><b>Edit Profile</b></h4>
        </div>

        <div class="panel-collapse collapse in">
            <div class="box-body">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <center><b>Datos Personales</b></center>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstName">Primer Nombre:</label>
                                            <input type="text" id="firstName" class="form-control" style="border-radius: 7px;" v-model="firstName" onkeypress="return filterLetter(event)" onkeydown="return BlockCopyPaste(event)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="numberDni">DNI:</label>
                                            <input type="text" id="numberDni" class="form-control" style="border-radius: 7px;" v-model="numberDni" onkeypress="return filterNumber(event)" onkeydown="return BlockCopyPaste(event)" maxlength="8">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="secondName">Segundo Nombre:</label>
                                            <input type="text" id="secondName" class="form-control" style="border-radius: 7px;" v-model="secondName" onkeypress="return filterLetter(event)" onkeydown="return BlockCopyPaste(event)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="numberTelephone">Telefono:</label>
                                            <input type="text" id="numberTelephone" class="form-control" style="border-radius: 7px;" v-model="numberTelephone" onkeypress="return filterNumber(event)" onkeydown="return BlockCopyPaste(event)" maxlength="9">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstLastName">Apellido Paterno:</label>
                                            <input type="text" id="firstLastName" class="form-control" style="border-radius: 7px;" v-model="firstLastName" onkeypress="return filterLetter(event)" onkeydown="return BlockCopyPaste(event)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="idSex">Sexo:</label>
                                            <div style="margin-top: 5px;">
                                                <input type="radio" id="M" value="M" v-model="idSex"> M
                                                <input type="radio" id="F" value="F" v-model="idSex"> F
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="secondLastName">Apellido Materno:</label>
                                            <input type="text" id="secondLastName" class="form-control" style="border-radius: 7px;" v-model="secondLastName" onkeypress="return filterLetter(event)" onkeydown="return BlockCopyPaste(event)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birthdate">Fecha de Nacimiento:</label>
                                            <input name="birthdate" type="text" id="birthdate" class="id_fecha_conocimiento form-control" style="border-radius: 7px;" v-model="birthdate" onkeydown="return BlockCopyPaste(event)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div>
                                    <img :src="'storage/' + srcAvatar"  class="img-responsive img-rounded" style="margin: 0px auto; float: none !important;">
                                </div>
                                <br>
                                <input type="file" name="imgAvatar" class="form-control" style="border-radius: 7px;" accept="image/*">
                                <input type="text" name="imgAvatarOriginal" class="form-control" style="border-radius: 7px;visibility: hidden;" v-model="srcAvatarOriginal">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <center><b>Credenciales</b></center>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userName">Usuario:</label>
                                    <input type="text" id="userName" disabled class="form-control" style="border-radius: 7px;" v-model="userName">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="passWord">Contraseña:</label>
                                    <input type="password" id="passWord" disabled class="form-control" style="border-radius: 7px;" v-model="passWord">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <center><b>Ubigueo</b></center>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nomDepartamento">Departamento:</label>
                                    <v-select id="nomDepartamento" :on-change="loadProvincia"  :value.sync="selectedD" :options="departamento" placeholder="Choose here..!!"></v-select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nomProvincia">Provincia:</label>
                                    <v-select id="nomProvincia" :on-change="loadDistrito" :value.sync="selectedP" :options="provincia" placeholder="Choose here..!!"></v-select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nomDistrito">Distrito:</label>
                                    <v-select id="nomDistrito" :on-change="getDistrito" :value.sync="selectedDi" :options="distrito" placeholder="Choose here..!!"></v-select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <input type="text" id="idProfile" class="form-control" style="border-radius: 7px;visibility: hidden" v-model="idProfile" hidden>
                <input type="submit" value="Editar Perfil" class="btn btn-success pull-right">
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</form>
{!!Html::script('js/profileuserVue.min.js')!!}
@include('layout.plugins.js-datepicker')
