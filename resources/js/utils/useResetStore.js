import { getActivePinia } from 'pinia';

export function useResetStore() {
  const pinia = getActivePinia();

  if (!pinia) {
    throw new Error('There is no active Pinia instance');
  }

  const clearAll = () => {
    Object.values(pinia.state.value).forEach((state) => {
      const store = pinia._s.get(state.$id);
      if (store) {
        store.$reset();
      }
    });
  };

  return { clearAll };
}
