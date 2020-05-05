<template>
    <div class="container">
        <div class="row justify-content-center"> 
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h2>Registrar Cliente</h2></div>
                    <div class="form-group">
                      <label>Tipo de persona</label>
                      <select class="form-control" @change="selectForm" id="type_person">
                        <option value=""></option>
                        <option value="Fisica">Fisica</option>
                        <option value="Moral">Moral</option>
                      </select>
                    </div>
                    <div class="card-body">
                       <form @submit.prevent="addProduct" action="" enctype="multipart/form-data" id="form_fisica">
                           <div class="form-group">
                                <label for="name">Nombre:</label>
                                <input type="text" id="name" v-model="client_fisico.name" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">Teléfono:</label>
                                <input type="text" id="phone" v-model="client_fisico.phone" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">Email:</label>
                                <input type="text" id="email" v-model="client_fisico.email" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">RFC:</label>
                                <input type="text" id="rfc" v-model="client_fisico.rfc" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">CURP:</label>
                                <input type="text" id="curp" v-model="client_fisico.curp" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">Dirección:</label>
                                <input type="text" id="address" v-model="client_fisico.address" class="form-control">
                           </div>

                           <button type="submit" class="btn btn-primary">Guardar</button>
                       </form>

                       <form @submit.prevent="addProduct" action="" enctype="multipart/form-data" id="form_moral">
                           <div class="form-group">
                                <label for="name">Nombre Comercial:</label>
                                <input type="text" id="name" v-model="client_moral.name" class="form-control">
                           </div>
                            <div class="form-group">
                                <label for="stock">Teléfono:</label>
                                <input type="text" id="phone" v-model="client_moral.phone" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">Email:</label>
                                <input type="text" id="email" v-model="client_moral.email" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">RFC:</label>
                                <input type="text" id="rfc" v-model="client_moral.rfc" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">Razón Social:</label>
                                <input type="text" id="business_name" v-model="client_moral.business_name" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">Dirección:</label>
                                <input type="text" id="address" v-model="client_moral.address" class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">Giro:</label>
                                <input type="text" id="turn" v-model="client_moral.turn" class="form-control">
                           </div>

                           <button type="submit" class="btn btn-primary">Guardar</button>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                imagenMiniatura: '../admin/img/test.png',
                url: '',
                client_fisico: {
                    name: '',
                    phone: '',
                    email: '',
                    rfc: '',
                    curp: '',
                    address:''
                },
                client_moral: {
                    name: '',
                    phone: '',
                    email: '',
                    rfc: '',
                    business_name: '',
                    address:'',
                    turn: ''
                }
            }
        },
        methods: {
            selectForm(e){

                if(e.target.value == ''){
                    document.getElementById('form_moral').style.display = "none";
                    document.getElementById('form_fisica').style.display = "none";
                }


                if(e.target.value == 'Fisica'){
                    document.getElementById('form_moral').style.display = "none";
                    document.getElementById('form_fisica').style.display = "block";
                }

                if(e.target.value == 'Moral'){
                    document.getElementById('form_moral').style.display = "block";
                    document.getElementById('form_fisica').style.display = "none";
                }
            },
            obtenerImagen(e){
                let file = e.target.files[0];
                // console.log(file);
                this.product.imagen = file;
                this.cargarImagen(file);
            },
            cargarImagen(file){
                let reader = new FileReader();

                reader.onload = (e) => {
                    this.imagenMiniatura = e.target.result;
                }

                reader.readAsDataURL(file);
            },
            addProduct(){
                let person = document.getElementById('type_person').value;
                
                let formData = new FormData();

                if(person == 'Fisica'){
                   if(this.client_fisico.name == '' || this.client_fisico.phone == '' || this.client_fisico.email == '' || this.client_fisico.rfc == '' || this.client_fisico.curp == '' || this.client_fisico.address == ''){
                        alert('Debe rellenar todos los campos');
                    }else{
                        formData.append('type_person', person);
                        formData.append('name', this.client_fisico.name);
                        formData.append('phone', this.client_fisico.phone);
                        formData.append('email', this.client_fisico.email);
                        formData.append('rfc', this.client_fisico.rfc);
                        formData.append('curp', this.client_fisico.curp);
                        formData.append('address', this.client_fisico.address);
                    
                        axios.post('../clients', formData)
                            .then(response => {
                                console.log(response.data);
                                if(response.data.status == 'error'){
                                    alert(response.data.msg);
                                    this.client_fisico.name = '';
                                    this.client_fisico.phone = '';
                                    this.client_fisico.email = '';
                                    this.client_fisico.rfc = '';
                                    this.client_fisico.curp = '';
                                    this.client_fisico.address = '';
                                }

                                if(response.data.status == 'success'){
                                    alert(response.data.msg);
                                    this.client_fisico.name = '';
                                    this.client_fisico.phone = '';
                                    this.client_fisico.email = '';
                                    this.client_fisico.rfc = '';
                                    this.client_fisico.curp = '';
                                    this.client_fisico.address = '';
                                }
                                // alert('Cliente creado exitosamente');
                                
                        });
                    }
                }

                if(person == 'Moral'){
                   if(this.client_moral.name == '' || this.client_moral.phone == '' || this.client_moral.email == '' || this.client_moral.rfc == '' || this.client_moral.business_name == '' || this.client_moral.address == ''){
                        alert('Debe rellenar todos los campos');
                    }else{
                        formData.append('type_person', person);
                        formData.append('name', this.client_moral.name);
                        formData.append('phone', this.client_moral.phone);
                        formData.append('email', this.client_moral.email);
                        formData.append('rfc', this.client_moral.rfc);
                        formData.append('business_name', this.client_moral.business_name);
                        formData.append('address', this.client_moral.address);
                        formData.append('turn', this.client_moral.turn);
                    
                        axios.post('../clients', formData)
                            .then(response => {
                                console.log(response.data.msg);

                                if(response.data.status == 'error'){
                                    alert(response.data.msg);
                                    this.client_moral.name = '';
                                    this.client_moral.phone = '';
                                    this.client_moral.email = '';
                                    this.client_moral.rfc = '';
                                    this.client_moral.business_name = '';
                                    this.client_moral.address = '';
                                    this.client_moral.turn = '';
                                }

                                if(response.data.status == 'success'){
                                    alert(response.data.msg);
                                    this.client_moral.name = '';
                                    this.client_moral.phone = '';
                                    this.client_moral.email = '';
                                    this.client_moral.rfc = '';
                                    this.client_moral.business_name = '';
                                    this.client_moral.address = '';
                                    this.client_moral.turn = '';
                                }
                                // alert('Cliente creado exitosamente');
                                
                        });
                    }
                }
         
            }

        },
        computed: {
            imagen(){
                return this.imagenMiniatura;
            }
        }
    }
</script>
<style>
#form_fisica{
    display: none;
}

#form_moral{
    display: none;
}
</style>
