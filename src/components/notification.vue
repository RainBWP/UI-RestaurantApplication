<script setup lang="ts">
    export interface Notification {
        /* 
            0 = No error
            1 = Error
            2 = Accepted
        */
        errorCode:number,
        stringCode:string,
    }

    const promps = withDefaults(defineProps<Notification>(), {
        errorCode: 0,
        stringCode: "Something Went Wrong... idk what it ts"
    })

    let notificationType = 0
    
</script>

<template>
    <div class="notification">
        <div>
            <h2>{{ promps.errorCode }}</h2>
        </div>
        <div class="text">
            <h3>{{  promps.stringCode }}</h3>
        </div>
        
    </div>
</template>

<style scoped>
    .notification {
        position: fixed;
        bottom: 10%;
        left: 50%;
        transform: translateX(-50%);
        width: 400px;
        z-index: 1000;
        display: flex;
        justify-content: space-around;
        align-items: baseline;
        background-color: var(--apt-element-background);
        border-radius: 1vw;
        transition: all 0.25s;
        box-shadow: 0 0 20px #0009
    }
    .text {
        width: 80%;
        text-align: justify;
    }
</style>