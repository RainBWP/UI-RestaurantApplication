<script setup lang="ts">
import ItemContainerUser from './components/ItemContainerUser.vue';
// imports and that things
export interface Props {
  itemValor?: number,
  nombreCliente?: string,
  itemShopArray?: Array<{imagen: string,
    imagenAlt: string,
    precio: number,
    nombre: string,
    idItem: string,
    descripcion: string}>
}
const promps = withDefaults(defineProps<Props>(),{
  itemValor: 0,
  nombreCliente: 'Nombre Cliente'
})

</script>

<template>
<!-- html content -->

  <h1>Menu</h1>
  <div class="importantItems">
    <h2>Total: ${{ itemValor }}</h2>
    <h2 class="clientName">{{ nombreCliente }}</h2>
  </div>

  <div class="itemContainer">
    <ItemContainerUser 
      v-for="(item, index) in itemShopArray" 
      :key="index"
      :nombre="item.nombre"
      :imagen="item.imagen"
      :imagenAlt="item.imagenAlt"
      :precio="item.precio"
    />
  </div>
    

  <button class="carrito"></button>
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
    z-index: 10;

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
  }
  h1 {
    margin-top: 10%;
    position: relative;
    display: flex;
    font-weight: bolder;
    justify-content: center;
  }
</style>
