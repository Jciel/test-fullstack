
<template>
  <v-sheet width="300" class="mx-auto">
    <v-form>
      <v-text-field
          v-model="registerData.name"
          type="text"
          variant="underlined"
          label="Name"
          placeholder="Enter your name"
      ></v-text-field>

      <v-text-field
          v-model="registerData.email"
          type="email"
          variant="underlined"
          label="E-mail"
          placeholder="Enter your e-mail"
      ></v-text-field>

      <v-text-field
          :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
          :type="visible ? 'text' : 'password'"
          v-model="registerData.password"
          @click:append-inner="visible = !visible"
          variant="underlined"
          label="Password"
          placeholder="Enter your password"
          prepend-inner-icon="mdi-lock-outline"
      ></v-text-field>

      <v-btn
          type="submit"
          block
          class="mt-2"
          @click.prevent="register">
        Register
      </v-btn>
    </v-form>
  </v-sheet>
</template>

<script setup lang="ts">
import {reactive, ref} from "vue";
import {RegisterData} from "../components/Types.ts";
import {useAppStore} from "../stores/appStore.ts";
import {useRouter} from "vue-router";

const appStore = useAppStore()
const router = useRouter()

const registerData = reactive<RegisterData>({'name': '', 'email': '', 'password': ''})
const visible = ref<Boolean>(false)

const register = () => {
  appStore.register(registerData).then(() => {
    router.push('/login')
  }).catch(err => {
    appStore.alert({
      title: "Error register",
      message: err.message,
      type: "error",
      active: true
    })
  })
}

</script>


<style scoped>

</style>
