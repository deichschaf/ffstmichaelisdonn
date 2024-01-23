import GlobalVars from '../../../globalvars';
import http from './http-common';

class ReciptSourceService {
  loadRecipeSourceData() {
    return http.get(`${GlobalVars.JSDomain()}/api/admin/rezeptquellen/list`);
  }

  loadSourceTypeData() {
    return http.get(`${GlobalVars.JSDomain()}/api/admin/rezeptquellen/listSources`);
  }
}

export default new ReciptSourceService();
