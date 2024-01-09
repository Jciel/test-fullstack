import {createRouter, createWebHistory, Router, RouteRecordRaw} from "vue-router";
import Login from "../views/Login.vue";
import ListProduct from "../views/ListProduct.vue";
import Resgister from "../views/Resgister.vue";
import {useAppStore} from "../stores/appStore.ts";

const routes: Array<RouteRecordRaw> = [
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Resgister
    },
    {
        path: '/list-products',
        name: 'ListProducts',
        component: ListProduct,
        meta: {
            auth: true
        }
    }
]

const index: Router = createRouter({
    history: createWebHistory(),
    routes
})

index.beforeEach((to, _from, next) => {
    if (to.meta?.auth) {
        const appStorage = useAppStore()

        if (!appStorage.getUserToken) {
            return next({name: 'Login'})
        } else {
            appStorage.checkToken().then(res => {
                if (res) {
                    return next()
                } else {
                    return next({name: 'Login'})
                }
            })
        }
    }
    return next()
})

export default index
