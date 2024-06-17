import { createRouter, createWebHistory } from 'vue-router'
import { getCookie } from '@/utils/cookie';

const routes = [
	{
		path: '/',
		name: 'home',
		component: () => import('../views/HomPage.vue'),
	},
	{
		path: '/contact-us',
		name: 'contact',
		component: () => import('../views/Contact.vue'),
	},
	{
		path: '/faq',
		name: 'faq',
		component: () => import('../views/Faq.vue'),
	},
	{
		path: '/courses',
		name: 'listCourses',
		component: () => import('../views/ListPage.vue'),
		props: true
	},
	{
		path: '/account/mycourses',
		name: 'list_courses',
		component: () => import('../views/Account/ListCourse.vue'),
		meta: { requireAuth: true }
	},
	{
		path: '/account/mycourses/:courseId',
		name: 'mycourse_detail',
		component: () => import('../views/Student/CourseDetail.vue'),
		meta: { requireAuth: true },
		props: true
	},
	{
		path: '/account/login',
		name: 'login',
		component: () => import('../views/Auth/Login.vue'),
		meta: { checkAuthenticated: true }
	},
	{
		path: '/account/register',
		name: 'register',
		component: () => import('../views/Auth/Register.vue'),
	},
	{
		path: '/change-pass',
		name: 'change-pass',
		component: () => import('../views/User/Changepass.vue'),
		meta: { requireAuth: true },
	},
	{
		path: '/user-profile',
		name: 'user-profile',
		component: () => import('../views/User/UserProfile.vue'),
		meta: { requireAuth: true },
	},
	{
		path: '/pt-profile/:id',
		name: 'pt-profile',
		component: () => import('../views/User/PtProfile.vue'),
		props: true,
	},
	{
		path: '/course/create',
		name: 'createCourse',
		component: () => import('../views/Course/CreateCourse.vue'),
		meta: { requireAuth: true }
	},
	{
		path: '/course/:id/update',
		name: 'updateCourse',
		component: () => import('../views/Course/UpdateCourse.vue'),
		meta: { requireRolePt: true },
		meta: { requireAuth: true },
	},
	{
		path: '/course/:courseId',
		name: 'course_detail',
		component: () => import('../views/Course/CourseDetail.vue'),
		props: true
	},
	{
		path: '/account/student-management/course/:id',
		name: 'student-management',
		component: () => import('../views/Trainer/StudentManage.vue'),
		meta: { requireAuth: true }
	},
	{
		path: '/account/student-management/course/:courseId/student/:studentId',
		name: 'student-management-detail',
		component: () => import('../views/Trainer/StudentDetail.vue'),
		meta: { requireAuth: true },
		props: true
	},
	{
		path: '/search/',
		name: 'search',
		component: () => import('../views/Search/ListSearchCourse.vue'),
	},
	{
		path: '/:pathMatch(.*)*',
		name: 'not-found',
		component: () => import('@/views/404.vue')
	}
]

const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes,
	scrollBehavior(to, from, savedPosition) {
		window.scrollTo(0, 0);
	},
})

router.beforeEach((to, from, next) => {
	const checkAuthenticated = to.matched.some(record => record.meta.checkAuthenticated);
	const requireAuth = to.matched.some(record => record.meta.requireAuth);
	const requireRolePt = to.matched.some(record => record.meta.requireRolePt);
	const authToken = getCookie('authToken');

	if (checkAuthenticated) {
		if (authToken) {
			next({ name: 'home' });
		} else {
			next();
		}
	}

	if (requireAuth) {
		if (authToken) {
			next();
		} else {
			next({ name: 'login' });
		}
	}

	if (requireRolePt) {
		if (getCookie('user_type') != 'pt') {
			alert("You don't have access permission");
			from();
		} else {
			next();
		}
	}

	next();
});

export default router
