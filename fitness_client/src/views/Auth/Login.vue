<template>
    <AuthLayout>
        <template #title>
            <h1>Sign In</h1>
            <router-link to="/account/register" class="text-decoration-none link-nav">
                No Account ? <br/>Sign up
            </router-link>
        </template>

        <template #form>
            <form action="" class="form-group" method="POST" @submit.prevent="handleLogin($event)">
                <div class="mb-3">
                    <label for="" class="form-label">Enter your email</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control"
                        :class="{'is-invalid': errors.email !== undefined && errors.email.length > 0}"
                        v-model="userData.email"
                    >
                    <div class="invalid-feedback" v-if="errors.email !== undefined && errors.email.length > 0">
                        <p class="mb-1" v-for="(message,index) in errors.email" :key="index">{{ message }}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Enter your password</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-control"
                        :class="{'is-invalid': errors.password !== undefined  && errors.password.length > 0}"
                        v-model="userData.password"
                    >
                    <div class="invalid-feedback" v-if="errors.password !== undefined  && errors.password.length > 0">
                        <p class="mb-1" v-for="(message,index) in errors.password" :key="index">{{ message }}</p>
                    </div>
                </div>
                <button type="submit" class="btn btn-danger w-100">Sign In</button>
            </form>
        </template>

    </AuthLayout>
</template>

<script setup>
    import AuthLayout from '../../layout/AuthLayout.vue'
    import axios from 'axios';
    import {ref} from 'vue';
    import { useRouter } from "vue-router";
    import { useStore } from 'vuex';
    const userData = ref({
        email : '',
        password: ''
    })
    
    const errors = ref({
        email: [],
        password: []
    })

    const store = useStore();
    const router = useRouter();

    const handleLogin =  async (e) => {
        e.preventDefault();

        try{
            const response = await axios.post('user/login', userData.value);

            if (response.data.errors) {
                errors.value =  response.data.errors;
                return null;
            }

            const accessToken = response.data.access_token;
            const c_user =  response.data.c_user;
            const user_type =  response.data.user_type;

            const expirationDate = new Date();
            expirationDate.setDate(expirationDate.getDate() + 7);

            document.cookie = `authToken=${accessToken};expires=${expirationDate.toUTCString()};path=/`;
            document.cookie = `c_user=${c_user};expires=${expirationDate.toUTCString()};path=/`;
            document.cookie = `user_type=${user_type};expires=${expirationDate.toUTCString()};path=/`;

            store.dispatch('setIsAuth');
            store.dispatch('fetchUserProfile');

            router.push('/');
            store.dispatch("setToast", {
                content: "Login success",
                show: true,
                type: "success",
            });
        } catch (error) {
            errors.value = error.response.data.errors;
        }
    }
</script>

<style lang="scss">
.auth-main{
    .link-nav{
        color: #779341;

        &:hover{
            color: #D43B3B;
        }
    }
}
</style>
