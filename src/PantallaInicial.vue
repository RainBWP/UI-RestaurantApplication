<template>
  <div>
    <h3 v-if="!registrado">{{ titulo }}</h3>
    <div class="page-container" :class="{ 'hidden': registrado }">
      <form @submit.prevent="iniciopantalla">
        <button type="submit" @click="Registrar">Registrarse</button>
        <button type="submit" @click="CrearCuenta">Crear cuenta</button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits } from 'vue';

const registrado = ref(false);
const titulo = ref('INICIO')
const emit = defineEmits(['crear', 'registrar']);   

const Registrar = () => {
    emit('registrar', true);
    alert ('registro');
};

const CrearCuenta = () => {
    emit('crear', true);
    alert ('hola');
};

const iniciopantalla = () => {
  alert('registniugbro');
    registrado.value = true;
    titulo.value = '';
};

</script>

<style scoped>
.page-container.hidden {
  display: none;
}

.page-container {
  display: flex;
  justify-content: center;
}

button[type="submit"] {
  margin: 10px; /* Agregamos un espacio entre los botones */
  padding: 12px 20px;
  border: 2px solid #9b9811;
  border-radius: 100px;
  background-color: transparent;
  color: #9b9811;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
  background-color: #9b9811;
  color: #fff;
}

h3 {
  text-align: center;
}
</style>
