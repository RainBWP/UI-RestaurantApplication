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
            <h2>${{ ((data.itemData.precio*data.itemData.cantidad)/100).toFixed(2) }}</h2>
        </div>
    </div>


</template>

<style scoped>
    .itemHolder {
        height: min(200px,25vw); /* Ajusta este valor según tus necesidades */
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
        width: min(200px,25vw); /* Ajusta este valor según tus necesidades */
        overflow: hidden;
        height: min(200px,25vw); /* Ajusta este valor según tus necesidades */
        border-radius: 10px; /* Ajusta este valor según tus necesidades */
    }

    .headerImagen img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 100%; 
    }
    .itemText{
        margin-left: 30px; /* Ajusta este valor según tus necesidades */
    }
    b{
        margin: 0;
        font-size: min(40px,4vw); /* Ajusta este valor según tus necesidades */
    }
    p {
        font-size: min(24px,2.4vw); /* Ajusta este valor según tus necesidades */
    }
    h2 {
        font-size: min(48px,4.8vw); /* Ajusta este valor según tus necesidades */
    }

    button {
        width: min(35px,.5vw); /* Ajusta este valor según tus necesidades */
        height: min(65px,1vw); /* Ajusta este valor según tus necesidades */
        background-color: var(--color-button-background);
        border-radius: 5px;
        margin: min(5px,.5vw);
        overflow: hidden;
        border: none;
        font-size: min(40px,4vw); /* Ajusta este valor según tus necesidades */
        text-align: center;
        color: var(--color-text)
    }
</style>
