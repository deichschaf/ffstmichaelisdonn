import React, { useState } from 'react';
import Button from '../../../../../component/atoms/Buttons/Button';
import DIV from '../../../../../component/atoms/Typography/DIV';
import ErrorBoundary from '../../../../../component/organisms/errorboundary';
import { ImageUploadExternalSingleProps } from '../../../../../props/props';
import UploadService from '../../../services/file-upload';
import ImageUploaderImageList from '../../components/ImageList/ImageList';
import ImageUploadMessages from '../../components/Message/Message';
import ImageUploadProgressInfo from '../../components/ProgressInfo/ProgressInfo';

const ImageUploadExternalSingle: React.FC<
  React.PropsWithChildren<ImageUploadExternalSingleProps>
> = (props: ImageUploadExternalSingleProps): JSX.Element => {
  const [currentFile, setCurrentFile] = useState<any>(null);
  const [previewImage, setPreviewImage] = useState<any>(null);
  const [progress, setProgress] = useState<any>(0);
  const [uploadMessage, setUploadMessage] = useState<any>(null);
  const [imageInfos, setImageInfos] = useState<any>(null);

  function selectFile(e) {
    setCurrentFile(e.target.value);
    setPreviewImage(URL.createObjectURL(e.target.value));
    setProgress(0);
    setUploadMessage('');
  }

  function upload() {
    setProgress(0);
    UploadService.remolteUpload(currentFile, event => {
      setProgress(Math.round((100 * event.loaded) / event.total));
    })
      .then(response => {
        setUploadMessage(response.data.message);
        return UploadService.getFiles();
      })
      .then(files => {
        setImageInfos(files.data);
      })
      .catch(err => {
        setProgress(0);
        setUploadMessage('Could not upload the image!');
        setCurrentFile(undefined);
      });
  }
  // @ts-ignore
  return (
    <ErrorBoundary>
      <div>
        <div className="form-group">
          <label className="form-label">External URL</label>
          <div className="controls">
            <input type="text" onChange={e => selectFile(e)} className="form-control" />
          </div>
        </div>
        <div className="form-group">
          <div className="controls">
            <Button label="Upload" className="btn btn-success btn-sm" onClick={() => upload()} />
          </div>
        </div>
        <ImageUploadProgressInfo progress={progress} currentFile={currentFile} />
        <ImageUploadMessages message={uploadMessage} />
        <ImageUploaderImageList imageInfos={imageInfos} />
      </div>
    </ErrorBoundary>
  );
};
export default ImageUploadExternalSingle;
