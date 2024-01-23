import React, { useState } from 'react';
import ReactQuill from 'react-quill';
import { TextareaEditorProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const TextareaEditor: React.FC<React.PropsWithChildren<TextareaEditorProps>> = (
  props: TextareaEditorProps,
): JSX.Element => {
  const [value, setValue] = useState(props.value);
  return (
    <ErrorBoundary>
      <ReactQuill theme="snow" value={value} onChange={setValue} />
    </ErrorBoundary>
  );
};

export default TextareaEditor;
