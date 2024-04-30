<script setup lang="ts">
import { defineProps, withDefaults } from "vue";

import { ref } from "vue"


import MenuTemplate  from "./MenuTemplate.vue";
import ItemFullpageUser from "./components/ItemFullpageUser.vue"
import ShoppingListUser from "./ShoppingList.vue";
import dataJson from "@/dataTest.json"

import type { ItemShop, restaurantData } from './interfaces';
import { defaultItemShopArray } from './interfaces';


// Crea un ref para almacenar los datos
const dataRef = ref<restaurantData>({
    nombreCliente: "Nombre Cliente",
    nombreRestaurante: "Nombre Restaurante",
    idRestaurante: 0,
    itemShopArray: defaultItemShopArray()
});

// Asigna los datos de dataJson al ref

if (dataJson) {
    Object.assign(dataRef.value, dataJson);
}

// Recuperar Datos si se recargo la pagina por error
const storedItemsSelected = localStorage.getItem('itemsSelected');
let itemsSelected:ItemShop[]
/* if (storedItemsSelected) {
    itemsSelected = JSON.parse(storedItemsSelected);
    // Ahora itemsSelected contiene los datos guardados en la caché
} else {
    itemsSelected = dataRef.value.itemShopArray
    // inicializar los elementos en cantidad 0
    itemsSelected.forEach(item => {
        item.cantidad=0;
    });
}
 */

// comentar al terminar
itemsSelected = dataRef.value.itemShopArray
// inicializar los elementos en cantidad 0
itemsSelected.forEach(item => {
    item.cantidad=0;
});

const totalItemsMoney = ref(0);



function calculateMoney() {
    totalItemsMoney.value=0
    itemsSelected.forEach(itemsSelected => {
        totalItemsMoney.value += itemsSelected.precio * itemsSelected.cantidad
    });
}


const addItem = (itemAdded:number) => {
    
    const itemFound = itemsSelected.find(item =>item.idItem === itemAdded)
    if (itemFound) {
        itemFound.cantidad++
    }
    // console.log(itemFound?.cantidad)
    calculateMoney()
    saveShoppingItems()
}

const deleteItem = (itemAdded:number) => {
    const itemFound = itemsSelected.find(item =>item.idItem === itemAdded)
    if (itemFound) {
        itemFound.cantidad--
    }
    // console.log(itemFound?.cantidad)
    calculateMoney()
    saveShoppingItems()
}


function saveShoppingItems() {
    localStorage.setItem('itemsSelected',JSON.stringify(itemsSelected))
}

console.log(totalItemsMoney)
console.log(itemsSelected);
</script>


<template>
    <header></header>

    <div>
    <!-- html content -->

    <MenuTemplate 
        :nombre-cliente="dataRef.nombreCliente"
        :item-shop-array="dataRef.itemShopArray"
        :item-valor="totalItemsMoney"
        :addItem="addItem"
        :deleteItem="deleteItem"
        :item-nest="itemsSelected"
    />

    <!-- <ItemFullpageUser v-for="(item, index) in dataRef.itemShopArray"
        :-item-shop="item"
        :add-item="addItem"
        :delete-item="deleteItem"
    />

    <ShoppingListUser 
        :items="itemsSelected"
        :nombre-cliente="dataRef.nombreCliente"
        :add-item="addItem"
        :delete-item="deleteItem"
    /> -->
        
    </div>


</template>

<style scoped>

</style>
