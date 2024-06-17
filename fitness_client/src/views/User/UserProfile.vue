<template>
    <main-layout>
        <div class="container">
            <div class="align-items-center justify-content-center">
                <h3 class="d-inline-block">Edit Profile</h3>
                <form @submit.prevent="updateUserProfile()">
                    <div class="form-group row">
                        <div class="col-6 mt-2">
                            <label for="name">Name</label>
                            <input 
                                type="name" 
                                name="name" 
                                class="form-control mt-2" 
                                id="name" 
                                placeholder="Your Name"
                                v-model="userProfile.name" 
                            />
                            <span v-if="errors.name" class="text-danger">
                                {{errors.name + ""}}
                            </span>
                        </div>
                        <div class="col-6 mt-2">
                            <label for="exampleFormControlInput1">Email address</label>
                            <input 
                                type="email" 
                                class="form-control mt-2" 
                                id="email" 
                                readonly
                                :value="userProfile.email" 
                            />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6 mt-3">
                            <label for="checkbox">Sex: </label>
                            <div class="check-box">
                                <div class="form-check form-check-inline mt-3">
                                    <input 
                                        class="form-check-input" 
                                        type="radio" 
                                        id="inlineRadio1" 
                                        value="0"
                                        v-model="userProfile.user_sex" 
                                    />
                                    <label class="form-check-label" for="inlineRadio1">Male</label>
                                </div>
                                <div class="form-check form-check-inline mt-3">
                                    <input 
                                        class="form-check-input" 
                                        type="radio"
                                        id="inlineRadio2" 
                                        value="1"
                                        v-model="userProfile.user_sex" 
                                    />
                                    <label class="form-check-label" for="inlineRadio2">Female</label>
                                </div>
                            </div>
                            <span v-if="errors.user_sex" class="text-danger">
                                {{errors.user_sex + ""}}
                            </span>
                        </div>
                        <div class="col-6 mt-2">
                            <label for="date" class="mt-2">Birthday: </label>
                            <div class="input-group date mt-2" id="datepicker">
                                <input 
                                    type="date" 
                                    class="form-control shadow-none" 
                                    id="datepicker1"
                                    placeholder="dd-mm-YYYY" 
                                    v-model="userProfile.user_birthday" 
                                />
                            </div>
                            <span v-if="errors.user_birthday" class="text-danger">
                                {{errors.user_birthday + ""}}
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 mt-2">
                            <label for="picture">Picture</label>
                            <div class="d-flex mt-2"
                                style="width: 100%">
                                <img 
                                    v-if="imageUrl" 
                                    :src="imageUrl" 
                                    class="logo-img" 
                                    style="height: 100px; width: auto"
                                    @click="openFileInput" 
                                />
                                <img 
                                    v-else :src="userProfile.user_picture" 
                                    class="logo-img"
                                    style="height: 100px; width: auto" 
                                    @click="openFileInput" />
                                <input 
                                    type="file" 
                                    ref="fileInput" 
                                    style="display: none" 
                                    accept="image/*"
                                    @change="handleFileInputChange" 
                                />
                            </div>
                        </div>
                        <span v-if="errors.picture" class="text-danger">
                            {{errors.user_picture + ""}}
                        </span>
                    </div>
                    <div class="form-group col-12">
                        <label for="detail" class="mt-2">Description:</label>
                        <textarea 
                            style="height: 150px" 
                            type="detail" 
                            name="detail" 
                            id="detailInput"
                            class="form-control shadow-none mt-1" 
                            v-model="userProfile.user_description">
                        </textarea>
                    </div>
                    <div class="show-all mt-3 text-center d-flex pb-3">
                        <div class="col-md-6 d-flex justify-content-end align-items-center pe-3">
                            <button type="submit" class="btn btn-success">Save Change</button>
                        </div>
                        <div class="col-md-6 d-flex justify-content-start align-items-center">
                            <router-link :to="{ path: '/' }" class="btn btn-danger shadow-none">
                                Back Home
                            </router-link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main-layout>
</template>

<script setup>
    import MainLayout from "../../layout/MainLayout.vue";
    import { ref, watch, computed } from "vue";
    import { useStore } from 'vuex';
    import axios from "axios";

    const imageFile = ref({});
    const imageUrl = ref("");
    const errors = ref({});
    const store  = useStore();
    const fileInput = ref(null);
    

    const handleFileInputChange = (event) => {
        imageFile.value = event.target.files[0];
    }

    watch(imageFile, (current) => {
        if (!current) return;
        const fileReader = new FileReader();
        fileReader.readAsDataURL(current);
        fileReader.addEventListener("load", () => {
            imageUrl.value = fileReader.result;
        });
    });

    const userProfile = computed(() => {
        return store.getters.getUserInfor;
    });

    /**
     * Update User Profile
     */
    const updateUserProfile = async () => {
        try {
            const formData = new FormData();
            formData.append("name", userProfile.value.name);
            formData.append("email", userProfile.value.email);

            if (userProfile.value.user_sex !== null) {
                formData.append("user_sex", userProfile.value.user_sex);
            }

            if (userProfile.value.user_birthday) {
                formData.append("user_birthday", userProfile.value.user_birthday);
            }
            if (userProfile.value.user_description) {
                formData.append("user_description", userProfile.value.user_description);
            }
            formData.append("user_picture", imageFile.value);
            formData.append("_method", "put");

            const { data } = await axios.post(
                `user/${userProfile.value.id}`,
                formData
            );

            store.dispatch('setToast', {
                content: "Update Infor Succesful",
                show: true,
                type: "success",
            });

            errors.value.name = "";
            errors.value.user_birthday = "";
            errors.value.user_sex = "";
            errors.value.email = "";
            errors.value.user_picture = "";
            store.dispatch("fetchUserProfile");
        } catch (error) {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.details;
            }
        }
    };

    /**
     * Handle Input Image Click
     */
    const openFileInput = () => {
        fileInput.value.click();
    }
    
</script>