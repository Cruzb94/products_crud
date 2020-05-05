<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h2>Listado de Clientes</h2></div>

                    <div class="card-body">
                      <table class="table" id="table_clients">
                        <thead>
                          <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">RFC</th>
                            <th scope="col">CURP</th>
                            <th scope="col">Razón Social</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Tipo Persona</th>
                            <th scope="col">Opciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="client in clients">
                            <td>{{ client.name }}</td>
                            <td>{{ client.email }}</td>
                            <td>{{ client.phone }}</td>
                            <td>{{ client.rfc }}</td>
                            <td>{{ client.curp }}</td>
                            <td>{{ client.business_name }}</td>
                            <td>{{ client.address }}</td>
                            <td>{{ client.type_person }}</td>
                            <td><a @click="deleteClient(client.id)"> <span class="fa fa-fw fa-trash"></span> </a> 
                            <a @click="editClient(client.id, client.type_person)"> <span class="fa fa-edit" data-toggle="modal" data-target="#modal-default"></span> </a> </td>
                          </tr>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-default" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Editar Cliente</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Tipo de persona</label>
                  <select class="form-control" @change="selectForm" id="type_person" disabled="disabled">
                    <option value=""></option>
                    <option value="Fisica">Fisica</option>
                    <option value="Moral">Moral</option>
                  </select>
                </div>
                <form @submit.prevent="updateProduct" action="" enctype="multipart/form-data" id="form_fisica">
                   <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name_fisica" v-model="client_fisico.name" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Teléfono:</label>
                        <input type="text" id="phone_fisica" v-model="client_fisico.phone" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Email:</label>
                        <input type="text" id="email_fisica" v-model="client_fisico.email" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">RFC:</label>
                        <input type="text" id="rfc_fisica" v-model="client_fisico.rfc" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">CURP:</label>
                        <input type="text" id="curp_fisica" v-model="client_fisico.curp" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Dirección:</label>
                        <input type="text" id="address_fisica" v-model="client_fisico.address" class="form-control">
                   </div>

                   <button type="submit" class="btn btn-primary">Guardar</button>
               </form>

               <form @submit.prevent="updateProduct" action="" enctype="multipart/form-data" id="form_moral">
                   <div class="form-group">
                        <label for="name">Nombre Comercial:</label>
                        <input type="text" id="name_moral" v-model="client_moral.name" class="form-control">
                   </div>
                    <div class="form-group">
                        <label for="stock">Teléfono:</label>
                        <input type="text" id="phone_moral" v-model="client_moral.phone" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Email:</label>
                        <input type="text" id="email_moral" v-model="client_moral.email" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">RFC:</label>
                        <input type="text" id="rfc_moral" v-model="client_moral.rfc" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Razón Social:</label>
                        <input type="text" id="business_name_moral" v-model="client_moral.business_name" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Dirección:</label>
                        <input type="text" id="address_moral" v-model="client_moral.address" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Giro:</label>
                        <input type="text" id="turn_moral" v-model="client_moral.turn" class="form-control">
                   </div>

                   <button type="submit" class="btn btn-primary">Guardar</button>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" id="cerrar" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        
    </div>
</template>

