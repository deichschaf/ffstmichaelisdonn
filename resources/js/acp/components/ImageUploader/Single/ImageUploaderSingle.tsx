import React, { useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import ErrorBoundary from '../../../../component/organisms/errorboundary';
import { ImageUploaderSingleProps } from '../../../../props/props';
import ImageUploadExternalSingle from './External/ImageUploadExternalSingle';
import ImageUploadFileUploadSingle from './Fileupload/ImageUploadFileUploadSingle';

const ImageUploaderSingle: React.FC<React.PropsWithChildren<ImageUploaderSingleProps>> = (
  props: ImageUploaderSingleProps,
): JSX.Element => {
  const [showSingleFilieUpload, setShowSingleFilieUpload] = useState(false);
  const [showSingleExternalUpload, setShowSingleExternalUpload] = useState(false);
  const [images, setImages] = useState<any>(null);

  function showAnotherUploadArea(area) {
    if (area === 'external') {
      setShowSingleExternalUpload(true);
      setShowSingleFilieUpload(false);
    } else {
      setShowSingleExternalUpload(false);
      setShowSingleFilieUpload(true);
    }
  }

  return (
    <ErrorBoundary>
      <div className="Image--Uploader--Single--Area">
        <div className="Image--Uploader--Single--Switch">
          <Row>
            <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6}>
              <div className="form-group">
                <div className="controls">
                  <button
                    className="btn btn-success btn-approve"
                    onClick={() => showAnotherUploadArea('files')}
                  >
                    Upload
                  </button>
                </div>
              </div>
            </Col>
            <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6}>
              <div className="form-group">
                <div className="controls">
                  <button
                    className="btn btn-success btn-approve"
                    onClick={() => showAnotherUploadArea('external')}
                  >
                    getUrl
                  </button>
                </div>
              </div>
            </Col>
          </Row>
        </div>
        {showSingleFilieUpload ? <ImageUploadFileUploadSingle /> : ''}
        {showSingleExternalUpload ? <ImageUploadExternalSingle /> : ''}
      </div>
    </ErrorBoundary>
  );
};
export default ImageUploaderSingle;
