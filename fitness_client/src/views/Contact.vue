<template>
    <main-layout>
        <div class="container">
            <div class="align-items-center justify-content-center">
                <h3 class="d-inline-block">Contact Us</h3>
                <div>
                    <form @submit.prevent="sendContact">
                        <div class="form-group row">
                            <div class="col-6 mt-2">
                                <label for="name">Name</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    class="form-control mt-2" 
                                    id="name" 
                                    placeholder="Your Name"
                                    v-model="form.name"
                                />				
                                <span v-if="errors.name" class="text-danger">
                                    {{ errors.name + ""}}
                                </span>
                            </div>
                            <div class="col-6 mt-2">
                                <label for="email">Email address</label>
                                <input 
                                    type="email" 
                                    class="form-control mt-2" 
                                    id="email"
                                    placeholder="Your Mail"
                                    v-model="form.email"
                                />
                                <span v-if="errors.email" class="text-danger">
                                    {{ errors.email + ""}}
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6 mt-2">
                                <label for="phone">Phone</label>
                                <input 
                                    type="tel" 
                                    name="phone" 
                                    class="form-control mt-2" 
                                    id="phone" 
                                    placeholder="Your Phone Number"
                                    v-model="form.phone"
                                />				
                                <span v-if="errors.phone" class="text-danger">
                                    {{ errors.phone + ""}}
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-12 mt-2">
                            <label for="detail">What's on your mind:</label>
                            <textarea 
                                style="height: 150px" 
                                type="detail" 
                                name="detail" 
                                id="detailInput"
                                class="form-control shadow-none mt-1"
                                placeholder="Send us a note and we’ll get back to you as quickly as possible"
                                v-model="form.message"
                            ></textarea>
                            <span v-if="errors.message" class="text-danger">
                                {{ errors.message + ""}}
                            </span>
                        </div>
                        <div class="show-all mt-3 text-center d-flex justify-content-center pb-3">
                            <div class="mt-3 " v-if="isLoading">
                                <Loading class="text-center" title="Sending..."> </Loading>
                            </div>
                            <div v-else class="col-md-12 d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main-layout>
</template>

<script setup>
import { useStore } from 'vuex';
import MainLayout from '../layout/MainLayout.vue';
import Loading from '@/components/Loading.vue';
import {ref} from 'vue'
import axios from 'axios';
    const store = useStore()
    const isLoading = ref(false)
    const errors = ref("")
    const form = ref({
        name: '',
        email: '',
        message: '',
        phone: '',
    })
    const sendContact = async () => {
        try {
            isLoading.value = true;
            
            const response = await axios.post(`/send-contact`, form.value);

            form.value = ref("")
            errors.value = "";
            store.dispatch('setToast', {
                content: "Send Message Successful",
                show: true,
                type: "success",
            });
        } catch (error) {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.details;
            }
        } finally {
            isLoading.value = false;
        }
    }
</script>

<style scoped>
    .btn{
        background: #ff4300;
        color: white;
    }
</style>
