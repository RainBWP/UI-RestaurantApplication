<script setup lang="ts">
import type { ItemShop } from "@/interfaces";

export interface ItemFull {
    ItemShop:ItemShop,
    addItem: Function,
    deleteItem: Function,
}

const data = defineProps<ItemFull>()
</script>

<template>
    <div class="headerImagen">
        <img :src="data.ItemShop.imagen" :alt="data.ItemShop.imagenAlt">
        <h2 class="nameObj">{{ data.ItemShop.nombre }}</h2>
        <button class="backButton"><</button>
        <div class="gradient"></div>
    </div>
    <div class="infoObj">
        <h3>${{ (data.ItemShop.precio/100).toFixed(2) }}</h3>
        <p>{{ data.ItemShop.descripcion }}</p>
        <div class="textAreaHolder">
            <textarea name="notasAdicionales" 
            id="notasAdicionales"  
            autocapitalize="sentences" 
            minlength="255" 
            placeholder="Notas Adicionales" 
            spellcheck="true" 
            rows="3" ></textarea>
        </div>
        <div >
            <button @click="addItem(data.ItemShop.idItem)" style="width: 80%;">Agregar Al Carrito</button>
            <button @click="deleteItem(data.ItemShop.idItem)" style="width: 10%;">-</button>
        </div>
    </div>

</template>

<style scoped>
    *{
        transition: all 0.25s;
    }
    
    .headerImagen{
        margin: 0%;
        position: relative;
        width: 100%;
        overflow: hidden;
        height: 30vh;
        border-bottom-left-radius: 5vw;
        border-bottom-right-radius: 5vw;
    }
    .headerImagen img{
        position: absolute; /* Establecer posición absoluta para posicionar la imagen dentro del contenedor */
        top: 50%; /* Centrar verticalmente la imagen */
        left: 50%; /* Centrar horizontalmente la imagen */
        transform: translate(-50%, -50%); /* Centrar la imagen completamente */
        max-width: 100%; 
        min-height: 100%; 
    }
    .nameObj{
        margin: 5%;
        position: absolute;
        bottom: 0px;
        left: 20px;

        color: var(--color-contrast-text);
        font-size: 40px;
        font-weight: lighter;
        z-index: 3;
    }
    .backButton{
        position: absolute;
        margin: 20px;
        width: 50px;
        height: 50px;
        max-width: 50px;
        max-height: 50px;
        font-size: 40px;
        color: var(--color-contrast-text);
        background: none;
        border: none;

        filter: drop-shadow(0px 10px 10px #000000);
        -webkit-filter: drop-shadow(0px 10px 10px #000000);
        -moz-filter: drop-shadow(0px 10px 10px #000000);
    }
    .infoObj{
        margin: 5%;
        padding: 5%;

        border-radius: 5vw;

        background-color: var(--color-text-element-background)
    }
    .infoObj h3 {
        font-size: 35px;
        margin: 0%;
        letter-spacing: .2rem;
    }
    .infoObj p {
        text-align: left;
        font-size: 17px;
        font-weight: lighter;
    }
    .textAreaHolder textarea {
        background: none;
        border: none;
        resize: none;
        max-width: 100%;
        margin: 2%;
        font-size: 17px;
        
        
    }
    .textAreaHolder{
        background-color: var(--color-button-background);
        width: 100%;
        max-width: 100%;
        border-radius:3vw;
        
        
        border: none;
        box-shadow: inset 0px 0px 10px #000000;
        filter: drop-shadow(0px 0px 5px #00000050);
        -webkit-filter: drop-shadow(0px 0px 5px #00000050);
        -moz-filter: drop-shadow(0px 0px 5px #00000050);

        color: var(--color-text);
        
    }
    .infoObj button {
        background-color: var(--color-button-background);
        border-radius: 2vw;
        padding: 2%;
        overflow: hidden;
        border: none;
        box-shadow:  0px 0px 10px #000000; 

        font-size: 2.5vh;
        color: var(--color-text);

    }
    .infoObj button:hover{
        background-color: var(--color-button-background-hover);
        font-size: 2.7vh;
    }
    .infoObj div {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
</style>
