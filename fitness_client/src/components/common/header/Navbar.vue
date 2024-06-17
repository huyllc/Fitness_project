<template>
    <ul class="sections-nav nav nav-pills justify-content-lg-end" :class="{'is-show': isShowNav}" >
        <li class="nav-item">
            <router-link to="/" class="nav-link bg-transparent p-0 fw-bold text-uppercase" exact-active-class="active">
                Home
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/courses" class="nav-link bg-transparent p-0 fw-bold text-uppercase" exact-active-class="active">
                Courses
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/contact-us" class="nav-link bg-transparent p-0 fw-bold text-uppercase" exact-active-class="active">
                Contact us
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/faq" class="nav-link bg-transparent p-0 fw-bold text-uppercase" exact-active-class="active">
                FAQ
            </router-link>
        </li>
        <li class="nav-item" v-if="!isAuthenticated">
            <router-link to="/account/login" class="nav-link bg-transparent p-0 fw-bold text-uppercase" exact-active-class="active">
                Log In
            </router-link>
        </li>
        <li class="nav-item" v-if="isAuthenticated">
            <div class="position-relative link-auth-wrap">     
                <router-link to="#" class="nav-link bg-transparent p-0 fw-bold text-uppercase link-auth">
                    Account 
                </router-link>
                <div class="position-absolute d-flex flex-column list-link">
                    <router-link to="/change-pass" class="nav-link bg-transparent p-0 fw-bold text-uppercase link-auth">
                        Change Password
                    </router-link>
                    <router-link :to="{name: 'user-profile'}" class="nav-link bg-transparent p-0 fw-bold text-uppercase link-auth">
                        My Profile 
                    </router-link>
                    <router-link to="/account/mycourses" class="nav-link bg-transparent p-0 fw-bold text-uppercase link-auth">
                        My Courses
                    </router-link>
                    <span class="nav-link bg-transparent p-0 fw-bold text-uppercase link-auth" @click="logout">
                        Log Out
                    </span>
                </div>
            </div>
        </li>
        <li class="nav-item notification dropdown p-0" :data-notification="notificationRead" v-if="isAuthenticated">
            <div id="nabvarDropdown" class="nav-link p-0" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"  class="bi bi-bell-fill" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
                </svg>
            </div>
            <ul class="dropdown-menu p-0">
                <li class="d-inline-flex justify-content-between p-2 dropdown-item">
                    <span class="fs-7q">Notification</span>
                    <button type="button" @click.stop="maskAsRead()" class="readAll align-self-end text-decoration-none fw-light btn btn-link p-0">Mark Notifications as Read</button>
                </li>
                <div class="overflow-auto notification-item">
                    <li class="dropdown-item text-wrap py-2" v-if="notifications.length <= 0">
                        No notification
                    </li>
                    <li class="dropdown-item bg-info text-wrap py-2 border border-bottom" v-for="notification in notifications" :class="{'text-muted bg-white' : notification.read_at}"><span>{{notification.data.student_name + notification.data.message}}</span></li>
                </div>
            </ul>
        </li>
    </ul>
    <div class="bg-overlay" :class="{'is-show': isShowNav}" @click="toggleNavbar"></div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { getCookie, removeCookie } from '@/utils/cookie';
import router from '@/router';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
    const props = defineProps({
        isShowNav: {
            type: Boolean,
            default: false
        }
    })
    const u_router = useRouter()
    const store = useStore()
    const emit = defineEmits(['toggle-navbar'])
    const toggleNavbar = () => {
        emit('toggle-navbar');
    }
    const logout = async () => {
        try {
            const response = await axios.post('user/logout');

            if (!response.data.error) {
                removeCookie('accessToken');
                removeCookie('authToken');
                removeCookie('c_user');
                removeCookie('user_type');
                u_router.go(router.currentRoute);
            }
        } catch (err) {
            console.log(err);
        }
    }
    const maskAsRead = async() => {
        try{
            await axios.post('user/notifications/maskAsRead');
            await store.dispatch('fetchUserProfile')
        } catch(err) {
            console.log(err);
        }
    }
    const isAuthenticated = computed(() => store.getters.getIsAuth);
    const notifications = computed(() => store.getters.getNotifications);
    const notificationRead = computed(() => {
        return notifications.value.reduce((count, item) => {
            if (item.read_at === null)
                return count + 1;
            return count;
        }, 0);
    });
    
</script>

<style lang="scss">
.sections-nav{
    gap: 0 30px;

    .nav-link{
        position: relative;
        color: #FFFFFF;

        &:hover{
            color: #D43B3B;
        }

        &.active{
            &::after{
                content: '';
                position: absolute;
                width: 100%;
                height: 2px;
                background: #D43B3B;
                left: 0;
                bottom: -5px;
            }
        }
    }
}
.notification {
    position: relative;
    display: inline-block;
}
.notification::after {
    content: attr(data-notification);
    position: absolute;
    top: -6px;
    right: -10px;
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 0px 4px 0 4px;
    font-size: 13px;
    width: 20px;
    height: 20px;
    text-align: center;
}

.notification .dropdown-menu {
    min-width: 15rem;
}
.notification .dropdown-menu .dropdown-item {
    font-size: 13px;
}
.notification-item {
    max-height: 250px;
}
.readAll {
    font-size: 12px;
}
.link-auth-wrap{
    &:hover{
        .list-link{
            opacity: 1;
            visibility: visible;
        }
    }

    .list-link{
        right: 0;
        bottom: -10px;
        gap: 15px;
        transform: translateY(100%);
        background: #FFFFFF;
        width: max-content;
        padding: 10px 25px;
        border-radius: 10px;
        box-shadow: 0 10px 10px rgba(0,0,0,0.3);
        opacity: 0;
        visibility: hidden;
        transition: all 0.35s;

        a,span {
            color: #171717;
            cursor: pointer;
        }
    }
}

@media (max-width: 1024px) {  
    .sections-nav{
        gap: 0 20px;
    }
}

@media (max-width: 991px) {  
    .sections-nav{
        position: fixed;
        top: 0;
        bottom: 0;
        left: -150%;
        width: 50%;
        padding: 30px;
        flex-direction: column;
        gap: 30px 0;
        z-index: 30;
        background: #171717;
        transition: all 0.35s ease;

        &.is-show{
            left: 0;
        }
    }
}
</style>