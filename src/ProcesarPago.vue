<script setup lang="ts">
</script>

<template>
    <div class="pagoScreen">
        <h2>Procesando Pago...</h2>
    </div>
    
</template>

<style scoped>
    .pagoScreen {
        width: min(400px,90vw);
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 12;
        max-width: 90vw;
        text-align: center;
        padding: 5%;
        box-shadow: 10px 10px 10px #0005;
        border-radius: min(20px,5vw);
        background-color: var(--color-text-element-background);
        }

</style>