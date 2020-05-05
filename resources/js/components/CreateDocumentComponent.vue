<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h2>Registrar nuevo documento</h2></div>

                    <div class="card-body">
                       <form @submit.prevent="addDocument" action="" enctype="multipart/form-data">
                           <div class="form-group">
                                <label for="name">Nombre del documento:</label>
                                <input type="text" id="name" v-model="name_document"  class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="name">Cliente: <button type="button" class="btn btn-default" data-toggle="modal" data-target=".bd-example-modal-lg">Seleccionar</button></label>
                                <input type="text" id="name_client" class="form-control" readonly>
                           </div>
                           <div class="form-group">
                                <label for="stock">Fecha de vencimiento:</label>
                                <input type="date" id="expiration_date" v-model="expiration_date"  class="form-control">
                           </div>
                           <div class="form-group">
                                <label for="stock">Fecha de notificación:</label>
                                <input type="date" id="notification_date" v-model="notification_date"  class="form-control">
                           </div>
                           <div class="form-group">
                              <label>Descripción</label>
                              <textarea class="form-control" rows="3" v-model="description" placeholder=""></textarea>
                            </div>
                           <div class="form-group">
                                <label for="imagen">Archivo:</label>
                                <input type="file" id="document_" @change="obtainFile" class="form-control-file">
                           </div>

                           <button type="submit" class="btn btn-primary">Guardar</button>
                       </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seleccionar cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
               <table class="table" id="table_clients">
                        <thead>
                          <tr>
                            <th style="display:none;"></th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">RFC</th>
                            <th scope="col">CURP</th>
                            <th scope="col">Razón Social</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Tipo Persona</th>
                            <!-- <th scope="col">Opciones</th> -->
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="client in clients">
                            <td style="display:none;">{{ client.id }}</td>
                            <td>{{ client.name }}</td>
                            <td>{{ client.email }}</td>
                            <td>{{ client.phone }}</td>
                            <td>{{ client.rfc }}</td>
                            <td>{{ client.curp }}</td>
                            <td>{{ client.business_name }}</td>
                            <td>{{ client.address }}</td>
                            <td>{{ client.type_person }}</td>
                            <!-- <td><a @click="deleteClient(client.id)"> <span class="fa fa-fw fa-trash"></span> </a> 
                            <a @click="editClient(client.id, client.type_person)"> <span class="fa fa-edit" data-toggle="modal" data-target="#modal-default"></span> </a> </td> -->
                          </tr>
                        </tbody>
                      </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary"  @click="assignClient()" data-dismiss="modal">Continuar</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    import datatables from 'datatables'
    export default {
        mounted(){
            this.getClients();
            // console.log(this.client_selected.id, this.client_selected.name);
        },
        data() {
            return {
                clients: [],
                client_selected: {
                    id: '',
                    name: ''
                },
                name_document: '',
                expiration_date: '',
                notification_date: '',
                description: '',
                document: ''
            }
        },
        methods: {
            getClients(){
                axios.get('./../getClients')
                    .then(response => {
                        console.log(response.data);
                        this.clients = response.data;
                        this.tableClients();
                    });

            },
            tableClients(){
                $(document).ready( function () {
                    var table = $('#table_clients').DataTable();

                    $('#table_clients tbody').on( 'click', 'tr', function () {
                        if ( $(this).hasClass('selected') ) {
                            $(this).removeClass('selected');
                        }
                        else {
                            table.$('tr.selected').removeClass('selected');
                            $(this).addClass('selected');

                            var id = $(this).children('td')[0].innerText;
                            var name = $(this).children('td')[1].innerText;

                            localStorage.setItem('id_selected', id);
                            localStorage.setItem('name_selected', name);
                        }
                    });
                });
            },
            assignClient() {
                this.client_selected.id = localStorage.getItem('id_selected');
                this.client_selected.name = localStorage.getItem('name_selected');
                localStorage.clear();

                document.getElementById('name_client').value = this.client_selected.name;
            },
            obtainFile(e){
                let file = e.target.files[0];
                console.log(file);
                this.document = file;
                // this.cargarImagen(file);
            },
            addDocument(){
                // let person = document.getElementById('type_person').value;
                
                let formData = new FormData();

                   if(this.name_document == '' || this.client_selected.name == '' || this.expiration_date == '' || this.notification_date == '' || this.description == ''){
                        alert('Debe rellenar todos los campos');
                    }else{
                        formData.append('name', this.name_document);
                        formData.append('client_id', this.client_selected.id);
                        formData.append('expiration_date', this.expiration_date);
                        formData.append('reminder_date', this.notification_date);
                        formData.append('description', this.description);
                        formData.append('file', this.document);
                    
                        axios.post('../documents', formData)
                            .then(response => {
                                console.log(response);
                                if(response.data.status == 'error'){
                                    alert(response.data.msg);
                                }

                                if(response.data.status == 'success'){
                                    alert(response.data.msg);
                                    this.name_document = '';
                                    this.client_selected.id = '';
                                    this.client_selected.name = '';
                                    this.expiration_date = '';
                                    this.notification_date = '';
                                    this.description = '';
                                    this.document = '';

                                    document.getElementById('document_').value = '';
                                    document.getElementById('name_client').value = '';
                                }
                        });
                    }
         
            } //fin add document
            
        }
    }
</script>
<style>
.selected{
    background-color: cadetblue;
}
</style>
