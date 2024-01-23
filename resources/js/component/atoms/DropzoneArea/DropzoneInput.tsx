import React from 'react';
import Dropzone from 'react-dropzone';
import ErrorBoundary from '../../organisms/errorboundary';

function DropzoneInput(field: any) {
  return (
    <div>
      <ErrorBoundary>
        <Dropzone onDrop={acceptedFiles => console.log(acceptedFiles)} multiple>
          {({ getRootProps, getInputProps }) => (
            <section className="dropzone">
              <div {...getRootProps()}>
                <input {...getInputProps()} />
                <p>Drag &quot;n&quot; drop some files here, or click to select files</p>
              </div>
            </section>
          )}
        </Dropzone>
      </ErrorBoundary>
    </div>
  );
}

export default DropzoneInput;
