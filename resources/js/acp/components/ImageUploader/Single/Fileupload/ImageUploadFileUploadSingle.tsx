import React, { useState } from 'react';
import Button from '../../../../../component/atoms/Buttons/Button';
import DIV from '../../../../../component/atoms/Typography/DIV';
import ErrorBoundary from '../../../../../component/organisms/errorboundary';
import { ImageUploadFileUploadSingleProps } from '../../../../../props/props';
import UploadService from '../../../services/file-upload';
import ImageUploaderImageList from '../../components/ImageList/ImageList';
import ImageUploadMessages from '../../components/Message/Message';
import ImageUploaderPreview from '../../components/Preview/Preview';
import ImageUploadProgressInfo from '../../components/ProgressInfo/ProgressInfo';

const ImageUploadFileUploadSingle: React.FC<
  React.PropsWithChildren<ImageUploadFileUploadSingleProps>
> = (props: ImageUploadFileUploadSingleProps): JSX.Element => {
  const [currentFile, setCurrentFile] = useState<any>(null);
  const [previewImage, setPreviewImage] = useState<any>(null);
  const [progress, setProgress] = useState<any>(0);
  const [uploadMessage, setUploadMessage] = useState<any>(null);
  const [imageInfos, setImageInfos] = useState<any>(null);

  function selectFile(e) {
    setCurrentFile(e.target.files[0]);
    setPreviewImage(URL.createObjectURL(e.target.files[0]));
    setProgress(0);
    setUploadMessage('');
  }

  function upload() {
    setProgress(0);
    UploadService.upload(currentFile, event => {
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
          <label className="form-label">Bildaussuchen</label>
          <div className="controls">
            <input
              type="file"
              accept="image/*"
              onChange={e => selectFile(e)}
              className="form-control"
            />
          </div>
        </div>
        <div className="form-group">
          <div className="controls">
            <Button label="Upload" className="btn btn-success btn-sm" onClick={() => upload()} />
          </div>
        </div>
        <ImageUploadProgressInfo progress={progress} currentFile={currentFile} />
        <ImageUploaderPreview image={previewImage} />
        <ImageUploadMessages message={uploadMessage} />
        <ImageUploaderImageList imageInfos={imageInfos} />
      </div>
    </ErrorBoundary>
  );
};
export default ImageUploadFileUploadSingle;
