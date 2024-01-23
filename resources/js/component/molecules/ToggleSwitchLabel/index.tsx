import React from 'react';
import { ToggleSwitchProps } from '../../../props/props';
import Input from '../../atoms/Form/Input/Input';
import ToggleSwitch from '../../atoms/Form/ToggleSwitch';
import ErrorBoundary from '../../organisms/errorboundary';

const ToggleSwitchLabel: React.FC<React.PropsWithChildren<ToggleSwitchProps>> = (
  props: ToggleSwitchProps,
): JSX.Element => (
  <ErrorBoundary>
    <div className="form-group">
      <label className="form-label">
        {typeof props.label !== 'undefined' && props.label !== '' ? `${props.label}:` : ''}
      </label>
      <div className="controls">
        <ErrorBoundary>
          <ToggleSwitch name={props.name} checked={props.checked} />
        </ErrorBoundary>
      </div>
    </div>
  </ErrorBoundary>
);
export default ToggleSwitchLabel;
