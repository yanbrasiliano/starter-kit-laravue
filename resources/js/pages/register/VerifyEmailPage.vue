<script setup>
import useUser from '@/composables/User/useUser';
import { onMounted } from 'vue';
import { useRoute } from 'vue-router';
const { onVerifyEmail } = useUser();
const route = useRoute();

onMounted(async () => {
  const { expires, hash, id, signature } = route.query;
  await onVerifyEmail({ expires, hash, id, signature });
});
</script>
