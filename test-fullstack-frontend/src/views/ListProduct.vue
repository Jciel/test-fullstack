<template>
  <v-data-table
      :headers="headers"
      :items="products"
      :sort-by="[{ key: 'price', order: 'asc' }]"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>List Products</v-toolbar-title>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
          size="small"
          class="me-2"
          @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
    </template>

  </v-data-table>
</template>

<script setup lang="ts">

import {computed, onMounted} from "vue";
import {useAppStore} from "../stores/appStore.ts";

const appStore = useAppStore()

const headers = [
  { title: 'Nome', key: 'name', align: 'center' },
  { title: 'Price', key: 'price.amount', align: 'center' },
  { title: 'Actions', key: 'actions', align: 'center', sortable: false }
]

onMounted(() => appStore.listAllProducts())
const products = computed(() => appStore.getProducts)


const editItem = (item) => {

}

</script>

<style scoped>

</style>
