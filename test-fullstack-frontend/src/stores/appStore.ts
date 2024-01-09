import { defineStore, StateTree } from "pinia";
import {AlertData, LoginData, RegisterData} from "../components/Types.ts";

// const urlApiBase = import.meta.env.VITE_API_BASE;
// const urlApi = import.meta.env.VITE_API;
export const useAppStore = defineStore('appStore', {
    state: (): StateTree => {
        return {
            user: {
                token: ""
            },
            products: [],

            alert: {
                title: "",
                message: "",
                type: "",
                active: false
            }
        }
    },

    getters: {
        getUser: (state: StateTree) => state.user,
        getUserToken: (state: StateTree) => state.user.token,
        getProducts: (state: StateTree) => state.products,
        getAlert: (state: StateTree) => state.alert,
    },

    actions: {
        login (dataLogin: LoginData) {
            return fetch("http://localhost:8080/v1/login", {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(dataLogin)
            }).then(async res => {
                if (res.status === 200) {
                    return res.json()
                }
                const data = await res.json()
                throw new Error(data.message)
            }).then(data => {
                this.$state.user.token = data.token
            }).catch(err => {
                throw err
            })
        },

        register (registerData: RegisterData) {
            return fetch("http://localhost:8080/v1/register", {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(registerData)
            }).then(async res => {
                if (res.status === 200) {
                    return res.json()
                }
                const data = await res.json()
                throw new Error(data.message)
            }).then(data => {
                this.$state.user.token = data.token
            }).catch(err => {
                throw err
            })
        },

        listAllProducts  () {
            return fetch("http://localhost:8080/v1/product/list", {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.$state.user.token}`
                }
            }).then(async res => {
                if (res.status === 200) {
                    return res.json()
                }
                const data = await res.json()
                throw new Error(data.message)
            }).then(data => {
                this.$state.products = data
            }).catch(err => {
                throw err
            })
        },

        checkToken () {
            return fetch("http://localhost:8080/v1/login", {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.$state.user.token}`
                }
            }).then(async res => {
                const data = await res.json()
                if (res.status === 200 && data.message === "Token is valid") {
                    return true
                }
                throw new Error(data.message)
            }).catch(err => {
                throw err
            })
        },

        alert (alertData: AlertData) {
            this.$state.alert = alertData
        }
    }
})
