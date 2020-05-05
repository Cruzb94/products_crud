<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h2>Listado de Clientes</h2></div>

                    <div class="card-body">
                      <table class="table" id="table_products">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Image</th>
                            <th scope="col">Opciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="product in products">
                            <th scope="row">{{ product.id }}</th>
                            <td>{{ product.name }}</td>
                            <td>{{ product.stock }}</td>
                            <td v-if="product.imagen !== null"><img :src=" product.imagen " width="100" height="100" alt=""></td>
                            <td v-else="product.imagen == null"><img :src="imagen" width="100" height="100" alt=""></td>
                            <td><a @click="deleteProduct(product.id)"> <span class="fa fa-fw fa-trash"></span> </a> 
                            <a @click="editProduct(product.id)"> <span class="fa fa-edit" data-toggle="modal" data-target="#modal-default"></span> </a> </td>
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
                <h4 class="modal-title">Editar Producto</h4>
              </div>
              <div class="modal-body">
                <form @submit.prevent="updateProduct" action="" enctype="multipart/form-data">
                   <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" v-model="product.name" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="stock">Stock:</label>
                        <input type="text" id="stock" v-model="product.stock" class="form-control">
                   </div>
                   <div class="form-group">
                        <label for="imagen">Imagen:</label>
                        <input type="file" @change="obtenerImagen" class="form-control-file">
                   </div>
                   
                   <figure>
                       <img width="200" height="200" :src="imagen" alt="Foto del producto">
                   </figure> <br>
                   <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
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
            this.getProducts();
        },
        data() { 
            return {
                products: [],
                product: {
                    id: '',
                    name: '',
                    stock: 0,
                    imagen: '' 
                },
                imagenMiniatura: './admin/img/test.png'
            }
        },
        methods: {
            getProducts(){
                axios.get('./getProducts')
                    .then(response => {
                        this.products = response.data;
                        this.tableProducts();
                    });

            },
            tableProducts(){
                $(document).ready( function () {
                    $('#table_products').DataTable();
                });
            },
            deleteProduct(product){
                let result = window.confirm('¿Desea eliminar este producto?');

                if(result){
                    axios.get('./deleteProduct/'+product)
                    .then(response => {
                       if(response.data == 1){
                        alert('Producto eliminado');
                       }else{
                        alert('Error al eliminar');
                       }
                       this.getProducts();
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
                let formData = new FormData();

                if(this.product.name == '' || this.product.stock == ''){
                    alert('Debe rellenar todos los campos');
                }else if(isNaN(this.product.stock)){
                     alert('El campo stock debe ser numerico');
                }else{
                    formData.append('id', this.product.id);
                    formData.append('name', this.product.name);
                    formData.append('stock', this.product.stock);
                    formData.append('imagen', this.product.imagen);

                    axios.post('./updateProduct', formData)
                        .then(response => {
                            // console.log(response.data);
                             alert('Producto actualizado exitosamente');
                            this.getProducts();
                        });
                }   
            },
            editProduct(product){

                axios.get('./getProduct/'+product)
                .then(response => {
                    console.log(response);
                    this.product.id = response.data.id;
                    this.product.name = response.data.name;
                    this.product.stock = response.data.stock;

                    if(response.data.imagen == null){
                        this.imagenMiniatura = './admin/img/test.png';
                    }else{
                        this.imagenMiniatura = response.data.imagen;
                    }
                    

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
