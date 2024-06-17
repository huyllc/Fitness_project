<template>
    <header class="page-header">
        <div class="d-flex justify-content-between">
            <h2 class="text-uppercase fw-bold"></h2>
            <div class="d-flex justify-content-between align-items-center">
                <span class="image me-4"><img class="rounded-circle" src="../assets/images/DefaultAvatar.png" width="50"
                        height="50" /></span>
                <span class="role font-weight-normal fw-bolder me-4">Admin</span>
                <span class="icon"> </span>
                <div class="dropdown">
                    <button class="icon border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chevron-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                        </svg>
                    </button>
                    <ul class="dropdown-menu my-3">
                        <li class="dropdown-item ">
                            <router-link class="text-decoration-none m-0" to="/setting">
                                <span class="setting fw-normal">Settings</span>
                            </router-link>
                        </li>
                        <li><button class="dropdown-item" @click="logout">Logout</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { removeCookie } from '@/utils/cookie';
import router from '@/router';
import axios from 'axios';

const logout = async () => {
    try {
        const response = await axios.post('admin/user/logout');

        if (!response.data.error) {
            removeCookie('adminToken');
        }
        router.go(router.currentRoute.value);
    } catch (err) {
        console.log(err);
    }
};
</script>

<style lang="scss">
    .page-header {
        padding: 20px 20px 0;
        color: #12818a;
    }

    .role {
        color: black;
    }

    .icon {
        color: black;
        font-weight: bold;
        background: #fff;
    }

    .setting {
        color: black;
        padding: 0;
        text-decoration-line: none;
    }
</style>