<template>
  <v-sheet width="300" class="mx-auto">
    <v-form>
      <v-text-field
          v-model="dataLogin.email"
          type="email"
          variant="underlined"
          label="E-mail"
          placeholder="Enter your e-mail"
      ></v-text-field>

      <v-text-field
          :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
          :type="visible ? 'text' : 'password'"
          v-model="dataLogin.password"
          @click:append-inner="visible = !visible"
          variant="underlined"
          label="Password"
          placeholder="Enter your password"
          prepend-inner-icon="mdi-lock-outline"
      ></v-text-field>

      <v-btn
          type="submit"
          block
          class="mt-2, mb-3"
          @click.prevent="login">
        Log in
      </v-btn>

      <router-link to="register">Register</router-link>
    </v-form>
  </v-sheet>
</template>

<script setup lang="ts">
import {reactive, ref} from "vue";
import {LoginData} from "../components/Types.ts";
import {useAppStore} from "../stores/appStore.ts";
import {useRouter} from "vue-router";

  const dataLogin = reactive<LoginData>({'email': '', 'password': ''})
  const visible = ref<Boolean>(false)

  const appStore = useAppStore()
  const router = useRouter()

  const login = () => {
      appStore.login(dataLogin).then(() => {
        router.push('/list-products')
      }).catch(err => {
        appStore.alert({
          title: "Error login",
          message: err.message,
          type: "error",
          active: true
        })
      })
  }
</script>

<style scoped>

</style>
