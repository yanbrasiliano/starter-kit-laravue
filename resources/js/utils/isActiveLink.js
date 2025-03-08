import { useRoute } from 'vue-router';

function isActiveLink(routeName) {
  const route = useRoute();
  return route.name === routeName ? 'active-link' : '';
}

export { isActiveLink };
