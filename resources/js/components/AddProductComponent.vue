<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h2>Registrar Producto</h2></div>

                    <div class="card-body">
                       <form @submit.prevent="addProduct" action="" enctype="multipart/form-data">
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
                product: {
                    name: '',
                    stock: 0,
                    imagen: ''
                }
            }
        },
        methods: {
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
                let formData = new FormData();

                if(this.product.name == '' || this.product.stock == ''){
                    alert('Debe rellenar todos los campos');
                }else if(isNaN(this.product.stock)){
                    alert('El campo stock debe ser numerico');
                }else{
                    formData.append('name', this.product.name);
                    formData.append('stock', this.product.stock);
                    formData.append('imagen', this.product.imagen);
                
                    axios.post('../products', formData)
                        .then(response => {
                            // console.log(response.data);
                            alert('Producto creado exitosamente');
                            this.product.name = '';
                            this.product.stock = '';
                            this.product.imagen = '';
                    });
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
