import React from 'react';
import { LabelInputComponentProps } from '../../../../props/props';
import { mustRequired } from '../../../component_helper';
import ErrorBoundary from '../../../organisms/errorboundary';
import Input from '../Input/Input';
import Label from '../Label/Label';

const LabelInput: React.FC<React.PropsWithChildren<LabelInputComponentProps>> = (
  props: LabelInputComponentProps
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
            <Input
              value={props.value}
              name={props.name}
              placeholder={props.placeholder}
              className={`form-control ${props.className}`}
              onChange={e => setValue(e.target.value)}
              required={props.required}
              type="text"
            />
          </ErrorBoundary>
        </div>
      </div>
    </ErrorBoundary>
  );
};
export default LabelInput;
