import GlobalVars from '../../../globalvars';
import http from './http-common';

class FileUploadService {
  upload(file, onUploadProgress) {
    const formData = new FormData();
    formData.append('file', file);
    return http.post(`${GlobalVars.JSDomain()}/api/admin/images/uploader`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      onUploadProgress,
    });
  }

  remolteUpload(file, onUploadProgress) {
    const formData = new FormData();
    formData.append('external_url', file);
    return http.post(`${GlobalVars.JSDomain()}/api/admin/images/remolte`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      onUploadProgress,
    });
  }

  getFiles() {
    return http.get(`${GlobalVars.JSDomain()}/files`);
  }
}
export default new FileUploadService();
