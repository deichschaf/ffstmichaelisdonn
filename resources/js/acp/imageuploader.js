(function () {
  const fileCatcher = document.getElementById('file-catcher');
  const fileInput = document.getElementById('file-input');
  const fileListDisplay = document.getElementById('file-list-display');
  const file_upload_percent = document.getElementById('file_upload_percent');

  const upload_successful = document.getElementById('upload_successful');
  const upload_error = document.getElementById('upload_error');

  let fileList = [];
  let renderFileList;
  let sendFile;

  renderFileList = function () {
    fileListDisplay.innerHTML = '';
    fileList.forEach((file, index) => {
      const fileDisplayEl = document.createElement('p');
      fileDisplayEl.innerHTML = `${index + 1}: ${file.name}`;
      fileListDisplay.appendChild(fileDisplayEl);
    });
  };

  sendFile = function (file, count) {
    const formData = new FormData();
    const request = new XMLHttpRequest();
    console.log(file.name);
    const box = document.createElement('div');
    box.setAttribute('id', `fileupload_${count}`);
    box.innerHTML = `${file.name}: `;
    const perc = document.createElement('span');
    perc.setAttribute('id', `fileupload_span_${count}`);
    box.appendChild(perc);
    file_upload_percent.appendChild(box);
    request.upload.onprogress = function (e) {
      const percentUpload = Math.floor((100 * e.loaded) / e.total);
      perc.innerHTML = `${percentUpload}% geladen`;
    };
    fileListDisplay.innerHTML = '';

    formData.set('file', file);
    formData.set('mandant_id', window.mandant_id);
    request.open('POST', window.UploadUrl, true);
    request.setRequestHeader('X-CSRF-TOKEN', window.csrf_token);
    request.onload = function () {
      const response = JSON.parse(request.responseText);
      if (response.error != '') {
        upload_error.innerHTML += response.error;
        let errorlog = '';
        for (let i = 0; i <= response.error.length - 1; i++) {
          if (errorlog != '') {
            errorlog += '<br />';
          }
          errorlog += response.error[i];
        }
        if (errorlog != '') {
          upload_error.innerHTML = `${upload_error.innerHTML}<div>${errorlog}</div>`;
        }
        document.getElementById('show_error').style.display = 'block';
      }
      if (response.success != '') {
        let successlog = '';
        for (let i = 0; i <= response.success.length - 1; i++) {
          if (successlog != '') {
            successlog += '<br />';
          }
          successlog += response.success[i];
        }
        upload_successful.innerHTML = `${upload_successful.innerHTML}<div>${successlog}</div>`;
        document.getElementById('show_success').style.display = 'block';
      }
    };
    request.send(formData);
  };

  fileCatcher.addEventListener('submit', evnt => {
    evnt.preventDefault();
    const i = 0;
    fileList.forEach((file, i) => {
      sendFile(file, i);
      i++;
    });
  });

  fileInput.addEventListener('change', evnt => {
    fileList = [];
    for (let i = 0; i < fileInput.files.length; i++) {
      fileList.push(fileInput.files[i]);
    }
    renderFileList();
  });
})();
