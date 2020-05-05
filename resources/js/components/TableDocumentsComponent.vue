<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h2>Listado de Documentos</h2></div>

                    <div class="card-body">
                      <table class="table" id="table_clients">
                        <thead>
                          <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Archivo</th>
                            <th scope="col">Fecha de vencimiento</th>
                            <th scope="col">Fecha de notificación</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Opciones</th>
                          </tr>
                        </thead>
                        <tbody>
                         <!--  <tr v-for="client in clients">
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
                          </tr> -->
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>

        

        
    </div>
</template>

