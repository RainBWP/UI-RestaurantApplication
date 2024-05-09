<template>
  <div class="container">
    <h1>Crear Cuenta</h1>
    <form @submit.prevent="submitForm" class="form">
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
      <div class="eres">
        <div>
          <input type="checkbox" id="vendedor" v-model="esVendedor">
          <label for="vendedor">¿Eres Vendedor?</label>
        </div>
      </div>

      <div v-if="esVendedor">
      <h2>REGISTRO PARA VENDEDORES</h2>
      <form @submit.prevent="submitForm">
        <!-- Campos del formulario de vendedor -->
        <div>
          <label for="nombreNegocio">Nombre del Negocio:</label>
          <input type="text" id="nombreNegocio" v-model="nombreNegocio" required>
        </div>
        <div>
         <label for="direccion">Direccion del Negocio</label>
         <input type="text" name="direccion" id="direccion">
        </div>
        <div>
         <label for="rfc">RFC</label>
         <input type="text" name="rfc" id="rfc" maxlength="15">
        </div>
      </form>
    </div>

      <p class="error" v-if="theres_error">{{ theres_error_string }}</p>
      <button type="submit">Crear Cuenta</button>

    </form>

  </div>
</template>

  
<script setup lang="ts">
  import Notification from "@/components/notification.vue";
  import { readConfigFile } from "typescript";
  import { ref, defineProps, defineEmits } from 'vue';
  //import { useRouter } from 'vue-router'; // Importa useRouter de Vue Router

  const nombre = ref('');
  const correo = ref('');
  const contrasena = ref('');
  const esVendedor = ref(false);
  const nombreNegocio = ref('');
  const direccionNegocio = ref('');
  const rfc = ref('');
  
  const emit = defineEmits(['registroCompleto']);


  const theres_error = ref(false);
  const theres_error_string = ref('');

  const submit_error = (error_msg:string) => {
    theres_error.value = true
    if (error_msg.length>0) {
      theres_error_string.value = error_msg
    }else {
      theres_error_string.value = 'Something Went Wrong'
    }
  }

  const cancel_error = () => {
    theres_error.value = false
  }


  const submitForm = () => {

  if (nombre.value && correo.value && contrasena.value ) {
    if (esVendedor.value) {
      submitVendedorForm()
    } else {
      cancel_error()

      const variables_to_send = { // se empacan las variables a enviar para un uso facil
        nombre:nombre.value,
        correo:correo.value,
        contrasena:contrasena.value
      }

      // HTTP API


      emit('registroCompleto', true);
    }

    }else {
      submit_error('No se introdujeron todos los datos')
    }
  };


const submitVendedorForm = () => {
  if (nombreNegocio.value && direccionNegocio.value && nombre.value && correo.value && contrasena.value && rfc.value) {
    // Aquí debes enviar los datos del formulario de vendedor
    cancel_error()

    const variables_to_send = { // se empacan las variables a enviar para un uso facil
      nombre_propietario: nombre.value,
      nombre_negicio: nombreNegocio.value,
      correo: correo.value,
      contrasena: contrasena.value,
      direccion: direccionNegocio.value,
      rfc:rfc.value
    }


    // HTTP API


    emit ('registroCompleto', true);
  } else {
    submit_error('No se introdujeron todos los datos') 
  }
};

  </script>


  
  
<style scoped>

.eres {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

.eres div {
  display: flex;
}



h3 {
  color: #435a18; /* Color del texto */
  font-size: 24px; /* Tamaño de la fuente */
  margin-bottom: 10px; /* Margen inferior */
}

select {
  width: 100%;
  padding: 12px;
  border: none;
  border-radius: 8px;
  background-color: var(--color-button-background); /* Color de fondo del botón */
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-bottom: 25px;
}
</style>