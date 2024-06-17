<template>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="mb-3">
                            <h3>Login</h3>
                        </div>
                        <form @submit.prevent="handleLogin($event)" class="form-group">
                            <div class="form-floating mb-3">
                                <input 
                                    name="email" 
                                    type="email" 
                                    class="form-control" 
                                    id="floatingInput" 
                                    v-model="email"
                                    :class="{'is-invalid': formErrorMessage.email !== undefined,}" 
                                />
                                <span v-if="formErrorMessage.email" class="text-danger">
                                    {{"*" + formErrorMessage.email}}
                                </span>
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input 
                                    name="password" 
                                    type="password" 
                                    class="form-control" 
                                    id="floatingPassword"
                                    v-model="password" :class="{'is-invalid': formErrorMessage.password !== undefined,}" 
                                />
                                <label for="floatingPassword">Password</label>
                                <span v-if="formErrorMessage.password" class="text-danger">
                                    {{"*" + formErrorMessage.password}}
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">
                                Đăng nhập
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from "vue";
    import { useRouter } from "vue-router";
    import axios from 'axios';

    const email = ref("");
    const password = ref("");
    const formErrorMessage = ref({});
    const router = useRouter();

    const handleLogin = async (e) => {
        e.preventDefault();

        try {
            const response = await axios.post("/admin/login", {
                email: email.value,
                password: password.value,
            });
            const adminToken = response.data.token;

            const expirationDate = new Date();
            expirationDate.setDate(expirationDate.getDate() + 7); // accessToken expires in 7 days

            document.cookie = `adminToken=${adminToken};expires=${expirationDate.toUTCString()};path=/`;
            document.cookie = `email=${email.value};expires=${expirationDate.toUTCString()};path=/`;
            router.push("/");
        } catch (error) {
            if (error.response.status == 422) {
                formErrorMessage.value = {};
                Object.keys(error.response.data.errors).forEach((key) => {
                    formErrorMessage.value[key] = error.response.data.errors[key][0];
                });
            } else {
                formErrorMessage.value.email = error.response.data.message;
                formErrorMessage.value.password = error.response.data.message;
            }
        }
    };
</script>