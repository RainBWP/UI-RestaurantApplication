<script setup lang="ts">
    import { ref } from "vue";
    import type { ItemShop } from '@/interfaces';
    import  ProcesarPago  from "./ProcesarPago.vue";

    export interface PayScreen {
        itemShops:ItemShop[],
        totalPagar:number,
        showPayScreen:Function,
    }

    const promps = defineProps<PayScreen>()

    const showProcesingPayVar = ref(false)
    const blurPropetier = ref("none")
    const showProcesingPay = () => {
        showProcesingPayVar.value=true
        blurPropetier.value = "blur(20px)"
    }
    

</script>

<template>
    <div class="blurit">
        <h1>Zona de Pago</h1>

        <div class="pageSelection">
            <div>
                <h2>Total a Pagar: </h2>
                <h2>${{ (totalPagar/100).toFixed(2) }}</h2>
            </div>
            <h2>Seleccione Su Metodo de Pago</h2>

            <button @click="showProcesingPay">Tarjeta de Credito/Debitos</button>
            <button @click="showProcesingPay">Transferencia</button>
            <button @click="showProcesingPay">Efectivo</button>
            <button @click="showProcesingPay">PayPal</button>
        </div>

        <div class="pageSelection">
            <button @click="showPayScreen()">Regresar a Lista de Compra</button>
        </div>
    </div>

    <ProcesarPago 
    v-if="showProcesingPayVar"
    />
    
</template>

<style scoped>


    .blurit {
        text-align: center;
        filter: v-bind("blurPropetier");
    }
    .pageSelection{
        margin: 5%;
        padding: 5%;
        display: flex;
        align-items: center;
        flex-direction: column;

        border-radius: min(20px,2vw);

        background-color: var(--color-text-element-background)
    }

    button {

        box-shadow:  0px 0px 10px #000000; 
        width: 100%;

    }


</style>