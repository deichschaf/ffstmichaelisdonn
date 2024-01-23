import React from 'react';
import ErrorBoundary from '../../../../../component/organisms/errorboundary';
import { IImageUploaderMessages } from '../../../../../props/props';

const ImageUploadMessages: React.FC<React.PropsWithChildren<IImageUploaderMessages>> = (
  props: IImageUploaderMessages,
): JSX.Element => {
  if (
    (props.message === null || props.message === undefined) &&
    (props.messages === null || props.messages === undefined)
  ) {
    return <></>;
  }
  if (props.message !== null && props.message !== undefined) {
    return (
      <ErrorBoundary>
        <div className="alert alert-secondary mt-3" role="alert">
          {props.message}
        </div>
      </ErrorBoundary>
    );
  }
  if (props.messages !== null && props.messages !== undefined) {
    if (props.messages.length > 0) {
      return (
        <ErrorBoundary>
          <div className="alert alert-secondary mt-2" role="alert">
            <ul>
              {props.messages.map((item, i) => (
                <li key={i}>{item}</li>
              ))}
            </ul>
          </div>
        </ErrorBoundary>
      );
    }
    return <></>;
  }
  return <></>;
};
export default ImageUploadMessages;
