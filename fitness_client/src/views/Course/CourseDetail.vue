<template>
    <MainLayout :pageClass="'page-course-detail'">
        <div class="app-container">
            <div class="row">
                <div class="col-8">
                    <div class="d-flex flex-column">
                        <div class="course-info">
                            <h1 class="course-name">{{ courseDataComputed.title }}</h1>
                            <strong class="course-level d-block">Level: Medium</strong>
                            <strong class="course-time d-block">Duration: {{ courseDataComputed.duration }} months</strong>
                            <strong class="course-pt d-block">Taugh by {{ courseDataComputed.trainer_name }}</strong>
                        </div>
                        <div class="course-desc mb-5">
                            <h3>Course Description:</h3>
                            <p>{{ courseDataComputed.description }}</p>
                        </div>
                        <div class="course-reviews">
                            <h3 class="mb-4">Reviews</h3>
                            <span v-if="!isRegisted && reviewData.list.length < 1 "> No Review </span>
                            <ReviewList 
                                v-if="reviewData.list.length > 0"
                                :reviews="reviewData.list" 
                                @load-more="loadMoreReview" 
                                :loading="reviewData.loading"
                                :hideButton="reviewData.nomoreData"
                            />
                            <button v-if="isRegisted && reviewData.list.length < 1" type="button" class="p-0 bg-transparent btn-create-review" data-bs-toggle="modal" data-bs-target="#modal-review">
                                <span class="text-white">
                                    Create Review
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex flex-column">
                        <div class="course-action text-center">
                            <div class="course-feature-image mb-4">
                                <img class="img-fluid" :src="`${courseDataComputed.thumbnail}`" alt="">
                            </div>
                            <button 
                                class="btn btn-danger btn-register-course" 
                                @click="createEnrollment" 
                                v-if="!isRegisted && userType != 'pt'"
                            >
                                <span v-if="isLoading" class="d-block" style="min-width: 100px;">
                                    <span class="spinner-border" role="status" style="width: 25px; height: 25px">
                                        <span class="visually-hidden">Loading...</span>
                                    </span>
                                </span>
                                <span v-if="!isLoading">
                                    Register
                                </span>
                            </button>
                            <button 
                                class="btn btn-secondary btn-register-course" 
                                v-if="userType == 'pt'"
                                title="You can just register if you are student"
                            >
                                You can't register
                            </button>
                            <button v-else class="btn btn-secondary btn-register-course" v-if="isRegisted">Registed</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-review" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal Review</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ref="closeModal"></button>
                        </div>
                        <div class="modal-body">
                            <textarea class="w-100 p-2" rows="5" placeholder="Enter your review..." v-model="review.content"></textarea>
                            <div class="rating fs-3 d-flex gap-2 flex-row-reverse">
                                <span @click="setRatingReview(5)" :class="{ active: review.rate === 5 }">&#9733</span>
                                <span @click="setRatingReview(4)" :class="{ active: review.rate === 4 }">&#9733</span>
                                <span @click="setRatingReview(3)" :class="{ active: review.rate === 3 }">&#9733</span>
                                <span @click="setRatingReview(2)" :class="{ active: review.rate === 2 }">&#9733</span>
                                <span @click="setRatingReview(1)" :class="{ active: review.rate === 1 }">&#9733</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-submit-review px-3" @click="handleSubmitReview">Sent Review</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</MainLayout>
</template>

