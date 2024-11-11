import http from './AxiosClient';
const route = 'api/v1/permissions';

const index = async () => {
  const { data } = await http.get(route);
  return data;
};

export default {
  index,
};
