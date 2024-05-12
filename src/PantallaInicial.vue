<template>
  <div>
    <h1 v-if="!registrado">{{ titulo }}</h1>
    <div class="container" :class="{ 'hidden': registrado }" v-if="!registrado">
      <form class="form" @submit.prevent="Registrar">
        <div>
          <label for="correo">Correo Electrónico:</label>
          <input type="email" id="correo" v-model="correo" required>
        </div>
        <div>
          <label for="contrasena">Contraseña:</label>
          <input type="password" id="contrasena" v-model="contrasena" required>
        </div>
        <div class="eres">
          <label for="vendedor">Eres Vendedor:</label>
          <input type="checkbox" id="vendedor" v-model="esVendedor">
        </div>

        <p class="error" v-if="theres_error"> {{ theres_error_string }}</p>

        <div>
          <!-- Cambié el tipo de botón de 'submit' a 'button' -->
          <button type="button" @click="Registrar">Iniciar Sesión</button>
        </div>

        


      </form>

      <div class="form">
        <h2 style="text-align: center;">No tienes cuenta? Crea una!!!</h2>
        <button type="button" @click="CrearCuenta">Crear cuenta</button>

      </div>

      <a class="form" href="https://github.com/RainBWP/UI-RestaurantApplication" target="_blank">
            <!-- github link button with icon github -->
            <h2>Repositorio github</h2>
            <button class="github" ></button>
      </a>


    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits, type Ref } from 'vue';
import axios from 'axios';

interface promps {
  getUserInfo:Function,
  is_restaurant:boolean,
}
const promps = defineProps<promps>();


const correo = ref('');
const contrasena = ref('');
const esCliente = ref(false);
const esVendedor = ref(false);
const registrado = ref(false);
const titulo = ref('Iniciar Sesión')

const emit = defineEmits(['crear', 'registrar','registroCompleto','is_restaurant']);   

const checkboxChanged = (tipo:boolean) => { // true es 
  if (tipo) {
    esVendedor.value = false;
  } else {
    esCliente.value = false;
  }
};

const Registrar = () => {
  let usuario = '';
  if (correo.value.length > 0 && contrasena.value.length > 0) {
    if (!esVendedor.value) {
      usuario = 'Cliente';
    } else {
      usuario = 'Vendedor';
    }

    const variables_to_send = { // se empacan las variables a enviar para un uso facil
      tipo: "Login",
      usuario: usuario, // para acceder si es vendedor o cliente
      email: correo.value,
      password: contrasena.value
    }

    // POST HTTP API
    axios.post('http://localhost/AppVue/', variables_to_send)
    .then(response => {
      if (response.data === 'success') {
        alert('Inicio de sesión exitoso');
        //Condicional para que, dependiendo de si es cliente o vendedor, lo redirija a su respectiva pantalla
        if(usuario === 'Vendedor') {
          emit('is_restaurant',true)
        }
        emit('registroCompleto', true);
        promps.getUserInfo(correo.value) // llamamos a la funcion de obtener datos de user
      } else {
        submit_error("Correo electrónico o contraseña incorrectos");
      }
    })
    .catch(error => {
      console.error('Error:', error);
      submit_error("Error al conectar con el servidor");
    });
  }else{
    submit_error("Por favor, complete todos los campos");
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

.github{
        background-image: url('/github.svg');
        background-size: cover;
        background-size:40px;
        background-position: center center;
        background-repeat: no-repeat;
        cursor: pointer;
        height: 50px;
    }
a {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    text-decoration: none;
    color: var(--apt-color-text);
}

</style>
