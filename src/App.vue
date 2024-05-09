

<script setup lang="ts">
//import { defineProps, withDefaults, watch } from "vue";

import { ref } from "vue"
import axios from 'axios';

//import PayScreen from "./PayScreen.vue";
import MenuTemplate from "@/MenuTemplate.vue";
import dataJson from "@/dataTest.json";
import Registro from "@/Registro.vue";
import PantallaInicial from "@/PantallaInicial.vue";
import SelectRestaurant from '@/SelectRestaurant.vue'
import type { ItemShop, restaurantData, restaurantShowing } from '@/interfaces';
import { defaultItemShopArray, defaultItemRestaurantArray } from '@/interfaces';
// variables para saber si el registro fue completado con exito, mas no el login
const registroCompleto = ref(false);
const accion = ref(false);

// interfaz de datos que se reciben
const dataRef = ref<restaurantData>({
    nombreCliente: "Nombre Cliente",
    nombreRestaurante: "Nombre Restaurante",
    idRestaurante: 0,
    itemShopArray: defaultItemShopArray(),
    itemRestaurantArray: defaultItemRestaurantArray(),
});




// handles para emit
const handleRegistroCompleto = () => {
    registroCompleto.value=true;
};

const accionCrear = () => {
    accion.value = true;
};

const accionRegistrar = () => {
    accion.value = false;
};

// HTTP API borrar json

const callHTTPInfo = async () => {
    let user_name:string = dataRef.value.nombreCliente
    let restaurant_name:string = dataRef.value.nombreRestaurante
    let restaurant_id:number=dataRef.value.idRestaurante
    let itemShopArray:ItemShop[] = dataRef.value.itemShopArray

    try {
        if (dataJson) { // comentar cuando https sirva o guardarlo en el else
            Object.assign(dataRef.value, dataJson);

            user_name=dataJson.nombreCliente
            restaurant_name= dataJson.nombreRestaurante
            restaurant_id = dataJson.idRestaurante
            //itemShopArray = dataJson.itemShopArray
        }

        // Obtiene los productos desde la base de datos
        const response = await axios.get('http://localhost/AppVue/'); // Usar Axios para hacer la solicitud GET
        console.log(response.data);
        if (response.status === 200) {
            const menuData = response.data; // Obtener los datos del menú de la respuesta
            // Asignar los datos del menú al ref
            dataRef.value.itemShopArray = menuData.map((item: any) => ({
            idItem: item.id_menu,
            nombre: item.nombre_producto,
            imagen: item.imagen,
            imagenAlt: 'Nada',
            precio: (item.precio),
            cantidad: 0 // Inicialmente la cantidad es cero
            }));
        } else {
            console.error('Error al obtener datos del menú');
        }

        // actualiza toda la informacion recibida
        Object.assign(dataRef.value, {
            nombreCliente: user_name, // en caso de no recibir algo
            nombreRestaurante: restaurant_name, // se pone el valor por defecto
            idRestaurante: restaurant_id, // ahora se mantiene fijado esto
            //itemShopArray: itemShopArray,
        })
    } catch (error) {
        console.error('Error al obtener datos del Menú:', error);
    }
}

callHTTPInfo() // comment this to stop getting json data


function getUserInfo(user_email_function:string) { 
    // user_email_function contiene para obtener el nombre del usuario

    let user_name:string = dataRef.value.nombreCliente
    // call user info

    // put new info
    dataRef.value.nombreCliente = user_name

    return true // regresar si la operacion se realizo con exito
}

function getAllRestaurant() {
    // NO SE ESPERA RECIBIR TODOS LOS MENUS DEL RESTAURANTE, SOLAMENTE INFORMACION DE NOMBRE Y DIRECCION Y OTRAS EN LA INTERFAZ
    /* INTERFAZ DE restaurantShowing

        export interface restaurantShowing {
            restaurant_name:string,
            direccion: string,
            restaurant_id:number,
            get_restaurant:Function,
            restaurant_logo?:string,
        }
    
    */
    let db_restaurants_info:restaurantShowing[] = dataRef.value.itemRestaurantArray

    // call restaurant important info

    dataRef.value.itemRestaurantArray = db_restaurants_info

    return true // regresar si la operacion se realizo con exito
}

function getRestaurantMenu(restaurant_id_function:number) {
    // restaurant_id_function se usa para obtener por https el menu de cierto restaurante
    let restaurnt_name:string = dataRef.value.nombreRestaurante
    let restaurant_id:number = dataRef.value.idRestaurante
    let restaurant_menu:ItemShop[] = dataRef.value.itemShopArray

    // call restaurant menu info

    dataRef.value.idRestaurante = restaurant_id
    dataRef.value.nombreRestaurante = restaurnt_name
    dataRef.value.itemShopArray = restaurant_menu
    
    return true // regresar si la operacion se realizo con exito
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

const restaurant_selected = ref(false)
const get_restaurant = (id_restaurant:number) => { // obtener el restaurante seleccionado para llamar a buscar la informacion dentro del restaurante menu
    const request_done = getRestaurantMenu(id_restaurant)
    if (request_done) {
        restaurant_selected.value = true
    } else {
        console.error('opsie, try again')
    }
}


</script>


<template>
    <div>
  
      <div>

        <SelectRestaurant v-if="registroCompleto && !restaurant_selected"
        :restaurant_array="dataRef.itemRestaurantArray"
        :get_restaurant="get_restaurant"
        />

        <MenuTemplate v-if="registroCompleto && restaurant_selected"
          :nombre-cliente="dataRef.nombreCliente"
          :item-shop-array="dataRef.itemShopArray"
          :item-valor="totalItemsMoney"
          :addItem="addItem"
          :deleteItem="deleteItem"
          :item-nest="itemsSelected"
          :nombre-restaurante="dataRef.nombreRestaurante"
          :is-restaunrat="is_restaurant"
          :recargar-item-shop-array="getRestaurantMenu"
    
        />

        <PantallaInicial
          v-if="!registroCompleto"
          @crear="accionCrear"
          @registrar="accionRegistrar"
          @registroCompleto="handleRegistroCompleto"
          @is_restaurant="acction_restaurant"
          :get-user-info="getUserInfo"
          :is_restaurant="is_restaurant"
        />

        <Registro v-if="!registroCompleto && accion" @registroCompleto="handleRegistroCompleto" />
      </div>
    </div> 
</template>

<style scoped>

</style>

