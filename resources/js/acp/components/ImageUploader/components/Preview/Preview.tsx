import React from 'react';
import ErrorBoundary from '../../../../../component/organisms/errorboundary';
import { IImageUploaderPreview } from '../../../../../props/props';

const ImageUploaderPreview: React.FC<React.PropsWithChildren<IImageUploaderPreview>> = (
  props: IImageUploaderPreview,
): JSX.Element => {
  if (
    (props.image === null || props.image === undefined) &&
    (props.images === null || props.images === undefined)
  ) {
    return <></>;
  }
  if (props.image !== null && props.image !== undefined) {
    return (
      <ErrorBoundary>
        <div className="uploader">
          <div className="uploader_preview">
            <img className="preview" src={props.image} alt="" />
          </div>
        </div>
      </ErrorBoundary>
    );
  }
  if (props.images !== null && props.images !== undefined) {
    return (
      <ErrorBoundary>
        <div className="uploader">
          {props.images.map((img, i) => (
            <div key={i} className="uploader_preview">
              <img className="preview" src={img} alt={`image-${i}`} />
            </div>
          ))}
        </div>
      </ErrorBoundary>
    );
  }
  return <></>;
};
export default ImageUploaderPreview;
