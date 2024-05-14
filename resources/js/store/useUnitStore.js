import { defineStore } from 'pinia';
import service from '@/services/UnitService';

const useUnitStore = defineStore('units', {
  state: () => ({
    units: [],
    unit: null,
    errors: null,
  }),
  getters: {
    getUnits() {
      return this.units;
    },
    getUnit() {
      return this.unit;
    },
    getErrors() {
      return this.errors;
    },
  },
  actions: {
    async list(params) {
      const data = await service.index(params);
      this.units = data;
    },
    async consult(id) {
      const { data } = await service.get(id);
      this.unit = data;
    },
    async store(params) {
      try {
        this.errors = null;
        return await service.store(params);
      } catch (error) {
        this.errors = error.response.data.errors;
        throw error;
      }
    },
    async update(id, params) {
      try {
        this.errors = null;
        return await service.update(id, params);
      } catch (error) {
        this.errors = error.response.data.errors;
        throw error;
      }
    },
    async destroy(id) {
      await service.destroy(id);
    },
  },
});

export default useUnitStore;
