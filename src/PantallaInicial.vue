<template>
  <div>
    <h1 v-if="!registrado">{{ titulo }}</h1>
    <div class="container" :class="{ 'hidden': registrado }" v-if="!registrado">

      <form class="form">
        <div>
          <label for="correo">Correo Electrónico:</label>
          <input type="email" id="correo" v-model="correo" required>
        </div>
        <div>
          <label for="contrasena">Contraseña:</label>
          <input type="password" id="contrasena" v-model="contrasena" required>
        </div>

        <div>
          <!-- Cambié el tipo de botón de 'submit' a 'button' -->
          <button type="button" @click="Registrar">Iniciar Sesión</button>
        </div>

        <button type="button" @click="CrearCuenta">Crear cuenta</button>


      </form>

  
      <Notification 
      v-if="show_notification"
      :error-code="error_code"
      :string-code="string_code" />

    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits } from 'vue';
import Notification from "@/components/notification.vue";

const correo = ref('');
const contrasena = ref('');

const error_code = ref(0);
const string_code = ref('')
const show_notification = ref(false)


const registrado = ref(false);
const titulo = ref('Iniciar Seccion')
const emit = defineEmits(['crear', 'registrar','registroCompleto']);   

const Registrar = () => {
  console.log(correo.value.length)
  if (correo.value.length > 0 && contrasena.value.length > 0) {
    emit('registroCompleto', true);
    
  }else{
    show_notification.value = true
    error_code.value = 1
    string_code.value = "Se Ingresaron Datos Erroneos"
  }
};

const CrearCuenta = () => {
    emit('crear', true);
    registrado.value = true
    
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

button {
width: 95%;
}


h1 {
  text-align: center;
}
</style>
