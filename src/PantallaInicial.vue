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


    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits, type Ref } from 'vue';

interface promps {
  getUserInfo:Function,
  is_restaurant:boolean,
}
const promps = defineProps<promps>();


const correo = ref('');
const contrasena = ref('');
const registrado = ref(false);
const titulo = ref('Iniciar Seccion')

const emit = defineEmits(['crear', 'registrar','registroCompleto','is_restaurant']);   

const Registrar = () => {
  if (correo.value.length > 0 && contrasena.value.length > 0) {

    const variables_to_send = { // se empacan las variables a enviar para un uso facil
      correo: correo.value,
      contrasena: contrasena.value
    }

    // PUT HTTP API

    // comment this if, only to test propuses
    if (correo.value === 'a@a.a'){

      emit('is_restaurant',true)
      // open restaurant extra UI
    }


    emit('registroCompleto', true);
    promps.getUserInfo(correo.value) // llamamos a la funcion de obtener datos de user
    
  }else{
    submit_error("Se Ingresaron Datos Erroneos");
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
</style>
