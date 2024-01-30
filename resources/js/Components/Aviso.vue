<template>
<!-- Aviso -->
<div class="mb-4 inline-flex w-full rounded-lg bg-green-300 shadow-md"  v-if="$page.props.flash.message">

    <div class="animate-pulse flex w-12 items-center justify-center bg-green-500">
        <svg class="h-6 w-6 fill-current text-white" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
        </svg>
    </div>

    <div class="-mx-3 px-4 py-2 w-full">
        <div class="mx-3">

        <div v-if="$page.props.flash.message" class="alert w-full">
            <button
                class='text-red-600 hover:text-red-500 font-bold text-2xl float-right'
                @click="fecharAviso()"
            >
                X
            </button>

            <span class="text-green-500 text-xl font-bold">Info</span>
            <p class="text-2xl text-gray-600 font-bold">{{ $page.props.flash.message }}</p>


        </div>

    </div>

    </div>

</div>
</template>

<script setup>
import { computed, ref} from 'vue';
import { usePage } from '@inertiajs/vue3';
// import { Ref } from '@inertiajs/vue3';
// import { Ref } from "@inertiajs/inertia";

const page = usePage()
const msg = computed(() => page.props.flash.message)

function fecharAviso(){
    ((page.props.flash.message = ''))
}

</script>
