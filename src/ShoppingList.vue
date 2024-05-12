<script setup lang="ts">
import { ref } from "vue";
import ShoppingListItemModule from "./components/ShoppingListItem.vue";

import PayScreen from "./PayScreen.vue";

import type { ItemShop } from "./interfaces";
import { defaultItemShopArray } from "./interfaces";


interface ShoppingList {
    items: ItemShop[],
    nombreCliente: string,
    addItem:Function,
    deleteItem:Function,
    showCarrito: Function,
    ItemValor:number,
}

const shoppingListData =defineProps<ShoppingList>()
let totalPrecio = 0;

function estaVacia(shoppingList: ShoppingList): boolean {
    return !shoppingList || !shoppingList.items || shoppingList.items.length === 0;
}



const showPayScreenVar = ref(false)
const showPayScreen = () => {
    showPayScreenVar.value = !showPayScreenVar.value
}

</script>

<template>
    <div class="shopDisplay">
        <div v-if="!showPayScreenVar">
        <div class="ShopingText">
            <h1>Carrito</h1>
            <h2>{{ shoppingListData.nombreCliente }}</h2>
        </div>
    

        <div class="ShopingGrid">
            <ShoppingListItemModule 
                v-for="(item, index) in shoppingListData.items" 
                :key="index" 
                :itemData="item" 
                :addItem="addItem"
                :deleteItem="deleteItem"
            />
        </div>

    

        <div class="shopingReady">
            <div>
                <h2>Total:</h2>
                <h2>${{ (ItemValor/100).toFixed(2) }}</h2>
            </div>
            <button @click="showPayScreen" class="comprar">Proceder a la Compra</button>
            <button @click="showCarrito()" class="regresar">Regresar</button>
        </div>
    </div>

    <PayScreen
    v-if="showPayScreenVar"
    :itemShops="items"
    :totalPagar="ItemValor"
    :showPayScreen="showPayScreen"
    />
    </div>
    
    
</template>

<style scoped>
    *{
        transition: all 0.25s;
    }
    div{
        margin: 5%;
    }
    .ShopingText{
        text-align: center;
    }
    .ShopingText h1{
        margin: 0;
        margin-top: 10vh;
        font-weight: bold;
        letter-spacing: .1em;
    }
    .ShopingText h2{
        margin: 0;
        font-weight: lighter;
        color: var(--color-text-label);
    }
    .shopingReady{
        padding: 5%;
        

        border-radius: min(5vw,50px);

        background-color: var(--color-text-element-background)
    }
    .shopingReady div {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5vw;
        margin-top: 0;


    }
    .shopDisplay{
        /* width: 50%; */
    }

    .comprar{
        color: var(--apt-button-text);

    }

    button {
        width: 100%;
        background-color: var(--color-button-background);
        border-radius: 2vw;
        padding: 2%;
        overflow: hidden;
        border: none;
        box-shadow:  0px 0px 10px #000000; 
        margin: 20px;
        color: var(--apt-button-text);

        font-size: min(50px,5vw);
        font-weight: bold;
        color: var(--color-text);
        margin-left: 0;
        margin-right: 0%;
    }
    .regresar{
        font-size: min(30px,3vw);
        color: var(--apt-button-text);
    }

    button:hover {
        background-color: var(--color-button-background-hover);
    }
    .ShopingGrid {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        margin: 5%;
        
        align-content: center;
    }
</style>