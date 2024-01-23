import React, { FC } from 'react';
import Dropzone from 'react-dropzone';
import ErrorBoundary from '../../organisms/errorboundary';

export interface DropzoneAreaProps {
  files?: any;
}

const DropzoneArea: FC<React.PropsWithChildren<DropzoneAreaProps>> = (props: DropzoneAreaProps) => (
  <ErrorBoundary>
    <Dropzone onDrop={acceptedFiles => console.log(acceptedFiles)} multiple>
      {({ getRootProps, getInputProps }) => (
        <section className="dropzone">
          <div {...getRootProps()}>
            <input {...getInputProps()} />
            <p>Drag &qout;n&qout; drop some files here, or click to select files</p>
          </div>
        </section>
      )}
    </Dropzone>
  </ErrorBoundary>
);
export default DropzoneArea;
