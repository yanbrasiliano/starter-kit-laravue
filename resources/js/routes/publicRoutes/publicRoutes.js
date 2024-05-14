const LoginPage = () => import('@pages/LoginPage.vue');
const ForgotPasswordPage = () => import('@pages/password/ForgotPassword.vue');
const ResetPasswordPage = () => import('@pages/password/ResetPassword.vue');
const RegisterPage = () => import('@pages/register/RegisterPage.vue');
const VerifyEmailPage = () => import('@pages/register/VerifyEmailPage.vue');

const publicRoutes = [
  {
    path: '',
    name: 'login',
    component: LoginPage,
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: '/esqueci-minha-senha',
    name: 'forgotPassword',
    component: ForgotPasswordPage,
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: '/resetar-senha',
    name: 'passwordReset',
    component: ResetPasswordPage,
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: '/cadastro',
    name: 'register',
    component: RegisterPage,
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: '/verificar-email',
    name: 'verifyEmail',
    component: VerifyEmailPage,
    meta: {
      requiresAuth: false,
    },
  },
];

export default publicRoutes;
