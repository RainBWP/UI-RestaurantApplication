<script setup lang="ts">
import ShoppingListItemModule from "./components/ShoppingListItem.vue";



interface ShoppingListItem {
    imagen?: string,
    precio?: string,
    cantidad?: string,
    imagenAlt?: string,
    nombre?: string,
}

interface ShoppingList {
    items: ShoppingListItem[],
    nombreCliente: string
}

const shoppingListData: ShoppingList = {
    items: [
        { imagen: '/imagesTest/hamburger.jpg', precio: '200.1', cantidad: '2', imagenAlt: 'Deliciosa Hamburguesa',nombre: 'Hamburger' },
        { imagen: '/imagesTest/owoburger.jpg', precio: '250.23', cantidad: '1', imagenAlt: 'Imagen 2', nombre:'Owoburger' },
        { imagen: '/imagesTest/samwich.JPG', precio: '140.00', cantidad:'3',imagenAlt:'algo', nombre:'Sandwich'}
    ],
    nombreCliente: 'Nombre Cliente'
};

let totalPrecio = '0.00';

function estaVacia(shoppingList: ShoppingList): boolean {
    return !shoppingList || !shoppingList.items || shoppingList.items.length === 0;
}

if (!estaVacia(shoppingListData)) {
    var total= 0.0;
    for (let index = 0; index < shoppingListData.items.length; index++) {
        const element = shoppingListData.items[index];
        
        total = total+ parseFloat(element.precio)*parseInt(element.cantidad);
        if (index===999) {
            break
        }
    }

    totalPrecio = total.toFixed(2)
}

</script>

<template>
    <div class="ShopingText">
        <h1>Carrito</h1>
        <h2>{{ shoppingListData.nombreCliente }}</h2>
    </div>
    

    <div class="ShopingGrid">
        <ShoppingListItemModule v-for="(item, index) in shoppingListData.items" :key="index" :itemData="item" />
    </div>

    

    <div class="shopingReady">
        <div>
            <h2>Total:</h2>
            <h2>${{ totalPrecio }}</h2>
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
        font-size: 10vw;
        font-weight: bold;
        letter-spacing: 1.2vw;
    }
    .ShopingText h2{
        margin: 0;
        font-size: 5vw;
        font-weight: lighter;
        color: var(--color-text-label);
    }
    .shopingReady{
        font-size: 3vw;
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