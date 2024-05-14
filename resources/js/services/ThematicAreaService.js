import http from './AxiosClient';
const route = 'api/v1/thematic_areas';

const index = async (params) => {
  const { data, status } = await http.get(route, {
    params,
  });
  return { pagination: data.meta, thematicAreas: data.data, status };
};

const get = async (id) => {
  const { data, status } = await http.get(`${route}/${id}`);

  return { thematicArea: data.data, status };
};

const store = async (params) => {
  const { data, status } = await http.post(route, params);
  return { data, status };
};

const update = async (id, params) => {
  const { data, status } = await http.put(`${route}/${id}`, params);
  return { data, status };
};

const destroy = async (id) => {
  await http.delete(`${route}/${id}`);
};

export default {
  index,
  store,
  update,
  get,
  destroy,
};
