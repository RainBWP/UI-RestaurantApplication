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
      <form @submit.prevent="submitVendedorForm">
        <!-- Campos del formulario de vendedor -->
        <div>
          <label for="nombreNegocio">Nombre del Negocio:</label>
          <input type="text" id="nombreNegocio" v-model="nombreNegocio" required>
        </div>
        <div>
          <label for="tipoVenta">Tipo de Venta:</label>
          <select id="tipoVenta" v-model="tipoVenta" required>
            <option value="">Seleccione el tipo de venta</option>
            <option value="comodarapida">Comida rápida (TACOS, TORTAS, TAMALES, HAMBURGUESAS, etc)</option>
            <option value="comedor">Comida corrida (GUISOS, etc)</option>
            <option value="restaurante">Restaurantes (FORMALES, COMIDAS COMPLETAS)</option>
          </select>
        </div>
      </form>
    </div>

      <button type="submit" @click="submitData">Crear Cuenta</button>

    </form>

  </div>
</template>

  
  <script setup lang="ts">
  import Notification from "@/components/notification.vue";
  import { ref, defineProps, defineEmits } from 'vue';
  //import { useRouter } from 'vue-router'; // Importa useRouter de Vue Router

  const nombre = ref('');
  const correo = ref('');
  const contrasena = ref('');
  const esVendedor = ref(false);
  const nombreNegocio = ref('');
  const tipoVenta = ref('');
  
  const emit = defineEmits(['registroCompleto']);
  //const router = useRouter(); // Obtén el router de Vue
  
  const submitData = () => {
    if (esVendedor) {
      submitVendedorForm()
    }else{
      submitForm()
    }
  }

  const submitForm = () => {
  if (nombre.value && correo.value && contrasena.value ) {
    
      // Si no es vendedor, emite el evento de registro completo
      //alert('registroCompleto');
      emit('registroCompleto', true);
  } else {

  }
};


const submitVendedorForm = () => {
  if (nombreNegocio.value && tipoVenta.value && nombre.value && correo.value && contrasena.value) {
    // Aquí debes enviar los datos del formulario de vendedor
    alert('Formulario de vendedor enviado correctamente');
    emit ('registroCompleto', true);
  } else {
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