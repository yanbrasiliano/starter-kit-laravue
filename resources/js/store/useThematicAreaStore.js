import { defineStore } from 'pinia';
import thematicAreaService from '@/services/ThematicAreaService';
import { format } from 'date-fns';

const useThematicAreaStore = defineStore('thematic_areas', {
  state: () => ({
    thematicAreas: [],
    thematicArea: {
      description: '',
    },
    pagination: {},
    loading: false,
    errors: null,
    message: null,
    params: null,
    isSuccess: false,
  }),
  getters: {
    getThematicAreasRows() {
      return this.thematicAreas;
    },
    getPagination() {
      return this.pagination;
    },
    getThematicArea() {
      return this.thematicArea;
    },
    getFormattedDate() {
      return this.thematicArea.createdAt
        ? format(this.thematicArea.createdAt, 'dd/MM/yyyy HH:mm')
        : '';
    },
  },
  actions: {
    async fetchThematicAreas(params) {
      try {
        this.loading = true;
        const { pagination, thematicAreas, status } =
          await thematicAreaService.index(params);
        if (status === 200) {
          this.thematicAreas = thematicAreas;
          this.pagination.rowsPerPage = pagination.per_page;
          this.pagination.page = pagination.current_page;
          this.pagination.rowsNumber = pagination.total;
          this.pagination.descending = pagination.descending;
        }
      } finally {
        this.loading = false;
      }
    },

    async fetchById(id) {
      try {
        this.loading = true;
        const { thematicArea, status } = await thematicAreaService.get(id);

        if (status === 200) {
          this.thematicArea = thematicArea;
        }
      } finally {
        this.loading = false;
      }
    },
    async store(params) {
      try {
        this.loading = true;
        this.message = null;

        const { data, status } = await thematicAreaService.store(params);
        if (status === 200) {
          this.message = data?.message || 'Área temática criada com sucesso!';
          this.isSuccess = true;
        }
      } catch (error) {
        this.isSuccess = false;
        this.errors = error.response.data.errors;
        throw error;
      } finally {
        this.loading = false;
      }
    },
    async update(id, params) {
      try {
        this.loading = true;
        const { data, status } = await thematicAreaService.update(id, params);
        if (status === 200) {
          this.message = data.message || 'Área temática atualizada com sucesso!';
          this.isSuccess = true;
        }
      } catch (error) {
        this.isSuccess = false;
        this.errors = error.response.data.errors;
        throw error;
      } finally {
        this.loading = false;
      }
    },
    async destroy(id) {
      await thematicAreaService.destroy(id);
    },

    resetStore() {
      this.thematicArea = {
        description: '',
      };
      this.isSuccess = false;
      this.message = null;
      this.errors = null;
    },
  },
});

export default useThematicAreaStore;
