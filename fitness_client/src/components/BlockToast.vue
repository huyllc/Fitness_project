<template>
    <div class="position-fixed toast-fixed end-0 p-2" :class="{'success': type === 'success'}" style="z-index: 99; bottom: 10px">
        <div class="toast" :class="`${show ? 'show' : 'hide'}`"role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header px-4">
                <div class="me-2" v-if="type === 'success'">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 48 48">
                        <path fill="#4caf50" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path><path fill="#ccff90" d="M34.602,14.602L21,28.199l-5.602-5.598l-2.797,2.797L21,33.801l16.398-16.402L34.602,14.602z"></path>
                    </svg>
                </div>
                <div class="me-2" v-else>
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 48 48">
                        <path fill="#F44336" d="M21.5 4.5H26.501V43.5H21.5z" transform="rotate(45.001 24 24)"></path><path fill="#F44336" d="M21.5 4.5H26.5V43.501H21.5z" transform="rotate(135.008 24 24)"></path>
                    </svg>
                </div>
                <strong class="me-auto fs-5">{{ title }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" @click="hideToast"></button>
            </div>
            <div class="toast-body bg-white fs-5 px-4">
                {{ text }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { useStore } from 'vuex';

    const store = useStore()
    const props = defineProps({
        title: {
            type: String,
            default: 'DevFast Fitness'
        },
        text: {
            type: String,
            default: 'Hello!'
        },
        show: {
            type: Boolean,
            default: false
        },
        type: {
            type: String,
            default: ''
        }
    })
    const hideToast = () => {
        store.dispatch('hideToast');
    }
</script>

<style lang="scss">
.toast-fixed {
    .toast-header{
        position: relative;

        &::before{
            content: '';
            position: absolute;
            width: 100%;
            height: 3px;
            background: red;
            left: 0;
            top: 0;
        }
    }

    &.success{
        .toast-header{
            &::before{
                background: #23D160;
            }
        }
    }

    .toast{
        &.show{
            .toast-header{
                &::before{
                    animation: toastSpin 3s linear forwards;
                }
            }
        }
    }
}

@keyframes toastSpin {
    0%{
        width: 100%;
    }100%{
        width: 0;
    }
}

</style>