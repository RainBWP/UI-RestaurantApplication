

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

function getfromJSON() {
    Object.assign(dataRef.value, dataJson);
}
getfromJSON()


function getUserInfo(user_email_function:string, user_type_funcion:string) { 
    // user_email_function contiene para obtener el nombre del usuario

    let user_name:string = dataRef.value.nombreCliente
    // call user info

    const POST = {
        tipo: "NombreCliente",
        email_cliente:user_email_function,
        usuario_handle:user_type_funcion,
    }

    axios.post('http://localhost/AppVue/', POST)
        .then(response => {
            console.log(response);
            
            if (response.data === 'none') {
                console.log('No se encontro el usuario')
            } else {
                user_name = response.data;
                dataRef.value.nombreCliente = user_name

            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al conectar al servidor.');
        });

    // put new info
    console.log(dataRef.value.nombreCliente)
    //dataRef.value.nombreCliente = user_name

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
    axios.get('http://localhost/AppVue/') // obtener
        .then(response => {
            if (response.status == 200 && response.statusText == 'OK') {
                console.log(response.data);
                const db_restaurants_info = response.data.map((returnData: { restaurant_name: any; direccion: any; restaurant_id: any; restaurant_logo: any; }) => ({
                    restaurant_name: returnData.restaurant_name,
                    direccion: returnData.direccion,
                    restaurant_id: returnData.restaurant_id,
                    get_restaurant: () => true,
                    restaurant_logo: returnData.restaurant_logo
                }));

                console.log(db_restaurants_info);

                // Asignar los datos actualizados a dataRef.value.itemRestaurantArray
                dataRef.value.itemRestaurantArray = db_restaurants_info;

                console.log(dataRef.value.itemRestaurantArray);
            } else {
                console.error('Error en la solicitud:', response.statusText);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


function getRestaurantMenu(restaurant_id_function: number) {
    const POST = {
        tipo: 'MenuNegocio',
        restaurant_id: restaurant_id_function
    };

    axios.post('http://localhost/AppVue/', POST)
        .then(response => {
            const responseData = response.data;
            console.log(responseData);

            // Actualizar los datos en dataRef
            dataRef.value.nombreRestaurante = responseData.nombreRestaurante;
            dataRef.value.idRestaurante = restaurant_id_function;

            const restaurantMenu = responseData.menu.map((menuItem: any) => ({
                idItem: menuItem.id_menu,
                imagen: menuItem.imagen,
                descripcion: menuItem.descripcion,
                imagenAlt: menuItem.descripcion,
                nombre: menuItem.nombre,
                precio: menuItem.precio,
                cantidad: 0
            }));

            dataRef.value.itemShopArray = restaurantMenu;

            console.log("Data actualizada:", dataRef.value);
            return true

        })
        .catch(error => {
            console.error('Error:', error);
            return false;
        });
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
const get_restaurant = async (id_restaurant:number) => { // obtener el restaurante seleccionado para llamar a buscar la informacion dentro del restaurante menu
    console.log(id_restaurant)
    const request_done = getRestaurantMenu(id_restaurant);
    restaurant_selected.value = true;
}

getAllRestaurant()


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

