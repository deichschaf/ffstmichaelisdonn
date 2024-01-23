import React, { useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import ErrorBoundary from '../../../../component/organisms/errorboundary';
import { ImageUploaderMultibleProps } from '../../../../props/props';
import ImageUploadExternalMultible from './External/ImageUploadExternalMultible';
import ImageUploadFileUploadMultible from './Fileupload/ImageUploadFileUploadMultible';

const ImageUploaderMultible: React.FC<React.PropsWithChildren<ImageUploaderMultibleProps>> = (
  props: ImageUploaderMultibleProps,
): JSX.Element => {
  const [showMultibleFilieUpload, setShowMultibleFilieUpload] = useState(false);
  const [showMultibleExternalUpload, setShowMultibleExternalUpload] = useState(false);
  const [images, setImages] = useState<any>(null);
  function showAnotherUploadArea(area) {
    if (area === 'external') {
      setShowMultibleExternalUpload(true);
      setShowMultibleFilieUpload(false);
    } else {
      setShowMultibleExternalUpload(false);
      setShowMultibleFilieUpload(true);
    }
  }
  return (
    <ErrorBoundary>
      <div className="Image--Uploader--Multible--Area">
        <div className="Image--Uploader--Multible--Switch">
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
        {showMultibleFilieUpload ? <ImageUploadFileUploadMultible /> : ''}
        {showMultibleExternalUpload ? <ImageUploadExternalMultible /> : ''}
      </div>
    </ErrorBoundary>
  );
};
export default ImageUploaderMultible;
