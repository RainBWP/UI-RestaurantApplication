<script setup lang="ts">
    import { ref } from 'vue'

    const procesesing = ref(".")
    // animar procesar pago moviendo los ...
    setInterval(() => {
        procesesing.value = procesesing.value + "."
        if (procesesing.value.length > 10) {
            procesesing.value = "."
        }
    }, 800)
    
</script>

<template>
    <div class="pagoScreen">
        <h2 id="procesesing">Procesando Pago</h2>
        <h2>{{ procesesing }}</h2>
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