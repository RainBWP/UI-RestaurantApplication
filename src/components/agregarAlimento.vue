<script setup lang="ts">
    import { ref } from "vue";
    import { type ItemShop } from "../interfaces";
    import axios from 'axios';

    interface promps {
        ReloadItemShopArray:Function
        HideMe:Function,
        isRestaurant:boolean
    }

    const promps = defineProps<promps>()

    const producto_nombre = ref('');
    const producto_descripcion = ref('')
    const producto_categoria = ref('')
    const producto_imagen = ref('')
    const producto_precio = ref(0)

    const NewItemSended = ref(false)
    const sendNewItem = (isRestaunrat:boolean) => {
        // console.log(isRestaunrat)
        if (isRestaunrat) {
            if (producto_nombre.value !== '' && producto_descripcion.value !== '' && producto_categoria.value !== '' && producto_precio.value !== 0) {
                
                // formateamos el numero
                const precioString = producto_precio.value.toString();
                if (precioString.includes('.')) {
                    const precioPartes = precioString.split('.');
                    const precioSinDecimal = precioPartes[0] + (precioPartes[1].length > 2 ? precioPartes[1].substring(0, 2) : precioPartes[1]);
                    producto_precio.value = parseInt(precioSinDecimal);
                }else{
                    producto_precio.value = parseInt(precioString + '00');
                }

                const POST = {
                    tipo: "Producto",
                    producto_nombre: producto_nombre.value,
                    producto_descripcion: producto_descripcion.value,
                    producto_categoria: producto_categoria.value,
                    producto_precio: producto_precio.value,
                    producto_imagen:producto_imagen.value,
                    id_negocio: 1 //El id dependerá del negocio, para pruebas se usa el valor estatico 1
                };

                
                // HTTP API REQUEST
                //console.log(POST)

                axios.post('http://localhost/AppVue/', POST)
                    .then(response => {
                        //console.log(response.data);
                        
                        if (response.data === 'success') {
                            console.log(POST)
                            NewItemSended.value = true
                            //emit('registroCompleto', true);
                            //alert('Registro de producto exitoso');
                        } else {
                            alert('Error al registrar producto. Por favor, inténtalo de nuevo.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al Registrar Producto. Por favor, inténtalo de nuevo.');
                    });

                //NewItemSended.value = true
                
            } else {
                alert('Todos los campos con * son obligatorios');
            }


            
        }else{
            console.error('nah u wont')
        }
        
    }
</script>

<template>
    <div class="overview">
        <div v-if="!NewItemSended">
            <h2>Agregar Nuevo Item</h2>
            <form @submit.prevent="sendNewItem(isRestaurant)">
                <label for="product_name">*Nombre del Producto</label>
                <input type="text" id="product_name" v-model="producto_nombre" required/>

                <label for="description">*Descripción del Producto</label>
                <input type="text" id="description" v-model="producto_descripcion" required/>

                <label for="precio">*Precio del Producto</label>
                <input type="number" id="precio" v-model="producto_precio" required/>

                <label for="categoria">*Categoría del Producto</label>
                <input type="text" id="categoria" v-model="producto_categoria" required/>

                <label for="image_url">Link de la Imagen</label>
                <input type="url" id="image_url" v-model="producto_imagen"/>
            </form>
            <div>
                <button @click="sendNewItem(isRestaurant)">Agregar Nuevo Item</button>
                <button @click="HideMe()">Cancelar</button>
            </div>
        </div>
        <div v-else>
            <h2>Se ha enviado el Producto: </h2>
            <p><b>Nombre:</b> {{ producto_nombre }}</p>
            <p><b>Descripcion:</b> {{ producto_descripcion }}</p>
            <p><b>Categoria:</b> {{ producto_categoria }}</p>
            <p><b>Precio:</b> ${{ (producto_precio/100).toFixed(2) }}</p>
            <p><b>Imagen:</b> {{ producto_imagen }}</p>
            <button @click="HideMe()">Regresar</button>
        </div>
    </div>
</template>

<style scoped>
</style>