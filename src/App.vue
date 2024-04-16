<script setup lang="ts">
import MenuTemplate  from "./MenuTemplate.vue";
import ItemFullpageUser from "./components/ItemFullpageUser.vue"
import ShoppingListUser from "./ShoppingList.vue";
import dataJson from "@/dataTest.json"

let nombreRestaurante="Restaurante";
let nombreCliente="Nombre Cliente";
let idRestaurante=0;


let itemShopArray=[{
    idItem: 0,
    imagen:"",
    descripcion:"",
    imagenAlt:"",
    nombre:"",
    precio: 0,
}]

// getJsonData
    if (dataJson) {
        nombreCliente=dataJson.nombreCliente;
        nombreRestaurante=dataJson.nombreRestaurante;
        idRestaurante=dataJson.idRestaurante;
        itemShopArray=dataJson.itemShopArray;
        console.log(itemShopArray)
    }

</script>

<template>
    <header></header>

    <div>
    <!-- html content -->

    <MenuTemplate 
    :nombre-cliente="nombreCliente"
    :item-shop-array="itemShopArray"/>

    <ItemFullpageUser v-for="(item, index) in itemShopArray"
    :key="index"
    :imagen="item.imagen"
    :descripcion="item.descripcion"
    :imagen-alt="item.imagenAlt"
    :nombre="item.nombre"
    :precio="item.precio" />

    <ShoppingListUser />
    </div>


</template>

<style scoped>
/* css content */

/* div {
    max-width: 500px;
    position:absolute;
    
} */
</style>
