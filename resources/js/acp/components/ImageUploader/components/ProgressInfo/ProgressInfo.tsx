import React, { CSSProperties } from 'react';
import DIV from '../../../../../component/atoms/Typography/DIV';
import ErrorBoundary from '../../../../../component/organisms/errorboundary';
import { IImageUploaderProgress } from '../../../../../props/props';

const ImageUploadProgressInfo: React.FC<React.PropsWithChildren<IImageUploaderProgress>> = (
  props: IImageUploaderProgress,
): JSX.Element => {
  function getProgressWidth(progress) {
    const width = `width: ${progress}%`;
    return width as CSSProperties;
  }

  if (
    (props.currentFile === null || props.currentFile === undefined) &&
    (props.progressInfos === null || props.progressInfos === undefined)
  ) {
    return <></>;
  }

  if (props.currentFile !== null && props.currentFile !== undefined) {
    return (
      <ErrorBoundary>
        <div className="progress my-3">
          <DIV
            className="progress-bar progress-bar-info progress-bar-striped"
            role="progressbar"
            aria-valuenow={props.progress as number}
            aria-valuemin={0}
            aria-valuemax={100}
            style={getProgressWidth(props.progress)}
          >
            {`${props.progress}%`}
          </DIV>
        </div>
      </ErrorBoundary>
    );
  }

  if (props.progressInfos !== null && props.progressInfos !== undefined) {
    return props.progressInfos.map((progressInfo, index) => (
      <ErrorBoundary key={index}>
        <div className="mb-2">
          <span>{progressInfo.fileName}</span>
          <div className="progress">
            <DIV
              className="progress-bar progress-bar-info"
              role="progressbar"
              aria-valuenow={progressInfo.percentage as number}
              aria-valuemin={0}
              aria-valuemax={100}
              style={getProgressWidth(progressInfo.percentage)}
            >
              {`${progressInfo.percentage}%`}
            </DIV>
          </div>
        </div>
      </ErrorBoundary>
    ));
  }

  return <></>;
};
export default ImageUploadProgressInfo;
