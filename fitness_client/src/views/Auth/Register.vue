<template>
    <AuthLayout>
        <template #title>
            <h1>Sign Up</h1>
        </template>

        <template #form>
            <form action="" class="form-group" method="POST" @submit.prevent="handleRegister($event)">
                <div class="mb-3">
                    <label for="" class="form-label">Enter your name</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control"
                        :class="{'is-invalid': errors.name !== undefined && errors.name.length > 0}"
                        v-model="userData.name"
                    >
                    <div class="invalid-feedback" v-if="errors.name !== undefined && errors.name.length > 0">
                        <p class="mb-1" v-for="(message,index) in errors.name" :key="index">{{ message }}</p>
                    </div>
                </div>
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
                <div class="mb-3">
                    <label for="" class="form-label">Choose you are:</label>
                    <select class="form-select" aria-label="Default select example" v-model="userData.role">
                        <option selected value="student">User</option>
                        <option value="pt">Coach</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger w-100">Sign Up</button>
            </form>
        </template>

    </AuthLayout>
</template>

<script setup>
    import AuthLayout from '@/layout/AuthLayout.vue'
    import { ref } from 'vue'
    import axios from 'axios';
    import { useRouter } from "vue-router";
    import { useStore } from 'vuex';
    const userData = ref({
        email : '',
        password: '',
        name: '',
        role: 'student'
    })

    const errors = ref({
        email: [],
        password: [],
        nane: []
    })

    const store = useStore();
    const router = useRouter();

    const handleRegister = async (e) => {
        e.preventDefault();

        try{
            const response = await axios.post('user/register', userData.value);

            if (response.data.errors) {
                errors.value =  response.data.errors;
                return null;
            } 
            
            const access_token = response.data.access_token;
            const c_user =  response.data.c_user;
            const user_type = response.data.user_type
            const expirationDate = new Date();
            expirationDate.setDate(expirationDate.getDate() + 7);

            document.cookie = `authToken=${access_token};expires=${expirationDate.toUTCString()};path=/`;
            document.cookie = `c_user=${c_user};expires=${expirationDate.toUTCString()};path=/`;
            document.cookie = `user_type=${user_type};expires=${expirationDate.toUTCString()};path=/`;
            
            store.dispatch('setIsAuth');
            store.dispatch('fetchUserProfile');
            router.push('/');
            store.dispatch("setToast", {
                content: "Register success",
                show: true,
                type: "success",
            });
        } catch (error) {
            if (error.response.data.errors) {
                errors.value = error.response.data.errors;
            }
        }
    }
</script>