<script setup>
    import MainLayout from '@/layout/MainLayout.vue'
    import CourseReview from '@/components/Course/CourseReview.vue'
    import ReviewList from '@/components/Reviews/ReviewList.vue'
    import { getCookie } from '@/utils/cookie'
    import axios from 'axios'
    import { useRouter, useRoute } from 'vue-router'
    import { useStore } from 'vuex'
    import { ref, computed, onBeforeMount, defineProps } from 'vue'
    const props = defineProps({
        courseId: ''    
    })
    const store = useStore()
    const router = useRouter()
	const route = useRoute()

    const enrollmentData = ref({
        student_id: getCookie('c_user'),
        course_id: route.params.courseId,
        enroll_at: new Date(),
        completed: false,
        completed_day: null,
        status: false
    })
    const courseData = ref({})
    const isRegisted = ref(false)
    const userType = getCookie('user_type')
    const reviewData = ref({
        list: [],
        nextPage: 1,
        loading: false,
        nomoreData: false
    })
    const review = ref({
        rate: null,
        content: '',
        course_id: props.courseId
    })
    const isLoading = ref(false)

    const closeModal = ref(null)
   
    const createEnrollment = async() => {
        if (!getCookie('authToken')) {
            return router.push('/account/login');
        }

        isLoading.value = true;

        try {
            const reponse = await axios.post('user/enrollment/store', enrollmentData.value);

            if (!reponse.error) {
                isRegisted.value = true;
                isLoading.value = false;
                store.dispatch('fetchUserProfile');
                
                store.dispatch('setToast', {
                    content: 'Congratulations, you have successfully registered for course',
                    show: true,
                    type: 'success'
                });
            }
        } catch (error) {
            console.log(error.response);
        }
    }

    const fetchCourse = async (id) => {
        try {
            const response = await axios.get(`course/${id}`);

            courseData.value = response.data.data;
        } catch (error) {
            if (error.response && error.response.status === 404) {
                router.push('/');
            } else {
                console.log(error.response);
            }
        }
    }

    const checkIsRegistered = async () => {
        const data = {
            courseId: route.params.courseId,
            userId: getCookie('c_user'),
        };

        try {
            const response = await axios.post('user/enrollment/check', data);

            if (response.data.status == 1){
                isRegisted.value = true;
            }
        } catch (error) {
            if (error.response && error.response.status === 404) {
                router.push('/');
            } else {
                console.log(error.response);
            }
        }
    }

    const fetchReview = async () => {
        reviewData.value.loading = true;

        try {
            const response = await axios.get(`review/course/${props.courseId}?page=${reviewData.value.nextPage}`);

            if (response.data) {
                reviewData.value.list = reviewData.value.list.concat(response.data.data);
                reviewData.value.nextPage = response.data.meta.current_page + 1;
                reviewData.value.loading = true;

                if (response.data.meta.current_page == response.data.meta.last_page) {
                    reviewData.value.nomoreData = true;
                }
            }
        } catch (error) {
            console.log(error);
        } finally {
            reviewData.value.loading = false;
        }
    }

    const loadMoreReview = () => {
        fetchReview();
    }

    const setRatingReview = (rating) => {
        review.value.rate = rating;
    }
    
    const handleSubmitReview = async () => {
        try {
            const response = await axios.post('review/store', review.value);

            if (!response.data.error) {
                closeModal.value.click();
                review.value.content = '';
                review.value.rate = null;

                store.dispatch('setToast', {
                    content: response.data.message,
                    type: 'success',
                    show: true,
                    expires: 0
                });
            }
        } catch (err) {
            throw new Error(err);
        }
    }

    
    onBeforeMount (() => {
        fetchCourse(props.courseId);
        checkIsRegistered();
        fetchReview();
    })

    const courseDataComputed = computed(() => courseData.value);

</script>

<style lang="scss">
.course-info{
    margin-bottom: 90px;
}

.btn-create-review{
    border: 0;
    outline: none;
    
    > span {       
        display: inline-block; 
        min-width: 185px;
        padding: 10px 0;
        background: url('@/assets/images/bg-button.svg') no-repeat center center / cover;
        position: relative;
        min-height: 40px;
    }
}

#modal-review{
    textarea{
        border: 1px solid #ccc;
        border-radius: 8px;
        resize: none;
    }

    .btn-submit-review{
        background: #ff4300;
        color: white;
    }

    .rating{
        span{
            cursor: pointer;
            transition: all 0.25s;

            &:hover{
                color: orange;
                transform: scale(1.2);

                & ~ span{
                    color: orange;
                    transform: scale(1.2);
                }
            }

            &.active {
                color: orange;
                transform: scale(1.2);

                & ~ span{
                    color: orange;
                    transform: scale(1.2);
                }
            }
        }
    }
}
</style>