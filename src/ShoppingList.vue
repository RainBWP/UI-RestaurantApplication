<script setup lang="ts">
import ShoppingListItemModule from "./components/ShoppingListItem.vue";

import type { ItemShop } from "./interfaces";
import { defaultItemShopArray } from "./interfaces";


interface ShoppingList {
    items: ItemShop[],
    nombreCliente: string,
    addItem:Function,
    deleteItem:Function
}

const shoppingListData = withDefaults(defineProps<ShoppingList>(),{
    items: defaultItemShopArray,
    nombreCliente: "Nombre Cliente"
})

let totalPrecio = 0;

function estaVacia(shoppingList: ShoppingList): boolean {
    return !shoppingList || !shoppingList.items || shoppingList.items.length === 0;
}

if (!estaVacia(shoppingListData)) {
    var total= 0.0;
    for (let index = 0; index < shoppingListData.items.length; index++) {
        const element = shoppingListData.items[index];
        
        total = total+ element.precio*element.cantidad;
        if (index===999) {
            break
        }
    }

    totalPrecio = total
}

</script>

<template>
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
            <h2>${{ (totalPrecio/100).toFixed(2) }}</h2>
        </div>
        <button>Proceder a la Compra
        </button>
    </div>
</template>

<style scoped>
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

        border-radius: 5vw;

        background-color: var(--color-text-element-background)
    }
    .shopingReady div {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5vw;
        margin-top: 0;

    }
    .shopingReady button {
        font-size: 5vw
    }
    button {
        width: 100%;
            background-color: var(--color-button-background);
            border-radius: 2vw;
            padding: 2%;
            overflow: hidden;
            border: none;
            box-shadow:  0px 0px 10px #000000; 

            font-size: 2.5vw;
            font-weight: bold;
            color: var(--color-text)
        }
    .ShopingGrid {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        margin: 5%;
        align-content: center;
    }
</style>