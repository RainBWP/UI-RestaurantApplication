<script setup lang="ts">
    import { ref } from "vue";
    import { type ItemShop } from "../interfaces";
    import axios from 'axios';

    interface promps {
        ReloadItemShopArray:Function
        HideMe:Function,
        isRestaurant:boolean,
        itemShopArray:ItemShop[],
    }

    const promps = defineProps<promps>()

    const producto_id = ref<ItemShop>();
    

    const confirmDelete = ref(false)
    const sendConfirmDelete = () => {
        confirmDelete.value = !confirmDelete.value
    }

    const deletedSended = ref(false)
    const sendDeletedSended = () =>{
        deletedSended.value = true
        confirmDelete.value = false
    }

    const deleteNewItem = (isRestaunrat:boolean) => {
        // console.log(isRestaunrat)
        if (isRestaunrat) {
            axios.delete("http://localhost/AppVue/?producto_id="+4) //producto_id equivale a id_menu en la tabla Menu, usar el id correspondiente en la tabla
                    .then(response => {
                        //console.log(response.data);
                        
                        if (response.data === 'success') {
                            // cuando la peticion se envie con exito ejecutar esto
                            sendDeletedSended()
                            promps.ReloadItemShopArray()
                        } else {
                            alert('Error al borrar producto. Por favor, inténtalo de nuevo.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al Borrar Producto. Por favor, inténtalo de nuevo.');
                    });

            //.log(producto_id.value)
        }else{
            console.error('nah u wont')
        }
        
    }
</script>

<template>
    <div class="overview">
        <div v-if="!deletedSended">
            <h2>Borrar Item</h2>
            <select name="itemToDelete" id="itemToDelete" v-model="producto_id">
                <option v-for="item in itemShopArray" :key="item.idItem" :value="item.idItem">
                    {{ item.idItem +'- '+ item.nombre }}
                </option>
            </select>
            <div>
                <button @click="sendConfirmDelete">Borrar Item seleccionado</button>
                <button @click="HideMe()">Cancelar</button>
            </div>
        </div>
        
        <div v-if="confirmDelete && !deletedSended">
            <p>Estas Seguro de querer Borrar el Producto?</p>
            <button @click="deleteNewItem(isRestaurant)">Proceder</button>
        </div>
        <div v-if="deletedSended">
            <h2>Se ha eliminado el producto</h2>
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

        background-color: var(--element-background);

        
    }
</style>