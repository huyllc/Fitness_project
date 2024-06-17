<template>
    <main-layout>
        <div class=" change-box mx-auto">
            <div class="border p-4">
                <h3 class="text-center mb-4">Change Password</h3>
                <form @submit.prevent="changePassword()">
                    <div class="container-fluid">
                        <div class="mt-2">
                            <label for="password">Password</label>
                            <input type="password" class="form-control mt-2" v-model="userProfile.password" />
                        </div>
                        <span v-if="errors.password" class="text-danger">
                            {{errors.password + ""}}
                        </span>
                        <div class="mt-2">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control mt-2" v-model="confirm_password" />
                        </div>
                        <span v-if="errors.confirm_password" class="text-danger">
                            {{errors.confirm_password + ""}}
                        </span>
                    </div>
                    <div class="show-all mt-3 text-center d-flex">
                        <div class="col-md-6 d-flex justify-content-end align-items-center pe-3">
                            <button type="submit" class="btn btn-success">Change</button>
                        </div>
                        <div class="col-md-6 d-flex justify-content-start align-items-center">
                            <router-link :to="{ path: '/' }" class="btn btn-danger shadow-none">
                                Cancel
                            </router-link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main-layout>
</template>


<script setup>
    import axios from 'axios';
    import { ref, computed } from 'vue';
    import { useStore } from 'vuex';
    import MainLayout from "../../layout/MainLayout.vue";

    const confirm_password = ref("");
    const errors = ref({});
    const store = useStore();

    const userProfile = computed(() => {
        return store.getters.getUserInfor;
    });

    /**
     * Update User Profile
     */
    const changePassword = async () => {
        try {
            const formData = new FormData();
            if (userProfile.value.password) {
                formData.append("password", userProfile.value.password);
            }
            formData.append("confirm_password", confirm_password.value);
            formData.append("_method", "put");

            const response = await axios.post(
                `user/change-pass/${userProfile.value.id}`,
                formData
            );
            if (userProfile.value.password && confirm_password.value){
                store.dispatch("setToast", {
                    content: "Change Password success",
                    show: true,
                    type: "success",
                });
            }
            userProfile.value.password = "";
            confirm_password.value = "";
            errors.value.password = "";
            errors.value.confirm_password = "";
            store.dispatch("fetchUserProfile");
        } catch (error) {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.details;
            }
        }
    };
</script>

<style scoped>
    .change-box {
        width: 500px;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
</style>