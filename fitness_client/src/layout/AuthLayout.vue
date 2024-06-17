<template>
    <PageLayout :pageClass="`page-auth ${pageClass}`">
        <HeaderAuth />
        <main class="page-main flex-grow-1">
            <div class="auth-main position-relative">
                <img src="@/assets/images/auth-bg.png" alt="" class="vh-100 w-100">
                <div class="position-absolute form-auth">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <slot name="title"/>
                    </div>
                    <slot name="form"/>
                </div>
            </div>
        </main>
    </PageLayout>
</template>

<script setup>
import PageLayout from './PageLayout.vue'
import HeaderAuth from '../components/Auth/HeaderAuth.vue'
import {ref} from 'vue'

const pageClass = ref({
    type: String,
    default: ''
})
</script>

<style lang="scss">
.page-auth{
    .page-header{
        top: 50px;
        right: unset;
    }
}

.auth-main{
    .form-auth{
        top: 50%;
        transform: translateY(-50%);
        right: 20px;
        padding: 77px 44px;
        background: rgba(255,255,255,0.75);
        border-radius: 40px;
        width: 450px;
    }
}
</style>