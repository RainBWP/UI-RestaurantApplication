<script setup lang="ts">

import type { ItemShop } from "@/interfaces";
import { defaultItemShopArray } from "@/interfaces";

export interface ShoppingData {
    itemData: ItemShop,
    addItem: Function,
    deleteItem:Function,
}

const data = defineProps<ShoppingData>()

</script>

<template >

    <div class="itemHolder" v-if="data.itemData.cantidad>0">
        <div class="itemHolder2">
            <div class="headerImagen">
                <div class="gradient"></div>
                <img :src='data.itemData.imagen' :alt="data.itemData.imagenAlt">
            </div>
            <div class="itemText">
                <b>{{ data.itemData.nombre }}</b>
                <p>Cantidad: {{ data.itemData.cantidad }}</p>
                <div>
                    <button @click="deleteItem(data.itemData.idItem)">-</button>
                    <button @click="addItem(data.itemData.idItem)">+</button>
                </div>
            </div>
        </div>
        
        <div>
            <h2>${{ (data.itemData.precio/100).toFixed(2) }}</h2>
        </div>
    </div>


</template>

<style scoped>
    .itemHolder {
        height: 25vw;
        overflow: hidden;

        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .itemHolder2 {
        max-width: 100%;
        width: 100%;
        display: flex;
        align-items: center;
    }

    .headerImagen{
        margin: 0%;
        position: relative;
        width: 25vw;
        overflow: hidden;
        height: 25vw;
        border-radius: 1vw;
    }

    .headerImagen img {
        position: absolute; /* Establecer posición absoluta para posicionar la imagen dentro del contenedor */
        top: 50%; /* Centrar verticalmente la imagen */
        left: 50%; /* Centrar horizontalmente la imagen */
        transform: translate(-50%, -50%); /* Centrar la imagen completamente */
        max-width: 100%; 
    }
    .itemText{
        margin-left: 3vw;
    }
    b{
        margin: 0;
        font-size: 5vw;
    }
    p {
        font-size: 3vw;
    }
    h2 {
        font-size: 6vw;
    }

    button {
        width: 6.5vw;
        height: 6.5vw;
        background-color: var(--color-button-background);
        border-radius: 5px;
        margin: 5px;
        overflow: hidden;
        border: none;

        font-size: 5vw;
        text-align: center;
        
        color: var(--color-text)
    }
</style>