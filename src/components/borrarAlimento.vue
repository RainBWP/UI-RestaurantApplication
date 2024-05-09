<script setup lang="ts">
    import { ref } from "vue";
    import { type ItemShop } from "../interfaces";

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
            console.log(producto_id.value)

            // cuando la peticion se envie con exito ejecutar esto
            sendDeletedSended()
            promps.ReloadItemShopArray()
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
            <h2>Se ha enviado la peticion de borrado</h2>
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