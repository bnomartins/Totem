<template>

  <button
      class="m-2 px-2 bg-white border border-indigo-700 text-indigo-700  hover:bg-indigo-800 hover:text-white rounded-md shadow-md font-bold"
      @click="abrirModal"
    >
      Editar
  </button>

  <Modal :show="confirmar" @close="closeModal">


    <div class="py-8 border-b border-solid border-slate-200 rounded-t text-gray-600">
      <h1 class="text-center m-auto text-3xl font-bold" >
        Edição dos dados da Triagem
      </h1>
    </div>

      <div class="mx-2 px-6 border rounded text-xl w-full">

      <form @submit.prevent="editarTriagem()" class="w-full">
          <div class="m-2 p-2 rounded">
              <label class="font-bold text-xl text-gray-600" for="classificacao">Classificacao</label>
              <input type="text" placholder="Digite o classificacao" v-model="form.classificacao"
              class="w-full rounded h-12 text-xl text-gray-500 font-bold"/>
              <div class="bg-red-100 my-2 px-5 text-red-700 text-bold font-semibold text-xl">
                  {{ form.errors.classificacao }}
              </div>
          </div>

          <div class="m-2 p-2 rounded">
              <label class="font-bold text-xl text-gray-600" for="observacao">Observacao</label>
              <input type="text" placholder="Digite a observacao" v-model="form.observacao"
              class="w-full rounded h-12 text-xl text-gray-500 font-bold"/>
              <div class="bg-red-100 my-2 px-5 text-red-700 text-bold font-semibold text-xl">
                  {{ form.errors.observacao}}
              </div>
          </div>


          <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
            <button class="text-white bg-red-500 hover:bg-red-400
            active:bg-red-600 font-bold text-xl px-4 py-2 rounded outline-none focus:outline-none
              mr-1 mb-1 ease-linear transition-all duration-150"
            type="submit"
            :disabled="form.processing"
            :class="{ 'opacity-25': form.processing }"
            >
              <i v-if="form.processing">Editando</i>
              <i v-else >
                Salvar
              </i>
            </button>
          </div>

        </form>
    </div>
  </Modal>
    </template>

  <script setup>
  import { Link, useForm } from "@inertiajs/vue3";
  import Modal from '@/Components/Modal.vue'
  import Aviso from '@/Components/Aviso.vue'
  import { nextTick, ref } from 'vue';
  import DangerButton from '@/Components/DangerButton.vue';

  // Funções do Módulo Triagem
  const props = defineProps({
    triagem: {
        type: Object
    },

  })

    const form = useForm({
      id: props.triagem.id,
      classificacao: props.triagem.classificacao,
      observacao:  props.triagem.observacao,
      tipo: 'Edição',

  })

function editarTriagem(){
  if(form.classificacao != '' && form.observacao != ''){
    form.put(route('triagems.update', form.id),{
      onSuccess: () => closeModal(),
    })
  }
}
// function editarTriagem(){
//     form.put(route('Triagems.update', form.id), {
//       onSuccess: closeModal()
//     });
// }

  // Controle do Modal
  const confirmar = ref(false);

  const abrirModal = () => {
  confirmar.value = true;
  };

  const closeModal = () => {
    confirmar.value = false;
    form.reset();
  };



  </script>
