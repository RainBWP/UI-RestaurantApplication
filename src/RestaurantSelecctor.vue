<script setup lang="ts">

import { type restaurantShowing } from "@/interfaces";

const promps = defineProps<restaurantShowing>()
  

</script>

<template>
  <div class="restaurant_container">
    

    <div class="thisThing">
      <div >
        <img :src="restaurant_logo || '/UI-RestaurantApplication/src/assets/logo.svg'" alt="Logo">
      </div>
      <div>
        <h2>{{ restaurant_name }}</h2>
        <p>{{ direccion }}</p>
      </div>
        
        
    </div>
    <div>
      <button @click="get_restaurant(restaurant_id)">Go Buy</button>
    </div>
  </div>

</template>

<style scoped>
.restaurant_container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  align-self: center;
  background-color: var(--element-background);
  overflow: hidden;
  margin: min(20px,6vw);
  padding: 7vw;
  width: min(400px,80%);
  border-radius: 3vw;
}
.thisThing {
  display: flex;
  align-items: center;
  
}
.thisThing div img {
  margin-right: 20px;
  width: 60px;
  filter: drop-shadow(0 0 3px #0003);
}
</style>