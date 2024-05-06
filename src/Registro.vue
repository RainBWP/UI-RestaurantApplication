<template>
    <div>
      <h1>INICIO</h1>
      <form @submit.prevent="submitForm">
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
        <div>
          <input type="checkbox" id="cliente" v-model="esCliente">
          <label for="cliente">¿Eres Cliente?</label>
        </div>
        <div>
          <input type="checkbox" id="vendedor" v-model="esVendedor">
          <label for="vendedor">¿Eres Vendedor?</label>
        </div>
        <button type="submit">Registrarse</button>
      </form>

      <template v-if="esVendedor">
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
            <option value="comodarapida">Comida raoida(TACOS, TORTAS, TMALES, HAMBURGUESAS, etc)</option>
            <option value="comedor">COMIDA CORIDA(GUISOS, etc)</option>
            <option value="restaurante">RESTAURANTES(FORALES, COMIDAS COMPLETAS)</option>
          </select>
        </div>
        <button type="submit">Registrarse como Vendedor</button>
      </form>
    </template>


    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, defineProps, defineEmits } from 'vue';
  //import { useRouter } from 'vue-router'; // Importa useRouter de Vue Router

  const nombre = ref('');
  const correo = ref('');
  const contrasena = ref('');
  const esCliente = ref(false);
  const esVendedor = ref(false);
  const nombreNegocio = ref('');
  const tipoVenta = ref('');
  
  const emit = defineEmits(['registroCompleto']);
  //const router = useRouter(); // Obtén el router de Vue
  

  const submitForm = () => {
  if (nombre.value && correo.value && contrasena.value && esCliente.value ) {
    
      // Si no es vendedor, emite el evento de registro completo
      alert('Solo se marca cuando es cliente');
      //alert('registroCompleto');
      emit('registroCompleto', true);
    
  } else {
    alert('Por favor, complete todos los campos del formulario.');
  }
};

const submitVendedorForm = () => {
  if (nombreNegocio.value && tipoVenta.value && nombre.value && correo.value && contrasena.value && esCliente.value) {
    // Aquí debes enviar los datos del formulario de vendedor
    alert('Formulario de vendedor enviado correctamente');
    emit ('registroCompleto', true);
  } else {
    alert('Por favor, complete todos los campos del formulario.');
  }
};

  </script>


  
  
<style scoped>
.container {
  max-width: 400px; /* Ancho máximo del contenedor */
  margin: 0 auto; /* Centrar horizontalmente */
}

/* Estilos para el formulario */
.form {
  padding: 20px;
  border-radius: 10px;
  background-color: #fff;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
  color: black; /* Color del texto de las etiquetas */
  font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: calc(100% - 10px);
  padding: 12px;
  border: 3px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9; /* Color de fondo del campo de entrada */
}
h3 {
  color: #435a18; /* Color del texto */
  font-size: 24px; /* Tamaño de la fuente */
  margin-bottom: 10px; /* Margen inferior */
}

button[type="submit"] {
  width: 80%;
  padding: 12px;
  border: none;
  border-radius: 8px;
  background-color: #435a18; /* Color de fondo del botón */
  color: #fff;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
  background-color: #435a18; /* Color de fondo del botón al pasar el cursor */
}
</style>