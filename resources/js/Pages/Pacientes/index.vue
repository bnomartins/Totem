<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Pacientes
        </template>

        <div class="m-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="m-5 border-b border-gray-200">

                <div class="p-2 m-2 flex justify-end">
                    <input
                        v-model="form.search"
                        @keyup.enter="pesquisarPaciente"
                        type="text"
                        placeholder="Pesquisar"
                        class=" h-10 my-2 mr-2 rounded-md shadow-lg text-blue-500 text-2xl font-bold "
                        :disabled="form.processing"
                        :class="{ 'opacity-25': form.processing && !form.searchClear }"
                    />


                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <button type="button" class="px-3 my-2 text-2xl font-bold text-white bg-blue-800 hover:bg-blue-600 border border-gray-200 rounded-l-lg"
                            @click="pesquisarPaciente()"
                            :disabled="form.processing && !form.searchClear"
                            :class="{ 'opacity-25': form.processing && !form.searchClear }"                        
                        >
                            <span v-if="form.processing && !form.searchClear">Aguarde</span>
                            <span v-else>Pesquisar</span>
                          </button>

                        <button type="button" class="px-3 my-2 text-2xl font-bold text-white bg-gray-700 hover:bg-gray-500 border border-gray-200 rounded-r-md"
                          @click="limparPesquisaPaciente()"
                          :disabled="form.processing && form.searchClear "
                          :class="{'opacity-25': form.processing && form.searchClear}"
                        >
                            <span v-if="form.processing && form.searchClear">Aguarde</span>
                            <span v-else>Limpar</span>                        
                        </button>
                      </div>             
                    <CadastroPaciente  />
                    

                    <!-- <Edicao :paciente='form.paciente' v-if="form.modalEditar"/> -->



                </div>


                <div>
                    <div class="mx-auto w-full whitespace-no-wrap">

                        <div class="bg-gray-100 shadow mx-auto">
                            <!-- <form @submit.prevent="submit" >
                                <div class="p-5">
                                    <label for="param">Enter your name:</label>
                                    <input type='text' name="param" v-model="form.param" class="px-2 ml-2 rounded-lg border">
                                    <button type="submit" class="px-2 py-1 ml-2 rounded-lg border bg-gray-500 text-white hover:bg-black">Generate PDF</button>
                                </div>
                            </form> -->
                            
                            <Aviso />

                            <table class="w-full">
                            <tr class="bg-gray-900 text-white">
                                <th class="px-2 py-2 text-2xl font-bold text-left">ID</th>
                                <th class="px-2 py-2 text-2xl font-bold text-left">Nome</th>
                                <th class="px-2 py-2 text-2xl font-bold text-left">CPF</th>
                                <th class="px-2 py-2 text-2xl font-bold text-left">Ações</th>
                            </tr>
                            <tr v-for="(p, index) in pacientes.data" :key="p.id"
                                :class="{'bg-gray-300': index%2===0}">
                                <td class="px-2 py-2 text-2xl text-left">{{p.id}}</td>
                                <td class="px-2 py-2 text-2xl text-left">{{p.nome}}</td>
                                <td class="px-2 py-2 text-2xl text-left">{{p.cpf}}</td>
                                <td class="px-2 py-2 text-xl float-right">
                                    <EdicaoPaciente  :paciente="{id: p.id, nome: p.nome, cpf: p.cpf}" />

                                    <button
                                    class="m-2 px-2 bg-white border border-orange-800 text-orange-800  hover:bg-orange-700 hover:text-white rounded-md shadow-md font-bold"
                                    >
                                        Imprimir
                                    </button>

                                    <ExcluirPaciente :id="p.id"/>

                                    <!-- <button
                                    class="m-2 px-2 bg-white border border-red-700 text-red-700  hover:bg-red-800 hover:text-white rounded-md shadow-md font-bold"
                                    @click.prevent="excluirPaciente(p.id)"
                                    >
                                        Excluir
                                    </button> -->
                                </td>
                            </tr>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="m-2 p-2">
                    <Pagination :links="pacientes.links"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, router } from '@inertiajs/vue3';
import { Inertia, usePage } from "@inertiajs/inertia";

import Pagination from '../../Components/Pagination.vue'
import Aviso from '@/Components/Aviso.vue'
import CadastroPaciente from '../../Components/Pacientes/Cadastro.vue'
import EdicaoPaciente from '../../Components/Pacientes/Edicao.vue'
import ExcluirPaciente from '../../Components/Pacientes/Excluir.vue'

const props = defineProps({
    pacientes: {
        type: Object
    },
    paciente:{
        type: Object
    }
})

const form = useForm({
      search: '',
      searchClear: false,
      paciente: {
        id: '',
        nome: '',
        cpf: ''
      }
  
  })


function pesquisarPaciente(){
    form.searchClear = false
    form.get(route('pacientes.index'), {
        search: form.search
    })
}

function limparPesquisaPaciente(){
    form.searchClear = true
    form.search = ''

    form.get(route('pacientes.index'), {
        search: form.search
    })
}


</script>
