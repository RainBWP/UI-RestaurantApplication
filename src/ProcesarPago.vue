<script setup lang="ts">
</script>

<template>
    <div class="pagoScreen">
        <h1>Procesando Pago...</h1>
    </div>
    
</template>

<style scoped>
    .pagoScreen{
        position: absolute;
        top: 25%;
        z-index: 12;

        max-width: 90vw;

        text-align: center;
        margin: 5%;
        padding: 5%;
        display: flex;
        align-items: center;
        align-self: center;
        flex-direction: column;
        box-shadow: 10px 10px 10px #0005;
        border-radius: 5vw;

        background-color: var(--color-text-element-background)
    }
</style>