<script setup lang="ts">

    import type { ItemShopComponent } from '@/interfaces';
    import { defineProps } from 'vue';

    const promps = defineProps<ItemShopComponent>()
    
    const addItemR = () =>{
        promps.addItem(promps.itemShop.idItem)
    }

</script>

<template>
    <div class="frontObj">
        <div class="image">
            <div class="gradient"></div>
            <p class="nameObj">{{ itemShop.nombre }}</p>
            <img :src="itemShop.imagen" :alt="itemShop.imagenAlt">
        </div>
        <p class="priceObj">${{ (itemShop.precio/100).toFixed(2) }}</p>
        <button class="addObj" @click="addItemR">+</button>
    </div>
</template>

<style scoped>
    *{
        transition: all 0.25s;
    }

    .frontObj {
        display: flex;
        position: relative;
        height: calc(180px * 1.25);
        width: 180px;
        min-height: calc(180px * 1.25);
        min-width: 180px;
        
        /* outline: solid black; */
        overflow: hidden;
        background-color: var(--color-text-element-background);

        border-radius: 20px;

        flex-direction: column;
        flex-wrap: nowrap;
        align-content: flex-start;
        justify-content: flex-start;
        align-items: stretch;
        
        margin: 10px;
    }
    .image {
        position: relative;
        width: 180px;
        height: 180px;
        min-width: 180px;
        min-height: 180px;
        overflow: hidden;
        background-color: var(--element-background);
        
        box-shadow: 0px 10px 20px #0007;

        border-radius: 20px;
        
        transition: 0.3s;
    }
    .image img {
        position: absolute; /* Establecer posición absoluta para posicionar la imagen dentro del contenedor */
        top: 50%; /* Centrar verticalmente la imagen */
        left: 50%; /* Centrar horizontalmente la imagen */
        transform: translate(-50%, -50%); /* Centrar la imagen completamente */
        max-width: 100%; 
        min-height: 100%; 
    }

    .image img:hover{
        transform: translate(-80%, -80%);

    }

    .nameObj, .priceObj {
        position: absolute;
        bottom: 0px;
        left: 20px;
        font-weight: lighter; /* Peso de fuente del texto */
        z-index: 3;
        letter-spacing: 2px;
    }
    .addObj {
        position: absolute;
        width: 30px;
        height: 30px;
        max-width: 30px;
        max-height: 30px;
        right: 20px;
        bottom: 10px;
        font-weight: bolder;
        font-size: 15px;
        border-radius: 10px;
        border: none;
        background-color: var(--color-button-background);
        box-shadow: 0px 4px 6px #0006;
        text-align: center;
        color: var(--color-text);

    }

    .addObj:hover {
        background-color: var(--color-button-background-hover);
        font-size: 20px;
    }

    

    .nameObj {
        color: white; /* Color del texto */
        font-size: 15px; /* Tamaño de fuente del texto */
    }
    .priceObj {
        font-size: 15px;
        font-weight: bold;

    }

</style>