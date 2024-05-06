<template>
  <div>
    <h1 v-if="!registrado">{{ titulo }}</h1>
    <div class="container" :class="{ 'hidden': registrado }" v-if="!registrado">

      <form @submit.prevent="iniciopantalla" class="form">
        <div>
          <label for="nombre">Nombre:</label>
          <input type="text" id="nombre" v-model="nombre" required>
        </div>
        <div>
          <label for="correo">Correo Electrónico:</label>
          <input type="email" id="correo" v-model="correo" required>
        </div>
        <div>
          <label for="contrasena">Contraseña:</label>
          <input type="password" id="contrasena" v-model="contrasena" required>
        </div>
      </form>

      <form @submit.prevent="iniciopantalla">
          <button type="submit" @click="Registrar">Iniciar Seccion</button>
          <button type="submit" @click="CrearCuenta">Crear cuenta</button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits } from 'vue';
import Notification from "@/components/notification.vue";

const nombre = ref('');
const correo = ref('');
const contrasena = ref('');
const esCliente = ref(false);
const esVendedor = ref(false);
const nombreNegocio = ref('');
const tipoVenta = ref('');



const registrado = ref(false);
const titulo = ref('Iniciar Seccion')
const emit = defineEmits(['crear', 'registrar']);   

const Registrar = () => {
    // send HTTPS user
    emit('registrar', true);
};

const CrearCuenta = () => {
    emit('crear', true);
};

const iniciopantalla = () => {
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

h1 {
  text-align: center;
}
</style>
