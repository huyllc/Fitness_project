<template>
    <div class="course" :class="{'course-light': isLight}">
        <div class="course-image position-relative">
            <img :src="course.thumbnail ?? 'https://plus.unsplash.com/premium_photo-1664109999537-088e7d964da2?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'" class="image-main img-fluid w-100" alt="">
            <img src="@/assets/images/bg-course.png" class="course-image-bg position-absolute" alt="">
        </div>
        <div class="course-review-info">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="course-coach mb-0">{{ course.trainer_name }}</h5>
                <div class="fw-medium d-flex align-items-center">
                    <span class="pe-1">
                        <svg width="26" height="20" viewBox="0 0 26 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.0609 8.36165C15.3548 8.36165 17.2144 6.71435 17.2144 4.68229C17.2144 2.65024 15.3548 1.00293 13.0609 1.00293C10.767 1.00293 8.90747 2.65024 8.90747 4.68229C8.90747 6.71435 10.767 8.36165 13.0609 8.36165Z" stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M19.2912 7.44198C21.0118 7.44198 22.4063 6.41175 22.4063 5.14237C22.4063 3.87299 21.0118 2.84277 19.2912 2.84277M6.8308 7.44198C5.11023 7.44198 3.7157 6.41175 3.7157 5.14237C3.7157 3.87299 5.11023 2.84277 6.8308 2.84277" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M13.061 18.4798C16.5019 18.4798 19.2912 16.8325 19.2912 14.8005C19.2912 12.7684 16.5019 11.1211 13.061 11.1211C9.62017 11.1211 6.83081 12.7684 6.83081 14.8005C6.83081 16.8325 9.62017 18.4798 13.061 18.4798Z" stroke="black" stroke-width="1.5"/>
                            <path opacity="0.5" d="M21.3679 16.6402C23.1892 16.2861 24.483 15.3902 24.483 14.3406C24.483 13.2911 23.1892 12.3952 21.3679 12.041M4.75402 16.6402C2.93272 16.2861 1.63892 15.3902 1.63892 14.3406C1.63892 13.2911 2.93272 12.3952 4.75402 12.041" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span>{{ course.enrollments }} Students</span>
                </div>
            </div>

            <div class="row justify-content-between align-items-start course-title">
                <div class="col-8">
                    <h3>{{ course.title }}</h3>
                </div>
                <div class="col-4 d-flex align-items-center justify-content-end">
                    <span>
                        <svg width="33" height="28" viewBox="0 0 33 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.14513 7.40486C5.20076 9.25358 4.11217 11.641 4.08217 14.1224C4.00827 19.7923 9.44596 24.4545 16.1061 24.4652C22.7568 24.4759 28.13 19.8893 28.13 14.229C28.13 8.6556 22.8977 4.12022 16.3879 3.9928C16.3513 3.99179 16.3148 3.99708 16.2806 4.00835C16.2464 4.01961 16.2152 4.03662 16.1889 4.05837C16.1626 4.08011 16.1417 4.10614 16.1275 4.1349C16.1133 4.16366 16.106 4.19457 16.1061 4.22578V8.68439" stroke="currentColor" stroke-opacity="0.9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.6895 15.4355L9.74217 9.41103C9.67373 9.32756 9.64198 9.22625 9.65248 9.12484C9.66299 9.02344 9.71508 8.92842 9.79964 8.85644C9.88419 8.78446 9.9958 8.74011 10.1149 8.73117C10.234 8.72222 10.353 8.74925 10.4511 8.80752L17.5277 13.0193C17.9617 13.2854 18.2553 13.6863 18.3448 14.1353C18.4343 14.5843 18.3126 15.0452 18.006 15.4183C17.6995 15.7915 17.2326 16.0469 16.7066 16.1294C16.1805 16.2118 15.6374 16.1146 15.1949 15.8588C14.9992 15.7433 14.8283 15.6001 14.6895 15.4355Z" fill="currentColor" fill-opacity="0.9"/>
                        </svg>
                    </span>
                    <span>{{ course.duration }} M</span>
                </div>
            </div>

            <div>
                <ul class="course-rating d-flex flex-column gap-2">
                    <li>
                        Rating: 
                        <span>
                            <img src="@/assets/images/star-icon.svg" alt="">
                        </span>
                    </li>
                    <li>
                        Difficulty: Medium
                    </li>
                </ul>
            </div>

            <div class="course-actions row g-1">
                <div class="col-5">
                    <router-link class="d-block w-100 text-center to-course" :to="{name: 'course_detail', params: {courseId: course.id}}">
                        <span>Learn More</span>
                    </router-link>
                </div>
                <div class="col-7">
                    <router-link class="d-block w-100 text-center to-trainer" :to="`pt-profile/${course.trainer_id}`">Trainer's Profile</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import {slugify} from '../../utils/slugify'
    const props = defineProps({
        course: {
            type: Object,
            default: {
                'id': 1,
                'title': 'Yoga and Cardio',
                'duration': 2,
                'thumbnail': 'https://plus.unsplash.com/premium_photo-1664109999537-088e7d964da2?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'enrollments': 0,
                'trainer_name': 'John Cena',
                'trainer_id': 2
            }
        },

        isLight: {
            type: Boolean,
            default: false
        }
    })

    computed(() => slugify(props.course.title))
</script>

<style lang="scss">
.course{
    .course-image{
        height: 200px;
        margin-bottom: 15px;
        position: relative;
        z-index: 5;

        .image-main{
            height: 100%;
        }
    }

    .course-coach{
        position: relative;
        padding-left: 15px;

        &::before{
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            background: #FF4300;
            border-radius: 50%;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
        }
    }

    .course-actions{
        a{
            text-decoration: none;
            font-weight: 500;
            position: relative;
            padding: 8px 0;
            background: transparent;
            z-index: 10;

            span{
                position: relative;
                z-index: 10;
            }

            &::after{
                content: '';
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                transform: skew(-20deg);
            }

            &.to-course{
                color: #FFFFFF;

                &::after{
                    background: #FF4300;
                }
            }

            &.to-trainer{
                color: #000000;

                &::after{
                    border: 2px solid #000000;
                }
            }
        }
    }

    &.course-light{
        .course-actions{
            a{
                &.to-trainer{
                    color: #FFF;

                    &::after{
                        border: 2px solid #FFF;
                    }
                }
            }
        }
    }

    .course-image-bg{
        left: -5px;
        bottom: -5px;
        z-index: -1;
        width: calc(100% + 10px);
    }

    h3{
        min-height: 67px;
    }

    .course-rating{
        padding-left: 22px;
    }

    .course-title h3{
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-word;
        width: 100%;
        max-width: 100%;
    }

    &.course-light{
        color: #FFFF;
    }
}

</style>