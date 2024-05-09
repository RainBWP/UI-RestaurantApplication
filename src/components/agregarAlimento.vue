<script setup lang="ts">
    import { ref } from "vue";
    import { type ItemShop } from "../interfaces";

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
                    producto_nombre: producto_nombre.value,
                    producto_descripcion: producto_descripcion.value,
                    producto_categoria: producto_categoria.value,
                    producto_precio: producto_precio.value,
                    producto_imagen:producto_imagen.value
                };

                
                // HTTP API REQUEST
                console.log(POST)
                NewItemSended.value = true
                
            } else {
                console.error('Por favor, llene todos los campos excepto la imagen');
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
                <input type="text" id="description" v-model="producto_descripcion"/>

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

<style>
    .overview{
        text-align: center;
        z-index: 20;
        position: absolute;
        padding: 20px;

        border-radius: 3vw;
        background-color: var(--element-background);

        
    }
</style>