<script>
    import datatables from 'datatables'
    export default {
        mounted(){
            this.getClients();
        },
        data: function() { 
            return {
                clients: [],
                client_fisico: {
                    id: '',
                    name: '',
                    phone: '',
                    email: '',
                    rfc: '',
                    curp: '',
                    address:''
                },
                client_moral: {
                    id: '',
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
            getClients(){
                axios.get('./getClients')
                    .then(response => {
                        this.clients = response.data;
                        this.tableClients();
                    });

            },
            tableClients(){
                $(document).ready( function () {
                    $('#table_clients').DataTable();
                });
            },
            deleteClient(client){
                let result = window.confirm('¿Desea eliminar este cliente?');

                if(result){
                    axios.get('./deleteClient/'+client)
                    .then(response => {
                       if(response.data == 1){
                        alert('Cliente eliminado');
                       }else{
                        alert('Error al eliminar');
                       }
                       this.getClients();
                    });
                }else{
                    return false;
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
            updateProduct(){
                let person = document.getElementById('type_person').value;

                let formData = new FormData();

                // if(this.product.name == '' || this.product.stock == ''){
                //     alert('Debe rellenar todos los campos');
                // }else if(isNaN(this.product.stock)){
                //      alert('El campo stock debe ser numerico');
                // }else{
                //     formData.append('id', this.product.id);
                //     formData.append('name', this.product.name);
                //     formData.append('stock', this.product.stock);
                //     formData.append('imagen', this.product.imagen);

                //     axios.post('./updateProduct', formData)
                //         .then(response => {
                //             // console.log(response.data);
                //              alert('Producto actualizado exitosamente');
                //             this.getClients();
                //         });
                // }   

                if(person == 'Fisica'){
                    // console.log(this.client_fisico);
                   if(this.client_fisico.name == '' || this.client_fisico.phone == '' || this.client_fisico.email == '' || this.client_fisico.rfc == '' || this.client_fisico.curp == '' || this.client_fisico.address == ''){
                        alert('Debe rellenar todos los campos');
                    }else{
                        formData.append('id', this.client_fisico.id);
                        formData.append('type_person', person);
                        formData.append('name', this.client_fisico.name);
                        formData.append('phone', this.client_fisico.phone);
                        formData.append('email', this.client_fisico.email);
                        formData.append('rfc', this.client_fisico.rfc);
                        formData.append('curp', this.client_fisico.curp);
                        formData.append('address', this.client_fisico.address);
                    
                        // console.log(formData);
                        axios.post('../updateClient', formData)
                            .then(response => {
                                console.log(response.data);
                                if(response.data.status == 'error'){
                                    alert(response.data.msg);
                                }

                                if(response.data.status == 'success'){
                                    alert(response.data.msg);
                                    this.getClients();
                                    document.getElementById('cerrar').click();
                                }
                                // alert('Cliente creado exitosamente');
                                
                        });
                    }
                }

                if(person == 'Moral'){
                   if(this.client_moral.name == '' || this.client_moral.phone == '' || this.client_moral.email == '' || this.client_moral.rfc == '' || this.client_moral.business_name == '' || this.client_moral.address == ''){
                        alert('Debe rellenar todos los campos');
                    }else{
                        formData.append('id', this.client_fisico.id);
                        formData.append('type_person', person);
                        formData.append('name', this.client_moral.name);
                        formData.append('phone', this.client_moral.phone);
                        formData.append('email', this.client_moral.email);
                        formData.append('rfc', this.client_moral.rfc);
                        formData.append('business_name', this.client_moral.business_name);
                        formData.append('address', this.client_moral.address);
                        formData.append('turn', this.client_moral.turn);
                    
                        console.log(formData);
                        axios.post('../updateClient', formData)
                            .then(response => {
                                console.log(response.data.msg);

                                if(response.data.status == 'error'){
                                    alert(response.data.msg);
                                }

                                if(response.data.status == 'success'){
                                    alert(response.data.msg);
                                    document.getElementById('cerrar').click();
                                    this.getClients();
                                }
                                // alert('Cliente creado exitosamente');
                                
                        });
                    }
                }
            },
            editClient(id_client, type_person){
                // console.log(id_client, type_person);

                document.getElementById('type_person').value = type_person;

                axios.get('./getClient/'+id_client)
                .then(response => {
                    // console.log(response.data);

                    if(type_person == 'Fisica') {
                        this.client_fisico = response.data;
                        document.getElementById('name_fisica').value = response.data.name;
                        document.getElementById('phone_fisica').value  = response.data.phone;
                        document.getElementById('email_fisica').value = response.data.email;
                        document.getElementById('rfc_fisica').value = response.data.rfc;
                        document.getElementById('curp_fisica').value = response.data.curp;
                        document.getElementById('address_fisica').value = response.data.address;

                        document.getElementById('form_moral').style.display = "none";
                        document.getElementById('form_fisica').style.display = "block";
                    }

                    if(type_person == 'Moral') {
                        this.client_moral = response.data;
                        document.getElementById('name_moral').value = response.data.name;
                        document.getElementById('phone_moral').value  = response.data.phone;
                        document.getElementById('email_moral').value = response.data.email;
                        document.getElementById('rfc_moral').value = response.data.rfc;
                        document.getElementById('business_name_moral').value = response.data.business_name;
                        document.getElementById('address_moral').value = response.data.address;
                        document.getElementById('turn_moral').value = response.data.turn;

                        document.getElementById('form_moral').style.display = "block";
                        document.getElementById('form_fisica').style.display = "none";

                    }


                 /*   if(type_person == 'Moral') {
                        this.client_fisico.name = response.data.name;
                        this.client_fisico.phone = response.data.phone;
                        this.client_fisico.email = response.data.email;
                        this.client_fisico.rfc = response.data.rfc;
                        this.client_fisico.curp = response.data.curp;
                        this.client_fisico.address = response.data.address;
                    }

                    if(type_person == 'Fisica') {
                        this.client_fisico.name = response.data.name;
                        this.client_fisico.phone = response.data.phone;
                        this.client_fisico.email = response.data.email;
                        this.client_fisico.rfc = response.data.rfc;
                        this.client_fisico.business_name = response.data.business_name;
                        this.client_fisico.address = response.data.address;
                        this.client_fisico.turn = response.data.turn;
                    }*/
                    // this.client.id = response.data.id;
                    // this.client.name = response.data.name;
                    // this.client.stock = response.data.stock;

                    // if(response.data.imagen == null){
                    //     this.imagenMiniatura = './admin/img/test.png';
                    // }else{
                    //     this.imagenMiniatura = response.data.imagen;
                    // }
                    

                });
            },
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