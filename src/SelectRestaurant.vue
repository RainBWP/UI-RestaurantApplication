<script setup lang="ts">
    import RestaurantSelector from './RestaurantSelecctor.vue';
    import {type restaurant_selector } from "@/interfaces";
    
    const promps = defineProps<restaurant_selector>()

    console.log(promps)
</script>

<template>
    <div>
        <h1 style="text-align: center;">Seleccione el Restaurante</h1>
        <div class="restaurant-grid">
            <RestaurantSelector
            v-for="(item, index) in promps.restaurant_array"
            :key="index"
            :restaurant_name="item.restaurant_name"
            :direccion="item.direccion"
            :restaurant_id="item.restaurant_id"
            :get_restaurant="promps.get_restaurant"
            :restaurant_logo="item.restaurant_logo"
            />
        </div>
    </div>
</template>

<style scoped>
.restaurant-grid {
    display: grid;
    grid-template-columns: 1fr; /* Una columna */
    grid-gap: 20px; /* Espacio entre elementos */
    justify-items: center;
    max-width: 100%; /* Limita el ancho máximo de los elementos */
}
</style>