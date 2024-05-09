

<script setup lang="ts">
//import { defineProps, withDefaults, watch } from "vue";

import { ref } from "vue"

//import PayScreen from "./PayScreen.vue";
import MenuTemplate from "./MenuTemplate.vue";
import dataJson from "@/dataTest.json";
import Registro from "./Registro.vue";
import Notification from "@/components/notification.vue";
import PantallaInicial from "./PantallaInicial.vue";
import type { ItemShop, restaurantData } from './interfaces';
import { defaultItemShopArray } from './interfaces';


const registroCompleto = ref(false);
const accion = ref(false);

const dataRef = ref<restaurantData>({
    nombreCliente: "Nombre Cliente",
    nombreRestaurante: "Nombre Restaurante",
    idRestaurante: 0,
    itemShopArray: defaultItemShopArray()
});

const handleRegistroCompleto = () => {
    registroCompleto.value=true;
};

const accionCrear = () => {
    accion.value = true;
};

const accionRegistrar = () => {
    accion.value = false;
};


if (dataJson) {
    Object.assign(dataRef.value, dataJson);
}


const storedItemsSelected = localStorage.getItem('itemsSelected');
let itemsSelected:ItemShop[]

const totalItemsMoney = ref(0);
function calculateMoney() {
    totalItemsMoney.value=0
    itemsSelected.forEach(itemsSelected => {
        totalItemsMoney.value += itemsSelected.precio * itemsSelected.cantidad
    });
}

if (storedItemsSelected) {
    dataRef.value.itemShopArray = JSON.parse(storedItemsSelected);
    itemsSelected = dataRef.value.itemShopArray
    calculateMoney()
 
} else {
    itemsSelected = dataRef.value.itemShopArray
 
    itemsSelected.forEach(item => {
        item.cantidad=0;
    });
    calculateMoney()
}




const addItem = (itemAdded:number) => {
    
    const itemFound = itemsSelected.find(item =>item.idItem === itemAdded)
    if (itemFound) {
        itemFound.cantidad++
    }
 
    calculateMoney()
    saveShoppingItems()
}

const deleteItem = (itemAdded:number) => {
    const itemFound = itemsSelected.find(item =>item.idItem === itemAdded)
    if (itemFound) {
        itemFound.cantidad--
    }
 
    calculateMoney()
    saveShoppingItems()
}


function saveShoppingItems() {
    localStorage.setItem('itemsSelected',JSON.stringify(itemsSelected))
}

const is_restaurant = ref(false)
const acction_restaurant = () => {
    is_restaurant.value = true;
};


</script>


<template>
    <div>
      <header></header>

      
  
      <div>
        <MenuTemplate v-if="registroCompleto"
          :nombre-cliente="dataRef.nombreCliente"
          :item-shop-array="dataRef.itemShopArray"
          :item-valor="totalItemsMoney"
          :addItem="addItem"
          :deleteItem="deleteItem"
          :item-nest="itemsSelected"
          :nombre-restaurante="dataRef.nombreRestaurante"
          :is-restaunrat="is_restaurant"
    
        />

        <PantallaInicial
          v-else
          @crear="accionCrear"
          @registrar="accionRegistrar"
          @registroCompleto="handleRegistroCompleto"
          @is_restaurant="acction_restaurant"
        />

        <Registro v-if="!registroCompleto && accion" @registroCompleto="handleRegistroCompleto" />
      </div>
    </div> 
</template>

<style scoped>

</style>

