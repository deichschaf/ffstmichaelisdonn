import React, { useState } from 'react';
import Button from '../../../../../component/atoms/Buttons/Button';
import DropzoneInput from '../../../../../component/atoms/DropzoneArea/DropzoneInput';
import ErrorBoundary from '../../../../../component/organisms/errorboundary';
import { ImageUploadFileUploadMultibleProps } from '../../../../../props/props';
import UploadService from '../../../services/file-upload';
import ImageUploaderImageList from '../../components/ImageList/ImageList';
import ImageUploadMessages from '../../components/Message/Message';
import ImageUploaderPreview from '../../components/Preview/Preview';
import ImageUploadProgressInfo from '../../components/ProgressInfo/ProgressInfo';

const ImageUploadFileUploadMultible: React.FC<
  React.PropsWithChildren<ImageUploadFileUploadMultibleProps>
> = (props: ImageUploadFileUploadMultibleProps): JSX.Element => {
  const [progressInfos, setProgressInfos] = useState<any>(null);
  const [uploadMessage, setUploadMessage] = useState<any>(null);
  const [imageInfos, setImageInfos] = useState<any>(null);
  const [selectedFiles, setSelectedFiles] = useState<any>(null);
  const [previewImages, setPreviewImages] = useState<any>(null);

  function selectFiles(e) {
    const images = [];
    for (let i = 0; i < e.target.files.length; i += 1) {
      images.push(URL.createObjectURL(e.target.files[i]) as never);
    }
    setProgressInfos([]);
    setUploadMessage([]);
    setSelectedFiles(e.target.files);
    setPreviewImages(images);
  }

  function upload(idx, file) {
    const _progressInfos = [...progressInfos];

    UploadService.upload(file, event => {
      _progressInfos[idx].percentage = Math.round((100 * event.loaded) / event.total);
      setProgressInfos(_progressInfos);
    })
      .then(() => {
        const nextMessage = [...uploadMessage, `Uploaded the image successfully: ${file.name}`];
        setUploadMessage(nextMessage);
        return UploadService.getFiles();
      })
      .then(files => {
        setImageInfos(files.data);
      })
      .catch(() => {
        _progressInfos[idx].percentage = 0;
        const nextMessage = [...uploadMessage, `Could not upload the image: ${file.name}`];
        setProgressInfos(_progressInfos);
        setUploadMessage(nextMessage);
      });
  }

  function uploadImages() {
    const files = selectedFiles;
    const _progressInfos = [];

    for (let i = 0; i < files.length; i += 1) {
      // @ts-ignore
      _progressInfos.push({ percentage: 0, fileName: files[i].name });
    }
    setProgressInfos(_progressInfos);
    setUploadMessage([]);
    for (let i = 0; i < files.length; i += 1) {
      upload(i, files[i]);
    }
  }

  return (
    <ErrorBoundary>
      <div>
        <div className="form-group">
          <label className="form-label">Bildaussuchen</label>
          <div className="controls">
            <input
              type="file"
              accept="image/*"
              multiple
              onChange={e => selectFiles(e)}
              className="form-control"
            />
          </div>
        </div>
        <div className="form-group">
          <div className="controls">
            <Button
              label="Upload"
              className="btn btn-success btn-sm"
              onClick={() => uploadImages()}
            />
          </div>
        </div>

        <ErrorBoundary>
          <DropzoneInput name="bilder" />
        </ErrorBoundary>

        <ImageUploadProgressInfo progressInfos={progressInfos} />
        <ImageUploaderPreview images={previewImages} />
        <ImageUploadMessages messages={uploadMessage} />
        <ImageUploaderImageList imageInfos={imageInfos} />
      </div>
    </ErrorBoundary>
  );
};
export default ImageUploadFileUploadMultible;
