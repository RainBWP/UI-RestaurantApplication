<script setup lang="ts">
import ItemContainerUser from './components/ItemContainerUser.vue';
// imports and that things
export interface Props {
  itemValor?: String,
  nombreCliente?: String,
  itemShopArray?: Array<{imagen: String,
    imagenAlt: String,
    precio: String,
    nombre: String,
    idItem: String}>
}
const promps = withDefaults(defineProps<Props>(),{
  itemValor: '0.00',
  nombreCliente: 'Nombre Cliente',
  itemShopArray: []
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
      nombre = "Hamburger"
      imagen = "/imagesTest/hamburger.jpg"
      imagenAlt="Deliciosa Hamburguesa"
      precio="200.00"
    />
    <ItemContainerUser 
      nombre = "Owoburger"
      imagen = "/imagesTest/owoburger.jpg"
      imagenAlt="Una OwO Hamburguesa"
      precio="250.00"
    />
    <ItemContainerUser 
      nombre = "Sandwich"
      imagen = "/imagesTest/samwich.JPG"
      imagenAlt="Un Sandwich bien rico"
      precio="140.00"
    />
    <ItemContainerUser />
    <ItemContainerUser />
    <ItemContainerUser />
    <ItemContainerUser />
    <ItemContainerUser />
  </div>
    

  <button class="carrito"></button>
</template>

<style scoped>
/* css content */
  .itemContainer {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 2fr));
    grid-gap: 10px;
    justify-items: center;
  }
  .importantItems{
    display: flex;
    justify-content: space-between;
    align-items: baseline;
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
