import React from 'react';
import { LabelTextareaComponentProps } from '../../../../props/props';
import { mustRequired } from '../../../component_helper';
import ErrorBoundary from '../../../organisms/errorboundary';
import Label from '../Label/Label';
import Textarea from '../Textarea';

const LabelTextarea: React.FC<React.PropsWithChildren<LabelTextareaComponentProps>> = (
  props: LabelTextareaComponentProps,
): JSX.Element => {
  function setValue(value) {
    props.setParentValue(value);
  }

  let required = false;
  if (props.required === true) {
    required = true;
  }
  return (
    <ErrorBoundary>
      <div className="form-group">
        <Label
          className={`${props.labelClassName} form-label `}
          htmlFor={props.name}
          label={props.label + mustRequired(props)}
        />
        <div className="controls">
          <ErrorBoundary>
            <Textarea
              required={required}
              value={props.value}
              name={props.name}
              placeholder={props.placeholder}
              className={`form-control ${props.className}`}
              onChange={e => setValue(e.target.value)}
            />
          </ErrorBoundary>
        </div>
      </div>
    </ErrorBoundary>
  );
};
export default LabelTextarea;
