<script setup lang="ts">
import ItemContainerUser from './components/ItemContainerUser.vue';
import { ref, type Ref } from 'vue';

import { type ItemShop, defaultItemShopArray} from './interfaces'
import ShoppingList from './ShoppingList.vue';
import { defaultItemShop } from './interfaces';
import ItemFullpageUser from './components/ItemFullpageUser.vue';

// imports and that things
export interface Props {
  itemValor: number,
  nombreCliente: string,
  itemShopArray: Array<ItemShop>,
  addItem: Function,
  deleteItem: Function,
  itemNest: Array<ItemShop>,
  nombreRestaurante: string,
  isRestaunrat:boolean
  

}
const promps = withDefaults(defineProps<Props>(),{
  itemValor: 0,
  nombreCliente: 'Nombre Cliente',
  itemShopArray: defaultItemShopArray
})
const showCarritoVar = ref(false)

const showCarrito = () =>{
  showCarritoVar.value=!showCarritoVar.value
  checkShow()
}

const showFullScreenVar = ref(false)
const showFullScreenData = ref(defaultItemShop)
const showFullScreen = (itemShop:ItemShop) => {
  
  if (itemShop) {
    showFullScreenVar.value = true
    showFullScreenData.value = itemShop
  }else {
    showFullScreenVar.value = !showFullScreenVar.value
  }
  checkShow()
}

const canIShow = ref(true)
function checkShow() {

  if (showCarritoVar.value && showFullScreenVar) {
    canIShow.value = false;
    showFullScreenVar.value = false;
  }

  canIShow.value = !(showFullScreenVar.value || showCarritoVar.value)
  console.log(showFullScreenVar.value || showCarritoVar.value)
}

</script>

<template>
<!-- html content -->

  <div v-if="canIShow">
      <h1>Menu</h1>
      <h3>{{nombreRestaurante }}</h3>
    <div class="importantItems">
      <h2>Total: ${{ (itemValor/100).toFixed(2) }}</h2>
      <h2 class="clientName">{{ nombreCliente }}</h2>
    </div>

    <div v-if="isRestaunrat" class="importantItems">
      <button>Agregar Alimento</button>
      <button>Borrar Alimento</button>
    </div>

    <div class="itemContainer">
      <ItemContainerUser 
        v-for="(item, index) in itemShopArray" 
        :itemShop="item"
        :addItem="promps.addItem"
        :deleteItem="promps.deleteItem"
        :showFullScreen="showFullScreen"
      />
    </div>

    

  </div>
  <button  @click="showCarrito()" class="carrito"></button>

  <div> 
      <ItemFullpageUser v-if="showFullScreenVar"
      :ItemShop="showFullScreenData"
      :addItem="addItem"
      :deleteItem="deleteItem"
      :showFullScreen="showFullScreen"
      />
  </div>
    
  <ShoppingList 
  v-if="showCarritoVar"
  :items="itemNest"
  :nombreCliente="promps.nombreCliente"
  :addItem="promps.addItem"
  :deleteItem="promps.deleteItem"
  :showCarrito="showCarrito"
  :-item-valor="itemValor"
  />

  
</template>

<style scoped>
/* css content */
  template {
    max-width: 100%;
    overflow-x: hidden
  }
  .itemContainer {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 2fr));
    grid-gap: 0;
    justify-items: center;
  }
  .importantItems{
    display: flex;
    justify-content: space-around;
    align-items: baseline;
    max-width: 100%;
  }
  .clientName{
    font-size: 20px;
    color: var(--color-text-label);
    font-weight: lighter;
  }
  .carrito {
    position: fixed;
    bottom: 30px;
    right: 30px;

    width: 80px;
    height: 80px;
    z-index: 11;

    background-color: var(--color-button-background);
    background-image: url('/shopping-cart-svgrepo-com.svg');
    background-size:50%;
    background-position: center;
    background-repeat: no-repeat;

    border-radius: 20px;
    border: none;
    box-shadow: 0px 4px 6px #0006;
    text-align: center;
    color: var(--color-text);
    transition: all 0.25s;
  }

  .carrito:hover{
    background-color: var(--color-button-background-hover);
    background-size: 65%;
  }



  h1 {
    margin-top: 10%;
    position: relative;
    display: flex;
    font-weight: bolder;
    justify-content: center;
  }
  h3 {
    position: relative;
    display: flex;
    font-weight: normal;
    justify-content: center;
    color: var(--color-text-label);
  }
</style>
